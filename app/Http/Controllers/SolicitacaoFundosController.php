<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Macro\AppBoot;
use App\Models\Issues;
use App\Models\Projects;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\ApprovementFlow;
use Symfony\Component\Yaml\Yaml;
use App\Models\SolicitacaoFundos;
use Illuminate\Support\Facades\DB;
use App\Models\AppApprovementFlows;
use App\Models\FlowSolicitacaoFundos;
use App\Models\OptionsSolicitacaoFundos;
use App\Models\ReprovacaoSolicitacaoFundos;
use App\Models\RubricasFlowSolicitacaoFundos;
use App\Policies\FlowSolicitacaoFundosPolicy;
use App\Models\PagamentosFlowSolicitacaoFundos;
use App\Http\Controllers\Helpers\AttachmentsHelper;
use App\Http\Controllers\Features\SolicitacaoFundos\FlowApprovementManager;
use App\Http\Controllers\Helpers\SolicitacaoFundos\HelperFormSolicitacaoFundos;
use App\Http\Controllers\Features\SolicitacaoFundos\SolicitacaoFundosRepository;
use App\Http\Controllers\Helpers\Orcamento\SolicitacaoDeFundosNotificationHelper;

class SolicitacaoFundosController extends Controller
{

    use AttachmentsHelper, SolicitacaoDeFundosNotificationHelper, HelperFormSolicitacaoFundos;

    public $solicitacaoFundos;
    public $flowApprovementManager;
    public $approvementFlow;

    public function __construct(
        SolicitacaoFundosRepository $solicitacaoFundos,
        FlowApprovementManager $flowApprovementManager,
        ApprovementFlow $approvementFlow
    ) {
        $this->solicitacaoFundos = $solicitacaoFundos;
        $this->flowApprovementManager = $flowApprovementManager;
        $this->approvementFlow = $approvementFlow;
    }

    public function index(Projects $project_identifier)
    {
        if (!auth()->user()->can('projectMember', [FlowSolicitacaoFundos::class, $project_identifier])) {
            abort(401);
        }

        $project = $project_identifier;
        return view('solicitacaoFundos.index', compact('project'));
    }

