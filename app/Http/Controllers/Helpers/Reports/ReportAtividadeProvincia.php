<?php

namespace App\Http\Controllers\Helpers\Reports;

use App\Models\Issues;

trait ReportAtividadeProvincia
{
    /**
     * return json api data for Vue Axios request
     */
    public function report_atividade_provincia_api()
    {
        $issues = Issues::select('issues.id', 'issues.subject', 'issues.project_id')->with('provincia', 'indicators', 'project')
            ->whereHas('provincia')
            ->whereHas('project')
            ->get()->groupBy('provincia.value');

        $array = [];
        // Pegar o numero de actividades por provincia
        foreach ($issues as  $provincia => $issue) {
            $array[] = array(
                "provincia" => $provincia,
                "Aciviades" => $issues[$provincia]->count(),
            );
        }
        return response()->json(
            $array
        );
    }

    /**
     * Process data to grath
     */
    protected function process_atividade_provincia_data_to_graph($data)
    {
        $array[] = array();
        return $this->data_graph = $array;
    }
}
