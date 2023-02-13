<?php

namespace App\Http\Controllers\Contracts;

use App\Models\Projects;
use App\Models\ApprovementFlow;
use Illuminate\Database\Eloquent\Model;

interface ISolicitacaoFundos
{
    /**
     * Trigger Next Approvement Flow
     *
     * @return void
     */
    public function triggerNextApprove();


    /**
     * This should be used to check if there is an flow to be triggered
     *
     * @param \Illuminate\Http\Model\ FlowModel
     * @param String resourceType
     * @param String trigger
     *
     * @return void
     */
    public function existApprovementToTrigger(Model $model, $resourceType, $trigger);


    /**
     *
     *
     * @param Model $model
     * @param
     */
    public function storeTriggeredApprovementFlow(Model $approvementFlow, $solicitacaoFundos, Projects $project);

    /**
     * Verificar se o request ja foi grado
     * na base de dados
     *
     * @param \App\Models\ApprovementFlow $approvement_flow
     * @param \App\Models\Issues $issue
     * @return Throwable
     */
    public function requestedFlowHasBeenStored(Model $approvementFlow, $resourceRequest);
}