    public function store(Request $request, Projects $project_identifier)
    {

        if (!auth()->user()->can('projectMember', [FlowSolicitacaoFundos::class, $project_identifier])) {
            abort(401);
        }
            
        $user = User::where("id", auth()->user()->id)->with('member_roles')->firstOrFail();
        $userID = auth()->user()->id;
        if($user->member_roles[0]->member_roles->roles[0]->name == 'Facilitador Distrital'){
            $hasApprovementFlowToTrigger = $this->flowApprovementManager->existApprovementToTriggerInit($this->approvementFlow, $request->requestFundos['TypeSolicitacao'], "initial_flow");
        } else{
            $hasApprovementFlowToTrigger = $this->flowApprovementManager->existApprovementToTriggerInit($this->approvementFlow, $request->requestFundos['TypeSolicitacao'], "initial_flow", true);
        }
       
        
        $this->flowApprovementManager->validateData($request);
        try {

            DB::beginTransaction();

            $count_solicitacao = SolicitacaoFundos::count() + 1;
            $requestNum = str_pad("{$userID}U{$count_solicitacao}", 5, '0', STR_PAD_LEFT);

            // Gravar a solicitacao
            $solicitacaoFundos = new SolicitacaoFundos();
            $solicitacaoFundos->num_requisicao = date('Y') . "MASC" . $requestNum;
            $solicitacaoFundos->has_rubricas = 1;
            $solicitacaoFundos->objectivo = $request->requestFundos['objectivo'];
            $solicitacaoFundos->valor_estimado = $request->requestFundos['valor'];
            $solicitacaoFundos->area_id = 0;
            $solicitacaoFundos->activiade_id = 0;
            $solicitacaoFundos->necessidade_id = 0;
            $solicitacaoFundos->issue_id = $request->requestFundos['issueID'] ?? null;
            $solicitacaoFundos->pilar_id = $request->requestFundos['pilar'];
            $solicitacaoFundos->project_id = $project_identifier->id;
            $solicitacaoFundos->data = $request->requestFundos['data'];
            $solicitacaoFundos->local = $request->requestFundos['local'] ?? null;
            $solicitacaoFundos->num_participantes = $request->requestFundos['num_participantes'];
            $solicitacaoFundos->num_dias = $request->requestFundos['num_dais'];
            $solicitacaoFundos->type = $request->requestFundos['TypeSolicitacao'];
            $solicitacaoFundos->_osc = Yaml::dump(\explode(',', $request->requestFundos['ocs'] ?? ''));
            $solicitacaoFundos->request_by = auth()->user()->id;
            $solicitacaoFundos->created_on = now();
            $solicitacaoFundos->updated_on = now();
           
            $solicitacaoFundos->save(); // Save data into database
            
            if ($request->requestFundos['issueID'] !== null) {
                $issue = Issues::where('id', $request->requestFundos['issueID'])->first();
                $issue->solicitacao_fundos_id = $solicitacaoFundos->id;
                $issue->update(); // Save data into database
            }
           /* if ($request->requestFundos['rubrica'] !== null) {
                foreach ($request->requestFundos['rubrica'] as $key => $value) {
                    $this->storeRubircas($value, $solicitacaoFundos->num_requisicao);
                }
            }*/
            if ($request->requestFundos['rubrica'] !== null) {
                $this->storeRubircas($request->requestFundos['rubrica'], $solicitacaoFundos->num_requisicao, $project_identifier->id);
            }
            
            if ($request->requestFundos['areas'] !== null) {
                $this->storeOptionsData(
                    $request->requestFundos['areas'],
                    "areas",
                    $solicitacaoFundos->num_requisicao,
                    "IssueArea"
                );
            }
            
            if ($request->requestFundos['actividades'] !== null) {
                $this->storeOptionsData(
                    $request->requestFundos['actividades'],
                    "actividades",
                    $solicitacaoFundos->num_requisicao,
                    "IssueActividade"
                );
            }

            if ($request->requestFundos['necessidades'] !== null) {
                $this->storeOptionsData(
                    $request->requestFundos['necessidades'],
                    "necessidades",
                    $solicitacaoFundos->num_requisicao,
                    "IssueNecessidade"
                );
            }
            
            // Gravar documentos de suporte de solicitação de fundos
            if ($request->has('requestFundos.attachments')) {
                foreach ($request->requestFundos['attachments'] as $file_key_name => $files) {
                    if ($files != null || sizeof($files) > 0) {
                        foreach ($files as $file) {
                            $this->store_attachment($solicitacaoFundos->id, $file, "SolicitaçãoFundosAttachs", $file_key_name);
                        }
                    }
                }
            }
            
            $usersToApprove = $request->usersToApprove ?? null;

            /**
             * Se o valor for superior a 50 000 o fluxo vai para o
             * - @param idflowCat 28 - Validacao Programatica - Lider de Programas
             *
             * Caso < 50000 vai para - Validacao Programatica - Gestor de Projectos
             */
            
            // Gravar o fluxo da solicitacao para o user a aprovar e sua categoria
            $flowSolicitacaoFundos = $this->flowApprovementManager->storeTriggeredApprovementFlow(
                $hasApprovementFlowToTrigger->approvementFlow,
                $solicitacaoFundos,
                $project_identifier,
                $usersToApprove
            );

            DB::commit();

            return redirect()->route('orcamento.projecto.details-solicitacao_fundos', [
                'project_identifier' => $project_identifier->identifier,
                'requestNum' => $solicitacaoFundos->num_requisicao
            ])->with('success', 'Solicitação de Fundos - ' . __('lang.notice_successful_create') . "Referência: {$solicitacaoFundos->num_requisicao}");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Ocorreu um erro. Envie mais informação pelo tawlk para solicitar assistencia.');
            throw $th;
        }
    }

