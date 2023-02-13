<?php

namespace App\Http\Controllers\Helpers\SolicitacaoFundos;

use App\Models\Enumerations;
use App\Models\SolicitacaoFundos;
use App\Models\OptionsSolicitacaoFundos;
use App\Models\RubricasFlowSolicitacaoFundos;

trait HelperFormSolicitacaoFundos
{

    /**
     * Save Rubircas
     *
     * @param mixed $rubricas
     * @param int $num_requisicao
     * @return void
     */
    public function storeRubircas($rubricas, string $num_requisicao, $project,bool $isUpdate = false): void
    {
        if ($isUpdate) {
            // remove old
            RubricasFlowSolicitacaoFundos::where('num_requisicao', $num_requisicao)->delete();
        }

        foreach ($rubricas as $project_id => $rubrica) {

            $rubricasFlowSolicitacaoFundos = new RubricasFlowSolicitacaoFundos();
            $rubricasFlowSolicitacaoFundos->num_requisicao = $num_requisicao;
            $rubricasFlowSolicitacaoFundos->rubrica_id = $rubrica;
            $rubricasFlowSolicitacaoFundos->project_id = $project;
            $rubricasFlowSolicitacaoFundos->created_on = now();

            $rubricasFlowSolicitacaoFundos->save(); // Save data into database
        }
    }

    /**
     * Save Option - Necessidade
     */
    public function storeOptionsData($data, string $num_requisicao, string $enumType, bool $isUpdate = false): void
    {

        if ($isUpdate) {
            // remove old
            OptionsSolicitacaoFundos::where('num_requisicao', $num_requisicao)
                ->where('enumeration_type', $enumType)
                ->delete();
        }

        foreach ($data as $item) {
            $optionsSolicitacaoFundos = new OptionsSolicitacaoFundos();
            $optionsSolicitacaoFundos->num_requisicao = $num_requisicao;
            $optionsSolicitacaoFundos->enumeration_id = $item;
            $optionsSolicitacaoFundos->enumeration_type = $enumType;
            $optionsSolicitacaoFundos->created_on = now();
            $optionsSolicitacaoFundos->save(); // Save data into database
        }
    }


    /**
     * Load de Rubrica adionadas ao editar requisição de orcamento
     *
     * @param string $requestNum
     * @return array
     */
    public function load_rubricas_gravadas(SolicitacaoFundos $requisicaoFundos): array
    {
        foreach ($requisicaoFundos->rubricas as $item) {
            $this->select_rubricas[] = array(
                "id" => $item->rubrica->id,
                "name" => $item->rubrica->name,
                "project_id" => $item->rubrica->project_id
            );
        }

        return $this->select_rubricas;
    }

    /**
     * Apagar rubricas
     *
     * Apagar as rubircas gravadas para a requisição selecionada definitivamente na DB,
     *  ---- mais perguntar ao user se tem certeza
     *
     * @param string $id_rubrica
     * @param string $requestNum
     * @return void
     */
    public function remover_rubrica(): void
    {
    }


    /**
     * Load de Rubrica adionadas ao editar requisição de orcamento
     *
     * @param string $requestNum
     * @return array
     */
    public function load_rubricas_options(SolicitacaoFundos $requisicaoFundos): void
    {
        // Areas
        foreach ($requisicaoFundos->areas as $item) {

            $this->selected_areas_id[] = $item->enumeration->id;
            $this->selected_areas[] = array(
                "id" =>  $item->enumeration->id,
                "name" => $item->enumeration->name
            );
        }

        $this->areas = Enumerations::select('id', 'name', 'active')
            ->where('active', true)
            ->where('type', 'IssueArea')->where('parent_id', null)
            ->whereNotIn('id', $this->selected_areas_id)
            ->orderBy('name')->get();

        // Actividade
        foreach ($requisicaoFundos->actividades as $item) {

            $this->selected_actividades_id[] = $item->enumeration->id;
            $this->selected_actividades[] = array(
                "id" =>  $item->enumeration->id,
                "name" => $item->enumeration->name
            );
        }

        $this->actividades = Enumerations::select('id', 'name', 'active')
            ->where('active', true)
            ->where('type', 'IssueActividade')->where('parent_id', null)
            ->whereNotIn('id', $this->selected_actividades_id)
            ->orderBy('name')->get();

        // Necessidade
        foreach ($requisicaoFundos->necessidades as $item) {

            $this->selected_necessidades_id[] = $item->enumeration->id;
            $this->selected_necessidades[] = array(
                "id" =>  $item->enumeration->id,
                "name" => $item->enumeration->name
            );
        }

        $this->necessidades = Enumerations::select('id', 'name', 'active')
            ->where('active', true)
            ->where('type', 'IssueNecessidade')->where('parent_id', null)
            ->whereNotIn('id', $this->selected_necessidades_id)
            ->orderBy('name')->get();
    }

    public $enable_delete_area_on = [];
    public $enable_delete_actividade_on = [];
    public $enable_delete_necessidade_on = [];
    public function delete_option(string $type, bool $isSubmitDelete, $idOption): void
    {
        switch ($type) {
            case 'area':
                if (!$isSubmitDelete) {
                    $this->enable_delete_area_on = array($idOption);
                    return;
                }
                break;
            case 'actividade':
                if (!$isSubmitDelete) {
                    $this->enable_delete_actividade_on = array($idOption);
                    return;
                }
                break;
            case 'necessidade':

                if (!$isSubmitDelete) {
                    $this->enable_delete_necessidade_on = array($idOption);
                    return;
                }

                try {
                    session()->flash('success', __('lang.notice_successful_delete'));
                    return;
                } catch (\Throwable $th) {
                    session()->flash('error', 'Ocorreu um erro ao remover o item selecionado.');
                    return;
                }
                break;
            default:
                # code...
                break;
        }
    }

    public function cancel_delete_option(string $type)
    {
        switch ($type) {
            case 'area':
                $this->enable_delete_area_on = array();
                break;
            case 'actividade':
                $this->enable_delete_actividade_on = array();
                break;
            case 'necessidade':
                $this->enable_delete_necessidade_on = array();
                break;
            default:
                break;
        }
    }
}
