<?php

namespace App\Http\Controllers\Helpers\Reports;

use App\Models\Projects;

trait ReportOrcamentoProjectos
{
    /**
     * return json api data for Vue Axios request
     */
    public function report_financeiro_project_api(Projects $project_identifier)
    {
        $project = $project_identifier;

        $project->orcamento_inicial = round($project->orcamento()->get()->sum("orcamento_inicial"), 2);
        $project->orcamento_gasto = round($project->orcamento()->get()->sum("orcamento_gasto"), 2);

        return response()->json([
            'dataTable' => $project,
            'dataGraph' => $this->process_project_data_to_graph($project)
        ]);
    }

    /**
     * Process data to grath
     */
    protected function process_project_data_to_graph($data)
    {
        $array[] = array(
            "project" => $data->name,
            "Orçamento Inicial" => $data->orcamento_inicial,
            "Valor Gasto" => $data->orcamento_gasto,
        );
        return $this->data_graph = $array;
    }
}
