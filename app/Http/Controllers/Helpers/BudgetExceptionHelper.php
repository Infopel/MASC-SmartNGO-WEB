<?php

namespace App\Http\Controllers\Helpers;

use App\Models\Issues;
use App\Models\Projects;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait BudgetExceptionHelper
{

    protected $parent = null;
    protected $route = null;
    protected $budget_tracker_id = null;


    /**
     * Validar request de orçamento
     */
    public function validar_request_orcamento($request)
    {
        if (!request()->has('budget')) {
            throw ValidationException::withMessages(['refrence' => 'Erro Fatal: Selecione/Indique pelo menos tipo de despesa.']);
        }

        foreach ($request->budget as $key => $budget) {
            Validator::make($budget,[
                'id' => 'required',
                'value' => 'required',
            ])->validate();
        }
    }
    /**
     * Validar para que modulo a proposta finaneira esta a ser aplicada
     *
     * A referencia pode ser: todas as de Projecto ou Atividades
     */
    public function validar_referencia_financeira()
    {
        if (request()->has('reference')) {
            if (request('reference') != 'project' || request('reference') != 'issue') {
            } else {
                throw ValidationException::withMessages(['refrence' => 'Erro Fatal: Referência de orçamento desconhecida.']);
            }
        } else {
            throw ValidationException::withMessages(['refrence' => 'Erro Fatal: Nehuma referência definada no parametro do $request para cadastro de orçamento.']);
        }
    }

    /**
     * Validar Identificador
     *
     * Validar se a opcao correcta foi indicada para o cadastro
     * da proposta financeira
     */
    public function validar_indetificador_financeiro($request)
    {
        if ($request->orcamento['budget_to'] != request('reference')) {
            throw ValidationException::withMessages(['refrence' => 'Erro Fatal: Inconsistência na referência. Verifique se selecionou corretamente o na opcao #:Criar Para.']);
        }
    }

    /**
     * Pegar o Pai e a routa de redirecionamento
     *
     * atravez da referencia
     */
    public function get_parent_and_route_from_identificador($request)
    {
        if (request()->has('identifier')) {
            if (request('reference') == "project") {
                try {
                    $this->parent = Projects::where('identifier', $request->identifier)->firstOrFail();

                    $this->route = route('projects.budget', ['project_identifier' => $this->parent->identifier]);

                    if ($this->parent->type == "PDE") {
                        $this->budget_tracker_id = 1;
                    } elseif ($this->parent->type == "Project") {
                        $this->budget_tracker_id = 2;
                    } elseif ($this->parent->type == "Program") {
                        $this->budget_tracker_id = 3;
                    }
                } catch (\Throwable $th) {
                    throw ValidationException::withMessages(['identifier' => 'O projeto que você está tentando acessar não exite ou foi removido.']);
                }
            } else {
                try {
                    $this->parent = Issues::where('id', $request->identifier)->firstOrFail();
                    $this->route = route('issues.budget', ['issue' => $this->parent->id]);
                    $this->budget_tracker_id = 4;
                } catch (\Throwable $th) {
                    throw ValidationException::withMessages(['identifier' => 'A atividade que você está tentando acessar não exite ou foi removido.']);
                }
            }
        } else {
            throw ValidationException::withMessages(['project_parent' => 'Não encontramos nenhum identificador no request para associar com este projecto.']);
        }
    }
}
