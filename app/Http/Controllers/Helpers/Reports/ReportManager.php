<?php

namespace App\Http\Controllers\Helpers\Reports;

use App\Models\Issues;
use App\Models\TimeEntries;
use Illuminate\Http\Request;
use App\Models\BudgetsValues;
use App\Models\FlowReportTask;
use App\Models\TimeEntriesValues;
use Illuminate\Support\Facades\DB;
use App\Models\IndicatorFieldsIssues;
use Illuminate\Database\Eloquent\Model;

trait ReportManager
{
    /**
     * Store Temporary report
     *
     * @param \App\Models\Issues $issue
     * @param \Illuminate\Http\Request $request
     * @param string $isTemporary
     */
    public function store_report_entrie(Issues $issue, Request $request, $isTemporary = "tempStore", string $custom_type = 'TaskReport')
    {
        if ( $custom_type == "TaskBudgetReport" ) {
           
            $timelog = new TimeEntries();
            $timelog->project_id = $issue->project_id;
            $timelog->user_id = auth()->user()->id;
            $timelog->issue_id = $issue->id;
            $timelog->hours = $request->timelog['hours'] ?? '0';
            $timelog->comments = $request->timelog['comments'] ?? 'Financial';
            $timelog->activity_id = 'Actividade';
            $timelog->spent_on = date('Y-m-d', \strtotime($issue->start_date ?? date('Y-m-d')))  ?? now();
            $timelog->tyear = date('Y', \strtotime($issue->start_date ?? date('Y-m-d'))) ?? now();
            $timelog->tmonth = date('n', \strtotime($issue->start_date ?? date('Y-m-d'))) ?? now();
            $timelog->tweek = (int) date('W', \strtotime($issue->start_date ?? date('Y-m-d'))) ?? now();
            $timelog->start_date = $issue->start_date;
            $timelog->due_date = $request->timelog['due_date']  ?? now();
            
            $timelog->created_on = now();
            $timelog->updated_on = now();
            $timelog->is_reported = $isTemporary == "tempStore" ? false : true;
            $timelog->is_approved = 0;
            $timelog->custom_type = $custom_type;

            $timelog->save();
            
        } else {
            $timelog = new TimeEntries();
            $timelog->project_id = $issue->project_id;
            $timelog->user_id = auth()->user()->id;
            $timelog->issue_id = $issue->id;
            $timelog->hours = $request->timelog['hours'];
            $timelog->comments = $request->timelog['comments'];
            $timelog->activity_id = 'Actividade';
            $timelog->spent_on = date('Y-m-d', \strtotime($issue->start_date ?? date('Y-m-d')));
            $timelog->tyear = date('Y', \strtotime($issue->start_date ?? date('Y-m-d')));
            $timelog->tmonth = date('n', \strtotime($issue->start_date ?? date('Y-m-d')));
            $timelog->tweek = (int) date('W', \strtotime($issue->start_date ?? date('Y-m-d')));
            $timelog->start_date = $issue->start_date;
            $timelog->due_date = $request->timelog['due_date'];

            $timelog->peoople_to_inform = $request->timelog['peoople_to_inform'] ?? "";
            $timelog->evidence_type = $request->timelog['evidence_type'] ?? "";
            $timelog->verification_type = $request->timelog['verification_type'] ?? "";
            $timelog->metting_descrption = $request->timelog['metting_descrption'] ?? "";
            $timelog->metting_result = $request->timelog['metting_result'] ?? "";
            $timelog->challenge_lessons = $request->timelog['challenge_lessons'] ?? "";
            $timelog->falloup = $request->timelog['falloup'] ?? "";
            $timelog->masc_contribuition = $request->timelog['masc_contribuition'] ?? "";
            
            $timelog->created_on = now();
            $timelog->updated_on = now();
            $timelog->is_reported = $isTemporary == "tempStore" ? false : true;
            $timelog->is_approved = 0;
            $timelog->custom_type = $custom_type;

            $timelog->save();
        }
        
        
         // Save data into database

        // Store indicator_archives
        if ($request->has('indicator_achives')) {
            $this->store_indicator_time_entries_values($request->indicator_achives, $issue->id, $timelog->id, $isTemporary == "tempStore" ? false : true);
        }

        if ($request->has('report_financeiro')) {
            $this->store_report_financeiro($request->report_financeiro, $issue->id, $timelog->id);
        }
    }


