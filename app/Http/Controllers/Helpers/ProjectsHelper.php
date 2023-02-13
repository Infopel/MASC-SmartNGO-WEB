<?php

namespace App\Http\Controllers\Helpers;

use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

trait ProjectsHelper
{

    /**
     * Funcionalidades adicionais ao Controller de Projectos
     */

    protected $is_open = 1;
    protected $is_closed = 5;
    protected $is_archived = 9;
    protected $is_unarchived = 1;

    /**
     * Validade project actions
     */
    protected function action($action)
    {
        $available_actions = array(
            'open',
            'close',
            'archive',
            'unarchive',
            'delete',
        );

        if (in_array($action, $available_actions)) {
            return $action;
        } else {
            return abort(401);
        }
    }

    /**
     * Executar action
     */
    private function excute_action($action)
    {
        $chosen_action = array(
            'open' => $this->is_open,
            'close' => $this->is_closed,
            'archive' => $this->is_archived,
            'unarchive' => $this->is_unarchived,
            'delete' => 'remove',
        );

        return $chosen_action[$action];
    }

    public function action_confirmation(Projects $project, $action)
    {
        if ($action == 'remove') {
            if ($project->issues->count() > 0 || $project->childs->count() > 0) {
                return back()->with('error', __('lang.error_can_not_delete_project', [
                    'issues' => $project->issues->count(),
                    'projects' => $project->childs->count()
                ]));
            }
        }


        return back()->with('isRemoveTrue', [
            'msg' => __('lang.text_are_you_sure'),
            'project_name' => $project->identifier,
            'action' => $action,
            'action_name' => __('lang.button_' . $action),
            'project_identifier' => $project->identifier,
        ]);
    }

    /**
     * Arquivar Projecto
     * @param  \App\Models\Projects Project
     * @return \Illuminate\Http\Response
     */
    public function chenge_project_status(Projects $project, $action)
    {


        if ($this->excute_action($action) == 'remove') {
            try {
                $project->delete();
                return back()->with('success', __('lang.notice_successful_update'));
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        try {
            $project->status = $this->excute_action($action);
            $project->updated_on = now();
            $project->update();
            return back()->with('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            throw $th;
            return back()->with('error', 'Ocorreu um erro');
        }
    }


    /**
     * Mapear os tipos de tarefas disponível para o projecto
     * @param \App\Models\Trackers $trackers
     * @param  \App\Models\Projects $Projects
     * @return \Illuminate\Http\Response
     */
    public function project_tracker_with_label($project, $project_trackers, $trackers)
    {
        $available_trackers = array();
        foreach ($project_trackers as $key => $project_tracker) {
            $available_trackers[] = array(
                'tracker_id' => $project_tracker->tracker_id,
                'tracker_name' => $project_tracker['tracker']['name']
            );
        }
        foreach ($trackers as $key => $tracker) {
            if (in_array($tracker->name, array_column($available_trackers, 'tracker_name'))) {
                $project_trackers_available_tracker[] = array(
                    'id' => $tracker->id,
                    'name' => $tracker->name,
                    'is_selected' => true,
                );
            } else {
                $project_trackers_available_tracker[] = array(
                    'id' => $tracker->id,
                    'name' => $tracker->name,
                    'is_selected' => false,
                );
            }
        }
        return $project_trackers_available_tracker;
    }



    public function getProject(Request $request)
    {
    }

    public function listChilds(Projects $project, Request $request)
    {
        switch ($request->type) {
            case 'projects':
                try {
                    return Projects::where('status', '1')->where('parent_id', $project->id)
                        ->where('type', 'Project')
                        ->get();
                } catch (\Throwable $th) {
                    throw $th;
                }
                break;
            case 'programs':
                try {
                    $programs = Projects::where('status', '1')->where('parent_id', $project->id)
                        ->where('type', 'Program')
                        ->with('custom_field_values')
                        ->get();
                    foreach ($programs as $program) {

                        $program->objectivoEsp = $program->customFieldValues()->where('customized_type', 'Program')->where('custom_field_id', 39)->first()->value ?? null;
                        $program->resultado = $program->customFieldValues()->where('customized_type', 'Program')->where('custom_field_id', 40)->first()->value ?? null;
                    }
                    return $programs;
                } catch (\Throwable $th) {
                    throw $th;
                }
                break;

            default:
                return Projects::where('status', '1')->get();
                break;
        }
    }
}
