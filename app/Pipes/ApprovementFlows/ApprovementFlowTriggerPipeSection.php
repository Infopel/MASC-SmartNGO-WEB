<?php

namespace App\Pipes\ApprovementFlows;

use Closure;
use App\Models\ApprovementFlow;
use App\Http\Controllers\Features\SolicitacaoFundos\FlowApprovementManager;

class ApprovementFlowTriggerPipeSection
{

    public $flowApprovementManager;
    public $approvementFlow;

    public function __construct(
        FlowApprovementManager $flowApprovementManager, // dependency injection
        ApprovementFlow $approvementFlow // dependency injection
    ) {
        $this->flowApprovementManager = $flowApprovementManager;
        $this->approvementFlow = $approvementFlow;
    }

    public function handle($request, Closure $next)
    {
        if (!array_key_exists('trigger', $request)) {
            throw new \Exception("Trigger key property not defined on pipeline section request or closure data.");
        }

        try {
            $hasApprovementFlowToTrigger = $this->flowApprovementManager->existApprovementToTrigger($this->approvementFlow, $request['trigger'], null);
            $approvementFlow = $hasApprovementFlowToTrigger->approvementFlow;
            return $next([
                'data' => $request['data'],
                'approvementFlow' => $approvementFlow
            ]);
        } catch (\Throwable $th) {
            return $th;
            return back()->with('error', "There is no Approvement flow to be triggered");
        }
    }
}