    /**
     * Store indicador time entries achived
     *
     * @param array $reports
     * @param int $customized_id
     * @param int $timelog_id
     * @param bool $isTemporary
     * @return void
     */
    protected function store_indicator_time_entries_values($reports, $customized_id, $timelog_id, bool $isTemporary)
    {
        foreach ($reports as $key => $reportValue) {
           
            $indicator = IndicatorFieldsIssues::where('indicator_fields_id', $key)->first();
            $indicator->is_reported = true;
            $indicator->update();

            $indicator_time_entries_values = new TimeEntriesValues();
            $indicator_time_entries_values->customized_id = $key;
            $indicator_time_entries_values->customized_type = "IssueIndicator";
            $indicator_time_entries_values->time_entry_id = $timelog_id;
            $indicator_time_entries_values->value = $reportValue ?? '';
            $indicator_time_entries_values->created_on = now();
            $indicator_time_entries_values->updated_on = now();
            $indicator_time_entries_values->is_reported = $isTemporary;

            $indicator_time_entries_values->save(); // Save data into database
        }
    }

    /**
     * Store report financeiro
     *
     * @param mixed $reports
     * @param int $timelog_id
     * @return void
     */
    protected function store_report_financeiro($reports, $customized_id, int $timelog_id)
    {
        foreach ($reports as $report) {
            try {
                $report_due_budget = BudgetsValues::where('id', $report['buget_value_id'])->where('is_reported', false)->first();

                $report_due_budget->quant_realizada = $report['quantity'] ?? 0;
                $report_due_budget->valor_realizado = $report['value'] ?? 0;
                $report_due_budget->is_reported = true;
                $report_due_budget->reported_at = now();
                $report_due_budget->reported_by = auth()->user()->id;
                $report_due_budget->update();

                $indicator_time_entries_values = new TimeEntriesValues();
                $indicator_time_entries_values->customized_id = $report['buget_value_id'];
                $indicator_time_entries_values->customized_type = "IssueBudget";
                $indicator_time_entries_values->time_entry_id = $timelog_id;
                $indicator_time_entries_values->value = $report['price'] ?? 0;
                $indicator_time_entries_values->created_on = now();

                $indicator_time_entries_values->save(); // Save data into database
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }


    /**
     * Update Active reported Indicator values
     *
     * @return void
     */
    public function update_indicator_time_entries_values($reports, $customized_id, $timelog_id)
    {
        foreach ($reports as $key => $reportValue) {

            $indicator_time_entries_values = TimeEntriesValues::where('customized_id', $key)->firstOrFail();

            $indicator_time_entries_values->customized_id = $key;
            $indicator_time_entries_values->customized_type = "IssueIndicator";
            $indicator_time_entries_values->time_entry_id = $timelog_id;
            $indicator_time_entries_values->value = $reportValue;
            $indicator_time_entries_values->updated_on = now();

            $indicator_time_entries_values->update(); // Save data into database
        }
    }

    /**
     * This function will be used to store taks report flow
     *
     * @param int $user_id
     * @param \Illuminate\Database\Eloquent\Model
     * @param \App\Models\TimeEntries $time_entrie
     * @return void
     * @param string $custom_type
     */
    public function store_task_report_flow(int $user_id, Model $approvementFlow, TimeEntries $time_entrie, string $custom_type)
    {
        
        try {
            DB::beginTransaction();

            $flow_report_task = new FlowReportTask();
            $flow_report_task->time_entrie_id = $time_entrie->id;
            $flow_report_task->custom_type = $custom_type;
            $flow_report_task->flow_id = $approvementFlow->id;
            $flow_report_task->flow_description = $approvementFlow->description;
            $flow_report_task->validator_category = $approvementFlow->role->name;
            $flow_report_task->assigned_to = $user_id;
            $flow_report_task->request_by = auth()->user()->id;
            $flow_report_task->is_approved = 0;
            $flow_report_task->approved_by = null;
            $flow_report_task->notes = null;
            $flow_report_task->created_on = now();
            $flow_report_task->updated_on = now();
            $flow_report_task->save(); // Save data into database

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback(); // Rollback Databse store transaction
            throw $th->getMessage();
        }
    }
}