    public function updateRequisicao(Request $request, Projects $project_identifier, $requestNum)
    {
        // return $request;
        try {
            DB::beginTransaction();

            $requisicaoFundos = SolicitacaoFundos::where('num_requisicao', $requestNum)->where('is_rejected', true)->firstOrFail();

            $requisicaoFundos->objectivo = $request->requestFundos['objectivo'];
            $requisicaoFundos->valor_estimado = $request->requestFundos['valor'];
            $requisicaoFundos->data = $request->requestFundos['data'];
            $requisicaoFundos->local = $request->requestFundos['local'] ?? null;
            $requisicaoFundos->num_participantes = $request->requestFundos['num_participantes'];
            $requisicaoFundos->num_dias = $request->requestFundos['num_dais'];
            $requisicaoFundos->_osc = Yaml::dump(\explode(',', $request->requestFundos['ocs'] ?? ''));
            $requisicaoFundos->updated_on = now();

            $requisicaoFundos->update(); // Save data into database

            if ($request->requestFundos['issueID'] !== null) {
                $issue = Issues::where('id', $request->requestFundos['issueID'])->first();
                $issue->solicitacao_fundos_id = $requisicaoFundos->id;
                $issue->update(); // Save data into database
            }


            /*if ($request->requestFundos['rubricas'] !== null) {
                $this->storeRubircas($request->requestFundos['rubricas'], $requisicaoFundos->num_requisicao, true);
            }*/
            if ($request->requestFundos['rubrica'] !== null) {
                $this->storeRubircas($request->requestFundos['rubrica'], $requisicaoFundos->num_requisicao,$project_identifier->id, true);
            }

            if ($request->requestFundos['areas'] !== null) {
                $this->storeOptionsData(
                    $request->requestFundos['areas'],
                    $requisicaoFundos->num_requisicao,
                    "IssueArea",
                    true
                );
            }

            if ($request->requestFundos['actividades'] !== null) {
                $this->storeOptionsData(
                    $request->requestFundos['actividades'],
                    $requisicaoFundos->num_requisicao,
                    "IssueActividade",
                    true
                );
            }

            if ($request->requestFundos['necessidades'] !== null) {
                $this->storeOptionsData(
                    $request->requestFundos['necessidades'],
                    $requisicaoFundos->num_requisicao,
                    "IssueNecessidade",
                    true
                );
            }

            // Gravar documentos de suporte de solicitação de fundos
            if ($request->has('requestFundos.attachments')) {
                foreach ($request->requestFundos['attachments'] as $file_key_name => $files) {
                    if ($files != null || sizeof($files) > 0) {
                        foreach ($files as $file) {
                            $this->store_attachment($requisicaoFundos->id, $file, "SolicitaçãoFundosAttachs", $file_key_name);
                        }
                    }
                }
            }
            DB::commit();
            return back()->with('success', 'Solicitação de Fundos - ' . __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', "Desculpe ocorreu um erro ao processar o seu pedido.\n\r\tError Details: " . $th->getMessage());
            throw $th;
        }
    }

    /**
     * Displays form to create new budget requisition
     *
     * @return \Illuminate\Http\Response
     */
    public function form(\App\Models\Projects $project_identifier)
    {
        if (!auth()->user()->can('projectMember', [FlowSolicitacaoFundos::class, $project_identifier])) {
            abort(401);
        }

        $project = $project_identifier;
        return view('solicitacaoFundos._form', compact('project'));
    }

    /**
     * Editar requisicao de solicitacao
     */
    public function editForm(Projects $project_identifier, $requestNum)
    {
        if (!auth()->user()->can('projectMember', [FlowSolicitacaoFundos::class, $project_identifier])) {
            abort(401);
        }

        try {
            $requisicaoFundos = SolicitacaoFundos::where('num_requisicao', $requestNum)->where('is_rejected', true)->firstOrFail();
        } catch (\Throwable $th) {
            return back()->with('error', "Desculpe ocorreu um erro ao processar o seu pedido.\n\r\tError Details: " . $th->getMessage());
            throw $th;
        }

        $project = $project_identifier;
        return view('solicitacaoFundos._form', compact('project', 'requisicaoFundos'));
    }


    /**
     * Outputs do processo de solicitação
     *
     * @param \App\Models\Projects $project_identifier
     * @param string $requestNum
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function outputs(Projects $project_identifier, string $requestNum, int $requestID)
    {
        $areas = \App\Models\Enumerations::where('type', 'IssueArea')->get();
        $actividades = \App\Models\Enumerations::where('type', 'IssueActividade')->get();
        $necessidades = \App\Models\Enumerations::where('type', 'IssueNecessidade')->get();

        try {
            $solicitacaoFundos = SolicitacaoFundos::where('id', $requestID)->where('num_requisicao', $requestNum)->where('is_rejected', false)->firstOrFail();
        } catch (\Throwable $th) {
            throw $th;
        }
        $selected_areas = $solicitacaoFundos->areas()->get('enumeration_id')->pluck('enumeration_id')->toArray() ?? [];
        $selected_actividades = $solicitacaoFundos->actividades()->get('enumeration_id')->pluck('enumeration_id')->toArray() ?? [];
        $selected_necessidades = $solicitacaoFundos->necessidades()->get('enumeration_id')->pluck('enumeration_id')->toArray() ?? [];

        $data = \collect(
            [
                'settings' => AppBoot::application(),
                'solicitacao' => $solicitacaoFundos,
                'approvations' => [
                    '_programtica' => FlowSolicitacaoFundos::where('flow_id', 12)->where('num_requisicao',  $solicitacaoFundos->num_requisicao)
                        ->where('solicitacao_id', $solicitacaoFundos->id)->first(),
                    '_financeira' => FlowSolicitacaoFundos::where('flow_id', 13)->where('num_requisicao',  $solicitacaoFundos->num_requisicao)
                        ->where('solicitacao_id', $solicitacaoFundos->id)->first(),
                    '_contabilidade' => FlowSolicitacaoFundos::where('flow_id', 14)->where('num_requisicao',  $solicitacaoFundos->num_requisicao)
                        ->where('solicitacao_id', $solicitacaoFundos->id)->first(),
                    '_dirExec' => FlowSolicitacaoFundos::where('flow_id', 12)->where('num_requisicao',  $solicitacaoFundos->num_requisicao)
                        ->where('solicitacao_id', $solicitacaoFundos->id)->first(),
                    '_lliderDaf' => FlowSolicitacaoFundos::where('flow_id', 13)->where('num_requisicao',  $solicitacaoFundos->num_requisicao)
                        ->where('solicitacao_id', $solicitacaoFundos->id)->first()
                ],
                'selected_areas' => $selected_areas,
                'selected_actividades' => $selected_actividades,
                'selected_necessidades' => $selected_necessidades,
            ]
        );
        return view('solicitacaoFundos.outputs.index', compact(
            'areas',
            'actividades',
            'necessidades',
            'data',
            'selected_areas',
            'selected_actividades',
            'selected_necessidades'
        ));
    }

    /**
     * Formulario de Pagamento
     */
    public function form_pagamento(Request $request, Projects $project_identifier)
    {
        if (!auth()->user()->can('projectMember', [FlowSolicitacaoFundos::class, $project_identifier])) {
            abort(401);
        }

        $project = $project_identifier;

        try {
            $flowSolicitacaoFundos = FlowSolicitacaoFundos::where('id', $request->fsfID)
                ->where('num_requisicao', $request->frNum)
                ->with('flow', 'solicitacao')
                ->firstOrFail();
        } catch (\Throwable $th) {
            throw new \Exception("Fatal Error: @parameter Error, or source not found.");
        }

        // return $flowSolicitacaoFundos;

        return view('solicitacaoFundos._form_pagamento', compact('project', 'flowSolicitacaoFundos'));
    }

    public function showDetailsBugetApprovementFlow(Projects $project_identifier, $requestNum)
    {
        $project = $project_identifier;

        if (!auth()->user()->can('projectMember', [FlowSolicitacaoFundos::class, $project_identifier])) {
            abort(401);
        }

        $solicitacaoFundos = SolicitacaoFundos::where('num_requisicao', $requestNum)->firstOrFail();


        return view('solicitacaoFundos.show', compact('project', 'solicitacaoFundos'));
    }


    public function solicitacao_validation(Request $request, Projects $project_identifier, $requestNum, FlowSolicitacaoFundos $approvementFlow)
    {
        if (!auth()->user()->can('projectMember', [FlowSolicitacaoFundos::class, $project_identifier])) {
            abort(401);
        }

        // return $approvementFlow;
        /**
         * Se o valor for superior a 50 000 o fluxo vai para o
         * - @param idflowCat 28 - Validacao Programatica - Lider de Programas
         *
         * Caso < 50000 vai para - Validacao Programatica - Gestor de Projectos
         */
        
        if (!$approvementFlow->flow->is_flow_end) {
            try {
                /*if ($approvementFlow->flow->id == 28) {
                    $hasApprovementFlowToTrigger = ApprovementFlowModel::where('type', "'SolicitacaodeFundos'")->where('id', 22)->firstOrFail();
                } else if ($approvementFlow->flow->id == 21 && $approvementFlow->solicitacao->valor_estimado >= 50000) {
                    $hasApprovementFlowToTrigger = ApprovementFlowModel::where('type', "'SolicitacaodeFundos'")->where('id', 28)->firstOrFail();
                } else {*/
                    if($approvementFlow->type){
                        $hasApprovementFlowToTrigger = $this->flowApprovementManager->existApprovementToTrigger($this->approvementFlow, $approvementFlow->type, \str_replace('flow_', '', $approvementFlow->flow->approved_goto))->approvementFlow;
                    } else{
                        $hasApprovementFlowToTrigger = $this->flowApprovementManager->existApprovementToTrigger($this->approvementFlow, "SolicitacaodeFundos", $approvementFlow->flow->id)->approvementFlow;
                    }
                //}
            } catch (\Throwable $th) {
                throw new \Exception($th->getMessage(), 2302);
                return back()->with('error', $th->getMessage());
            }
        } else {
            $hasApprovementFlowToTrigger = $approvementFlow;
        }
        try {
            $solicitacaoFundos = SolicitacaoFundos::where('num_requisicao', $requestNum)->firstOrFail();
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }


        try {
            DB::beginTransaction();

            $this->flowApprovementManager->setHasApprovedFlow($approvementFlow);

            if ($approvementFlow->flow->id === 14 && !$request->has('isApproveAction')) {
                return redirect()->route('orcamento.projecto.solicitacao_fundos_form_pagamento', [
                    'project_identifier' => $project_identifier->identifier,
                    'fsfID' => $approvementFlow->id, // fsfID -> flow solicitacao fundos id
                    'frNum' => $approvementFlow->num_requisicao // flow solicitacao - num_requisicao
                ])->with('success', 'Processar Pagamento para Solicitação de Fundos: Requisicao => ' . $approvementFlow->num_requisicao . '');
            } else if ($approvementFlow->flow->id === 14 && $request->has('isApproveAction')) {

                try {

                    if (PagamentosFlowSolicitacaoFundos::where('flow_solicitacao_id', $approvementFlow->id)->first()) {
                        throw new Exception("Error Processing Request", 1);
                    }

                    $pagamentosFlowSolicitacaoFundos = new PagamentosFlowSolicitacaoFundos();

                    $pagamentosFlowSolicitacaoFundos->doardor_id = 1;
                    $pagamentosFlowSolicitacaoFundos->doador_name = $request->processarPagamento['doador'];
                    $pagamentosFlowSolicitacaoFundos->flow_solicitacao_id = $approvementFlow->id;
                    $pagamentosFlowSolicitacaoFundos->solicitacao_id = $approvementFlow->solicitacao->id;
                    $pagamentosFlowSolicitacaoFundos->valor = $approvementFlow->solicitacao->valor_estimado;
                    $pagamentosFlowSolicitacaoFundos->paymentType = $request->processarPagamento['paymentType'];
                    $pagamentosFlowSolicitacaoFundos->nome_banco = $request->processarPagamento['nome_banco'];
                    $pagamentosFlowSolicitacaoFundos->num_banco = $request->processarPagamento['num_conta'];
                    $pagamentosFlowSolicitacaoFundos->nib_banco = $request->processarPagamento['nib'];
                    $pagamentosFlowSolicitacaoFundos->check_trans_number = $request->processarPagamento['check_trans_number'];
                    $pagamentosFlowSolicitacaoFundos->data = $request->processarPagamento['data'];
                    $pagamentosFlowSolicitacaoFundos->author_id = auth()->user()->id;
                    $pagamentosFlowSolicitacaoFundos->created_on = now();

                    $pagamentosFlowSolicitacaoFundos->save(); // Save data into database

                } catch (\Throwable $th) {
                    return back()->with('error', "Ocorreu um problem ao processar os dados - RFC::PagamentosFlowSolicitacaoFundos");
                    throw $th;
                }
            }

            $usersToApprove = $request->usersToApprove ?? null;

            if (!$approvementFlow->flow->is_flow_end) {
                // Gravar o fluxo da solicitacao para o user a aprovar e sua categoria
                $flowSolicitacaoFundos = $this->flowApprovementManager->storeTriggeredApprovementFlow(
                    $hasApprovementFlowToTrigger,
                    $solicitacaoFundos,
                    $project_identifier,
                    $usersToApprove
                );
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', $th->getMessage());
            // return back()->with('error', "Ocorreu um problem ao processar aprovação!");
            throw $th;
        }

        return back()->with('success', "Aprovação Submetida com sucesso");
    }


    public function solicitacao_reprovar(Request $request, Projects $project_identifier, $requestNum, FlowSolicitacaoFundos $approvementFlow)
    {

        if (!auth()->user()->can('projectMember', [FlowSolicitacaoFundos::class, $project_identifier])) {
            abort(401);
        }

        try {
            DB::beginTransaction();

            $solicitacaoFundos = SolicitacaoFundos::where('id', $approvementFlow->solicitacao->id)
                ->where('num_requisicao', $approvementFlow->num_requisicao)
                ->first();

            $role = $approvementFlow['flow']['role']['name'] ?? "Warning - Role description unknown on flow";

            $solicitacaoFundos->is_rejected = 1;
            $solicitacaoFundos->rejected_by = auth()->user()->id;
            $solicitacaoFundos->is_approved = 0;
            $solicitacaoFundos->rejected_on = now();
            $solicitacaoFundos->updated_on = now();

            $solicitacaoFundos->update(); // Update data into database

            $approvementFlow->is_rejected = 1;
            $approvementFlow->rejected_by = auth()->user()->id;
            $approvementFlow->is_approved = 0;
            $approvementFlow->rejected_on = now();
            $approvementFlow->updated_on = now();

            $approvementFlow->update(); // Update data into database

            $reprovacao = new ReprovacaoSolicitacaoFundos();
            $reprovacao->nivel = $approvementFlow->flow->id;
            $reprovacao->issue_id = $solicitacaoFundos->issue_id ?? null;
            $reprovacao->solicitacao_requestNum =  $approvementFlow->solicitacao->num_requisicao;
            $reprovacao->request_from_id =  $approvementFlow->solicitacao->request_by;
            $reprovacao->aprovacao_id = $approvementFlow->id;
            $reprovacao->notes = $request->reprovacao['notes'];
            $reprovacao->categoria = $role;
            $reprovacao->action_by = auth()->user()->id;
            $reprovacao->created_on = now();

            $reprovacao->save(); // Save data into database

            // send with unapproval message
            $this->UnapprovalGenericEmailNotification($approvementFlow, $request->reprovacao['notes']);

            DB::commit();

            return back()->with('warning', "Reprovação cadastrada com sucesso!\nEnviamos um email a notificar o usuario sobre a reprovação.");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', "Ocorreu um erro na reprovação da fase: {$th->getMessage()} na solicitacao de fundos");
        }
    }


    public function solicitacao_re_validation(Request $request, Projects $project_identifier, $requestNum, FlowSolicitacaoFundos $approvementFlow)
    {

        if (!auth()->user()->can('projectMember', [FlowSolicitacaoFundos::class, $project_identifier])) {
            abort(401);
        }
       
        try {
            DB::beginTransaction();

            $solicitacaoFundos = SolicitacaoFundos::where('id', $approvementFlow->solicitacao->id)
                ->where('num_requisicao', $approvementFlow->num_requisicao)
                ->first();

            $solicitacaoFundos->is_rejected = 0;
            $solicitacaoFundos->updated_on = now();
            $solicitacaoFundos->update(); // Update data into database

            $approvementFlow->is_rejected = false;
            $approvementFlow->updated_on = now();
            $approvementFlow->update(); // Update data

           
            // send with unapproval message
            $this->SolicitacaoDeFundosEmailNotification($approvementFlow);
           
            DB::commit();
            return back()->with('success', 'Requisição de validação registada com sucesso');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Ocorreu um erro na requisição de validação.');
            throw $th;
        }
    }
}
