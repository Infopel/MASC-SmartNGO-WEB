<div class="p-2 bg-light m-1">
    <div class="p-2 pl-3 pr-3">
        <h4 class="m-0" style="font-size: 100% !important;">Pedidos de aprovação de plano de actividades</h4>
    </div>
    <div class="col-md-12 m-0 p-0 mb-4" style="overflow-x: auto; overflow-y: hidden; height: 80vh;">
        <div class="m-0 p-0 d-flex mb-4">

            @foreach ($activityPlanApprovalSteps as $activityPlanApprovalFlow)
                <!-- column My Tasks -->
                <div class="col-md-4 mb-3 " style="font-size: 95% !important;">
                    <div class="card-block shadow-sm p-3 position-relative" style="max-height: 77vh; min-height: 77vh; overflow-y: auto">
                        {{-- Header --}}
                        <div
                            class="bg-white border-bottom mb-2 pb-2 pl-3 position-sticky pr-3 pt-3 title-card"
                            style="top: -16px; left: 0; margin-left: -15px; margin-right: -15px; margin-top: -8px;"
                            >
                            <h6 class="flex-grow-1 cursor-pointer" style="font-size: 95% !important;">
                                <i class="icon-checkbox-partial2 text-muted"></i>
                                <span class="text-muted"></span><span>{{ $activityPlanApprovalFlow->description }}</span>
                            </h6>
                            <div class="d-flex mb-1">
                                <span class="text-muted small mr-2">Requisições: (10)</span>
                                <span class="text-muted small mr-2 text-success">Aprovadas: (10)</span>
                                <span class="text-muted small mr-2 text-danger">Reprovadas: (10)</span>
                            </div>
                        </div>
                        {{-- /end header --}}
                        @foreach ($activityPlanApprovalFlow->aprovement_flow_step($activityPlanApprovalFlow->id)->with('project')->get() as $item)
                        {{-- card body --}}
                            <div class="">
                                <div class="approval-item-element p-2 bg-light rounded mb-2">
                                    <p class="mb-2 proj-desc" style="max-height: 120px !important; overflow: hidden; font-size: 100% !important">
                                    <a href="">

                                        {{
                                            dd(\App\Models\ValidationFlowDataStore::with('project')->first()) }}

                                        {{ dd($activityPlanApprovalFlow->aprovement_flow_step($activityPlanApprovalFlow->id)->get()) }}
                                       {{ $item->project->name }}
                                        </a>
                                    </p>
                                    <div class="d-flex flex-row">
                                        <span class=" small">Solicitado por: User name full_name - Gestor de Projectos</span>
                                        <span class="text-primary small">Por Aprovar: User name full_name - Lider de Programas</span>
                                    </div>
                                    <div class="d-flex flex-end justify-content-end mt-2">
                                        <span class="text-muted small">20/02/2021 - ha duas semanas</span>
                                    </div>
                                </div>
                            </div>
                            {{-- /end card body --}}
                        @endforeach
                    </div>
                </div>
                <!-- column My Tasks -->
            @endforeach
        </div>
    </div>
</div>
