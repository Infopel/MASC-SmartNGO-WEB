<?php

namespace App\Http\Livewire;

use App\Models\Issues;
use Livewire\Component;
use App\Models\Projects;
use App\Models\Trackers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Helpers\IssuesHelper;
use App\Http\Controllers\Helpers\IndicatoresHelper;
use App\Http\Livewire\Indicators;

use function Complex\add;

class IssuesProject extends Component
{
    use IssuesHelper, IndicatoresHelper;

    public $trackers;
    public $default_status = [];
    public $priorities;
    public $user_members = [];

    public $core_fields = [];
    public $tracker_id;

    public $selectd_tracker;

    public $priority_id;
    public $assigned_to_id;
    public $start_date;
    public $due_date;
    public $done_ratio;
    public $estimated_hours;
    public $tracker_custom_fields;

    public $isLoading = true;

    public $issue_name;
    public $issue;
    public $project_id;
    public $project_parent;
    public $parent;
    public $parent_id;
    public $search_parent_results = [];

    public $isEdit = false;
    // Available Indicators
    public $available_indicatores;

    public $fields_benfHomens = [];
    public $fields_benfMulheres = [];
    public $fields_benfHomens_Mulheres = [];
    public $fields_iniciativas = [];

    public function reset_search()
    {
        $this->isSearch = false;
    }
    /**
     * Issues Indicator_fields
     */
    // public $indicator_fields = [];

    public function mount($project_id, $issue)
    {
        $this->project_id = $project_id['project_id'];
        $this->isEdit = Route::is('issues.edit');

        // $this->tracker_custom_fields = $this->tracker_custom_fields($this->selectd_tracker) ?? [];
        $this->user_members = $this->member_projects($project_id['project_id']);

        $this->priorities = $this->issues_priorities();
        $trackers = $this->isses_project_trackers($project_id['project_id']);
        $this->trackers = $trackers;

        $this->issue = $issue;
        $this->selectd_tracker = $issue['tracker_id'] ?? null;

        $this->priority_id = $issue['priority_id'] ?? null;
        $this->assigned_to_id = $issue['assigned_to_id'] ?? null;
        $this->start_date = $issue['start_date'] ?? null;
        $this->due_date = $issue['due_date'] ?? '';
        $this->done_ratio = $issue['done_ratio'] ?? null;
        $this->estimated_hours = $issue['estimated_hours'] ?? null;
        $this->parent = $issue['parent_id'] ?? null;

        $this->available_indicatores = $this->available_indicatores('Issue')->toArray();
        $this->getTrackerCustomFields($issue);

        //var_dump($this->selectd_tracker);

        $this->project_parent = \App\Models\Projects::where('id', $project_id['project_id'])->first();

        $this->fields_benfHomens = $this->benf_object_builder($this->isEdit, $issue['beneficiarios'] ?? [])['homens'];
        $this->fields_benfHomens_Mulheres = $this->benf_object_builder($this->isEdit, $issue['beneficiarios'] ?? [])['beneficiarios'];
        $this->fields_benfMulheres = $this->benf_object_builder($this->isEdit, $issue['beneficiarios'] ?? [])['mulheres'];
        // $this->fields_iniciativas=$this->benf_object_builder($this->isEdit, $issue['beneficiarios'] ?? [])['iniciativa'];

        if (!$this->isEdit) {
            $this->forSubActivities();
        }
    }


    public function render()
    {
        return view('livewire.issues-project');
    }


    private function forSubActivities()
    {
        if (request()->has('tracker_id')) {
            $this->selectd_tracker = request()->tracker_id;
            $this->updatedSelectdTracker();

            // $this->trackers = Trackers::where('id', request()->tracker_id)->get();
            // $this->trackers = Projects::where('id', $this->project_id)->first()->project_trackers()->where('tracker_id', $this->selectd_tracker)->get()->toArray();
        }

        if (request()->has('parent_id')) {
            $parent = Issues::where('id', request()->parent_id)->first();
            $this->selected_parent($parent->id, $parent->subject);
        }
    }

    private function getTrackerCustomFields($issue)
    {
        if (isset($issue['tracker_id'])) {
            $this->isLoading = true;
            $this->core_fields = $this->tracker_core_fields($this->selectd_tracker)['core_fields'] ?? [];
            $this->default_status = $this->tracker_core_fields($this->selectd_tracker)['default_status'] ?? [];
            // Carregar os camopos personalizados dos tracekrs
            $this->tracker_custom_fields = $this->tracker_custom_fields_with_labels($this->selectd_tracker, $issue) ?? [];
        } else {
            $this->tracker_custom_fields = $this->tracker_custom_fields($this->selectd_tracker) ?? [];
        }
        return null;
    }

