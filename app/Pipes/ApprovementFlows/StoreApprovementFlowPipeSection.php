<?php

namespace App\Pipes\ApprovementFlows;

use Closure;
use Illuminate\Support\Facades\DB;
use App\Models\ValidationFlowDataStore;

class StoreApprovementFlowPipeSection
{
    public function handle($request, Closure $next)
    {
        if (!array_key_exists('assignedTo', $request)) {
            throw new \Exception("assignedTo key property not defined on pipeline section request or closure data.");
        }

        if (!array_key_exists('approvementFlow', $request)) {
            throw new \Exception("assignedTo key property not defined on pipeline section request or closure data.");
        }


        try {
            DB::beginTransaction();

            $flowTrigerd = new ValidationFlowDataStore();
            $flowTrigerd->flow_id = $request['approvementFlow']->id;
            $flowTrigerd->flow_description = $request['approvementFlow']->description;
            $flowTrigerd->validator_category = $request['approvementFlow']->role->name;
            $flowTrigerd->customized_id = $request['project_id'];
            $flowTrigerd->customized_type = 'ProjectValition';
            $flowTrigerd->assignedTo = $request['assignedTo'];
            $flowTrigerd->is_approved = 0;
            $flowTrigerd->request_by = auth()->user()->id;
            $flowTrigerd->created_on = now();

            $flowTrigerd->save(); // Save data into database

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }


        return $next([
            'data' => $request['data']
        ]);
    }
}
