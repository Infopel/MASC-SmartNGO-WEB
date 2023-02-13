<?php

namespace App\Http\Controllers\Helpers\Reports;

use App\Models\SolicitacaoFundos;
use Illuminate\Support\Facades\DB;
use App\Models\ApprovementFlowModels;

trait ReportsIssueApprovement
{
    /**
     * Return Json data for vue chart issue approval
     */
    public function report_atividades_approvement_flow_api()
    {
        $array_data = [];
        for ($i = 1; $i <= 12; $i++) {
            $approvementRequests = SolicitacaoFundos::select('*', DB::raw('month(created_on) as created_on'))
                ->whereMonth('created_on', $i)
                ->get();

            $array_data[] = array(
                "mes" => \ucwords(\Carbon\Carbon::parse(date("Y-$i-d"))->formatLocalized('%b')),
                "value" => $approvementRequests->count()
            );
        }

        return response()->json(
            $array_data
        );
    }
}