    /**
     * Action on Tracker selection
     */
    public $selectd_tracker_name = null;
    public function updatedSelectdTracker()
    {
        if ($this->selectd_tracker !== null) {
            $this->isLoading = true;
            $this->core_fields = $this->tracker_core_fields($this->selectd_tracker)['core_fields'] ?? [];
            $this->default_status = $this->tracker_core_fields($this->selectd_tracker)['default_status'] ?? [];
            // Carregar os camopos personalizados dos tracekrs
            $this->tracker_custom_fields = $this->tracker_custom_fields($this->selectd_tracker) ?? [];
            $this->selectd_tracker_name = Trackers::where('id', $this->selectd_tracker)->firstOrFail()->name;
            $this->emit('parentTrackerChanded', ['tracker' => $this->selectd_tracker]);
        }
    }

    /**
     * Search - Tarefa pai
     */
    public $isSearch = false;
    public function updatedParent()
    {
        // dd($this->project_id);
        $this->isLoading = true;
        $this->isSearch = true;
        $this->search_parent_results = $this->search_parent(
            $this->parent,
            $this->issue['id'] ?? null,
            $this->issue['subject'] ?? null,
            $this->project_id
        );


        // dd($this->search_parent_results);

        $this->isLoading = false;
        if ($this->search_parent_results == []) {
            $this->isSearch = false;
            $this->parent_id = null;
        }
    }

    public function selected_parent($parent_id = null, $parent_subject = null)
    {
        $this->isSearch = false;
        $this->parent_id = $parent_id;
        $this->parent = $parent_subject;
    }





    // Issue Beneficiários

    public function add_field_beneficiarios()
    {
        array_push($this->fields_benfHomens_Mulheres, $this->benf_object_builder(false, [])['beneficiarios'][0]);
        // dd($this->fields_benfHomens_Mulheres['beneficiarios']);
    }

    public function remove_field_beneficiarios($key)
    {
        if (sizeof($this->fields_benfHomens_Mulheres) > 1) {
            $this->fields_benfHomens_Mulheres = array_diff_key($this->fields_benfHomens_Mulheres, array($key => true));
        }
    }

    public function add_field_benfHomens()
    {
        array_push($this->fields_benfHomens, $this->benf_object_builder(false, [])['homens'][0]);

        // dd($this->fields_benfHomens['homens']);
    }

    public function remove_field_benfHomens($key)
    {
        if (sizeof($this->fields_benfHomens) > 1) {
            $this->fields_benfHomens = array_diff_key($this->fields_benfHomens, array($key => true));
        }
    }


    public function add_field_benfMulheres()
    {
        array_push($this->fields_benfMulheres, $this->benf_object_builder(false, [])['mulheres'][0]);
    }

    public function remove_field_benfMulheres($key)
    {
        if (sizeof($this->fields_benfMulheres) > 1) {
            $this->fields_benfMulheres = array_diff_key($this->fields_benfMulheres, array($key => true));
        }
    }


    public function benf_object_builder($isEdit = true, array $beneficiarios_objects = [])
    {
        if ($isEdit) {
            if (sizeof($beneficiarios_objects) > 0) {
                foreach ($beneficiarios_objects as $index => $benf) {
                    $ini_benfObject[$benf['type']][] =  array(
                        '_onStorageID' =>  $benf['id'],
                        'type' =>  $benf['type'],
                        'num' =>  $benf['meta'],
                        'faixa_etaria' => $benf['faixa_etaria'],
                    );
                }
            } else {
                $ini_benfObject['homens'][] =  array(
                    '_onStorageID' =>  null,
                    'type' =>  null,
                    'num' =>  null,
                    'faixa_etaria' => null,
                );
                $ini_benfObject['mulheres'][] =  array(
                    '_onStorageID' =>  null,
                    'type' =>  null,
                    'num' =>  null,
                    'faixa_etaria' => null,
                );
                $ini_benfObject['beneficiarios'][] =  array(
                    '_onStorageID' =>  null,
                    'type' =>  null,
                    'num' =>  null,
                    'faixa_etaria' => null,
                );
            }
            return $ini_benfObject;
        } else {
            $ini_benfObject['homens'][] =  array(
                '_onStorageID' =>  null,
                'type' =>  null,
                'num' =>  null,
                'faixa_etaria' => null,
            );
            $ini_benfObject['mulheres'][] =  array(
                '_onStorageID' =>  null,
                'type' =>  null,
                'num' =>  null,
                'faixa_etaria' => null,
            );
            $ini_benfObject['beneficiarios'][] =  array(
                '_onStorageID' =>  null,
                'type' =>  null,
                'num' =>  null,
                'faixa_etaria' => null,
            );
            return $ini_benfObject;
        }
    }
}
