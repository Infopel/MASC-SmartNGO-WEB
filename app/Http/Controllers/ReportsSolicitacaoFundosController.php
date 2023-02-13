<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Macro\AppBoot;
use App\Models\Issues;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Models\SolicitacaoFundos;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ApprovementFlowModels;
use App\Exports\ExportsReportApprovementFlow;

class ReportsSolicitacaoFundosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a list of aprovement flow tasks
     *
     * @return \Illuminate\Http\Response
     */
    public function approvement_flow(Request $request)
    {

        $approvement_status = $request->status == 'validated' ? 1 : 0;

        if ($request->has('start_date') && $request->start_date !== 'null' || $request->has('end_date') && $request->end_date !== 'null') {
            $is_startDate = $request->start_date !== 'null' ? true : false;
            $is_endDate = $request->end_date !== 'null' ? true : false;
        } else {
            $is_startDate = false;
            $is_endDate = false;
        }

        if ($request->setFilter == 'true') {

            $approvementFlow = SolicitacaoFundos::with('requestBy', 'project', 'latestAprovement', 'approvements')
                ->whereHas('project', function ($query) use ($request) {
                    $query->where('identifier', $request->project);
                })
                ->where(function ($query) use ($request, $is_startDate) {
                    if ($is_startDate) {
                        $query->where('created_on', '>=', $request->start_date);
                    }
                })
                ->where(function ($query) use ($request, $is_endDate) {
                    if ($is_endDate) {
                        $query->where('created_on', '<=', $request->end_date);
                    }
                })
                ->with(['approvements' => function ($query) use ($approvement_status) {
                    $query->where('is_approved', $approvement_status);
                }])
                ->with(['latestAprovement' => function ($query) use ($approvement_status) {
                    $query->where('is_approved', $approvement_status);
                }])
                ->whereHas('approvements')
                ->whereHas('latestAprovement', function ($query) use ($approvement_status) {
                    $query->where('is_approved', $approvement_status);
                })
                ->get();
        } else {
            $approvementFlow = SolicitacaoFundos::with('requestBy', 'project', 'latestAprovement')
                ->where(function ($query) use ($request, $is_startDate) {
                    if ($is_startDate) {
                        $query->where('created_on', '>=', $request->start_date);
                    }
                })
                ->where(function ($query) use ($request, $is_endDate) {
                    if ($is_endDate) {
                        $query->where('created_on', '<=', $request->end_date);
                    }
                })
                ->with(['approvements' => function ($query) use ($approvement_status) {
                    $query->where('is_approved', $approvement_status);
                }])
                ->with(['latestAprovement' => function ($query) use ($approvement_status) {
                    $query->where('is_approved', $approvement_status);
                }])
                ->whereHas('approvements')
                ->whereHas('latestAprovement', function ($query) use ($approvement_status) {
                    $query->where('is_approved', $approvement_status);
                })
                ->get();
        }

        return response()->json([
            'status' => 'success',
            'approvementFlow' => $approvementFlow
        ], 200);
    }


    /**
     * Filter aprovement by project
     *
     * @param \App\Models\Projects $project
     * @return \App\Models\ApprovementFlowModels
     */
    protected function getByProject(Projects $project)
    {
        return ApprovementFlowModels::select()
            ->with('requestBy')
            ->with('approvement_flow')
            ->whereHas('approvement_flow', function ($approvement_flow) {
                $approvement_flow->where('is_flow_end', true);
            })
            ->with('issue')
            ->whereHas('issue', function ($issue) use ($project) {
                $issue->where('is_aproved', true)
                    ->where('project_id', $project->id);
            })
            ->with('issue.author')
            ->get()->filter(function ($approvement) {
                $approvement->issue->valor_solicitado = $approvement->issue->orcamento()->get()->sum('issued_value' ?? 0);
                return $approvement;
            });
    }

    /**
     * Filter by Date Time
     *
     * @param Illuminate\Http\Request $request
     * @param \App\Models\Projects $project
     * @return \App\Models\ApprovementFlowModels
     */
    protected function getByDateTime(Request $request, Projects $project, $is_startDate = false, $is_endDate = false)
    {

        return ApprovementFlowModels::select()
            ->with('requestBy')
            ->with('approvement_flow')
            ->whereHas('approvement_flow', function ($approvement_flow) {
                $approvement_flow->where('is_flow_end', true);
            })
            ->with('issue')
            ->whereHas('issue', function ($issue) use ($project, $request, $is_startDate, $is_endDate) {
                $issue->where('is_aproved', true)
                    ->where('project_id', $project->id)
                    ->where(function ($query) use ($request, $is_startDate) {
                        if ($is_startDate) {
                            $query->where('created_on', '>=', $request->start_date)
                                ->orWhere('start_date', '>=', $request->start_date);
                        }
                    })
                    ->where(function ($query) use ($request, $is_endDate) {
                        if ($is_endDate) {
                            $query->where('created_on', '>=', $request->end_date)
                                ->orWhere('start_date', '>=', $request->end_date);
                        }
                    });
            })
            ->with('issue.author')
            ->get()->filter(function ($approvement) {
                $approvement->issue->valor_solicitado = $approvement->issue->orcamento()->get()->sum('issued_value' ?? 0);
                return $approvement;
            });
    }


    /**
     * Expor Data into Excle file
     */
    public function exportData(Request $request)
    {

        try {
            $project = Projects::where('identifier', $request->project)->first();
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Project not found');
        }

        $application =  AppBoot::application();
        $title = "FOLHA MENSAL DE SOLICITAÇÃO DE FUNDOS";
        $start_date = $request->start_date == 'null' ? 'dd-mm-yyyy' : $request->start_date;
        $end_date = $request->end_date == 'null' ? 'dd-mm-yyyy' : $request->end_date;

        $data = $this->approvement_flow($request);
        $data = $data->original['approvementFlow'];

        $export = new ExportsReportApprovementFlow($title, $application, $project, $start_date, $end_date, $data);
        $file_name = time() . "Relatorio-folha-mensal-de-solicitação-fundos";
        return Excel::download($export, $file_name . '.xlsx');


        return view('report_files.exports.export_approvement_flow', compact(
            'application',
            'title',
            'project',
            'start_date',
            'end_date',
            'data'
        ));
    }
}
