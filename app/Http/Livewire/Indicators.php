<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\Helpers\IndicatoresHelper;

class Indicators extends Component
{
    use IndicatoresHelper;


    public $issue;
    public $selectd_tracker;
    public $isSearch = false;
    public $reset_search;
    public $project_parent;
    public $project_parent_name;
    public $parent_indicator_id;
    public $parent_indicator_name;
    public $selected_parent_indicator;
    public $indicator_parent = [];

    public $search_parent_indicators_results = [];
    public $search_parent_indicators_pri_results = [];

    public $deleted_indicators = [];

    public $indicador_parent = null;
    public $indicador_pri_parent = null;

    /**
     * Issues Indicator_fields
     */
    public $indicator_fields = [];

    public function reset_search()
    {
        // $this->project_parent = null;
        $this->isSearch = false;
    }

    public $isEdit = false;

    public function mount($issue, $project_parent, $isEdit)
    {
        $this->$isEdit = $isEdit;
        $this->issue = $issue;
        $this->project_parent = $project_parent ?? null;
        $this->project_parent_name = $issue['project_id']['project']['name'] ?? null;
        $this->indicator_fields = array(1);

        $this->indicador_parent = $issue['indicators']['related_to'] ?? null;
        $this->indicador_pri_parent = $issue['indicators']['pri_relation_id'] ?? null;

       // dd($this->project_parent['parent_id']);
        $this->indicator_fields = $this->indicator_object_builder($isEdit, $issue['indicators'] ?? []);
        // $this->test = $this->indicator_object_builder($isEdit, $issue['indicators'] ?? []);
        if ($this->selectd_tracker == 14) {
            # code...
            $this->search_parent_indicators_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name')
                //->where('indicator_fields.is_parent', true)
                ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                ->join('issues', 'issues.id', 'indicator_values.customized_id')
                ->where('indicator_values.indicator_type', 'Issue')
                ->where('issues.project_id', $this->project_parent['id'])
                ->where('issues.tracker_id', 7)
                ->get()->toArray();

            $this->search_parent_indicators_pri_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name', 'issues.project_id')
                ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                ->join('issues', 'issues.id', 'indicator_values.customized_id')
                //->where('issues.parent_id', $this->project_parent['parent_id'])
                ->where('issues.project_id', $this->project_parent['parent_id'])
                ->where('indicator_fields.category', 15)
                ->get()->toArray();
        } else if ($this->selectd_tracker == 7) {
            # code...
            $this->search_parent_indicators_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name')
                //->where('indicator_fields.is_parent', true)
                ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                ->join('issues', 'issues.id', 'indicator_values.customized_id')
                ->where('indicator_values.indicator_type', 'Issue')
                ->where('issues.project_id', $this->project_parent['id'])
                ->where('issues.tracker_id', 6)
                ->get()->toArray();
        } else if ($this->selectd_tracker == 6) {
            # code...
            $this->search_parent_indicators_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name')
                //->where('indicator_fields.is_parent', true)
                ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                ->join('issues', 'issues.id', 'indicator_values.customized_id')
                ->where('indicator_values.indicator_type', 'Issue')
                ->where('issues.project_id', $this->project_parent['id'])
                ->where('issues.tracker_id', 5)
                ->get()->toArray();
        } else {
            # code...
            $this->search_parent_indicators_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name')
                ->where('indicator_fields.is_parent', true)
                ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                ->join('issues', 'issues.id', 'indicator_values.customized_id')
                ->where('indicator_values.indicator_type', 'Issue')
                //->where('issues.project_id', $project_parent['id'])
                ->get()->toArray();

            $this->search_parent_indicators_pri_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name', 'issues.project_id')
                ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                ->join('issues', 'issues.id', 'indicator_values.customized_id')
                //->where('issues.parent_id', $this->project_parent['parent_id'])
                ->where('issues.project_id', $this->project_parent['parent_id'])
                ->where('indicator_fields.category', 15)
                ->get()->toArray();
                //dd($this->search_parent_indicators_pri_results);
        }
    }

    protected $listeners = ['parentTrackerChanded' => 'reloadIndicator'];

    public function reloadIndicator(array $params)
    {
        $this->indicator_fields = $this->indicator_object_builder($this->isEdit, $this->issue['indicators'] ?? []);

        if ($params['tracker'] == 14) {
            # code...
            $this->search_parent_indicators_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name')
                //->where('indicator_fields.is_parent', true)
                ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                ->join('issues', 'issues.id', 'indicator_values.customized_id')
                ->where('indicator_values.indicator_type', 'Issue')
                ->where('issues.project_id', $this->project_parent['id'])
                ->where('issues.tracker_id', 7)
                ->get()->toArray();

                $this->search_parent_indicators_pri_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name', 'issues.project_id')
                ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                ->join('issues', 'issues.id', 'indicator_values.customized_id')
                //->where('issues.parent_id', $this->project_parent['parent_id'])
                ->where('issues.project_id', $this->project_parent['parent_id'])
                ->where('indicator_fields.category', 15)
                ->get()->toArray();
            if ($this->search_parent_indicators_results == null) {
                $this->search_parent_indicators_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name')
                    //->where('indicator_fields.is_parent', true)
                    ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                    ->join('issues', 'issues.id', 'indicator_values.customized_id')
                    ->where('indicator_values.indicator_type', 'Issue')
                    ->where('issues.project_id', $this->project_parent['id'])
                    ->where('issues.tracker_id', 6)
                    ->get()->toArray();

                if ($this->search_parent_indicators_results == null) {
                    $this->search_parent_indicators_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name')
                        //->where('indicator_fields.is_parent', true)
                        ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                        ->join('issues', 'issues.id', 'indicator_values.customized_id')
                        ->where('indicator_values.indicator_type', 'Issue')
                        ->where('issues.project_id', $this->project_parent['id'])
                        ->where('issues.tracker_id', 5)
                        ->get()->toArray();

                    if ($this->search_parent_indicators_results == null) {
                        $this->search_parent_indicators_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name')
                            ->where('indicator_fields.is_parent', true)
                            ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                            ->join('issues', 'issues.id', 'indicator_values.customized_id')
                            ->where('indicator_values.indicator_type', 'Issue')
                            //->where('issues.project_id', $project_parent['id'])
                            ->get()->toArray();
                    }
                }
            }
        } else if ($params['tracker'] == 7) {
            # code...
            $this->search_parent_indicators_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name')
                //->where('indicator_fields.is_parent', true)
                ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                ->join('issues', 'issues.id', 'indicator_values.customized_id')
                ->where('indicator_values.indicator_type', 'Issue')
                ->where('issues.project_id', $this->project_parent['id'])
                ->where('issues.tracker_id', 6)
                ->get()->toArray();

            if ($this->search_parent_indicators_results == null) {
                $this->search_parent_indicators_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name')
                    //->where('indicator_fields.is_parent', true)
                    ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                    ->join('issues', 'issues.id', 'indicator_values.customized_id')
                    ->where('indicator_values.indicator_type', 'Issue')
                    ->where('issues.project_id', $this->project_parent['id'])
                    ->where('issues.tracker_id', 5)
                    ->get()->toArray();

                if ($this->search_parent_indicators_results == null) {
                    $this->search_parent_indicators_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name')
                        ->where('indicator_fields.is_parent', true)
                        ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                        ->join('issues', 'issues.id', 'indicator_values.customized_id')
                        ->where('indicator_values.indicator_type', 'Issue')
                        //->where('issues.project_id', $project_parent['id'])
                        ->get()->toArray();
                }
            }
        } else if ($params['tracker'] == 6) {
            # code...
            $this->search_parent_indicators_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name')
                //->where('indicator_fields.is_parent', true)
                ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                ->join('issues', 'issues.id', 'indicator_values.customized_id')
                ->where('indicator_values.indicator_type', 'Issue')
                ->where('issues.project_id', $this->project_parent['id'])
                ->where('issues.tracker_id', 5)
                ->get()->toArray();

            if ($this->search_parent_indicators_results == null) {
                $this->search_parent_indicators_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name')
                    ->where('indicator_fields.is_parent', true)
                    ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                    ->join('issues', 'issues.id', 'indicator_values.customized_id')
                    ->where('indicator_values.indicator_type', 'Issue')
                    //->where('issues.project_id', $project_parent['id'])
                    ->get()->toArray();
            }
        } else {
            # code...
            $this->search_parent_indicators_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name')
                ->where('indicator_fields.is_parent', true)
                ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                ->join('issues', 'issues.id', 'indicator_values.customized_id')
                ->where('indicator_values.indicator_type', 'Issue')
                //->where('issues.project_id', $project_parent['id'])
                ->get()->toArray();

                $this->search_parent_indicators_pri_results = \App\Models\IndicatorFields::select('indicator_fields.id as id', 'indicator_fields.name', 'issues.project_id')
                ->join('indicator_values', 'indicator_field_id', 'indicator_fields.id')
                ->join('issues', 'issues.id', 'indicator_values.customized_id')
                //->where('issues.parent_id', $this->project_parent['parent_id'])
                ->where('issues.project_id', $this->project_parent['parent_id'])
                ->where('indicator_fields.category', 15)
                ->get()->toArray();
        }
    }


    public function render()
    {
        return view('livewire.indicators');
    }

    public $test = [];
    // Add campo para novo indicador
    public function add_indicador_field($key)
    {
        array_push($this->indicator_fields, $this->indicator_object_builder(false, [])[0]);
    }

    // remover campo de indicador
    public function remove_indicador_field($key)
    {
        if (sizeof($this->indicator_fields) > 1) {
            array_push($this->deleted_indicators, $this->indicator_fields[$key]['indicator_id']);
            $this->indicator_fields = array_diff_key($this->indicator_fields, array($key => true));
        }
    }

    public function updatedIndicatorParent()
    {
        $this->isSearch = true;
        $this->search_parent_indicators_results = $this->search_indicator_parant($this->indicator_parent);
    }

    public function selected_parent_indicator($parent_indicator_id = null, $parent_indicator_name = null)
    {
        $this->isSearch = false;
        $this->parent_indicator_id = $parent_indicator_id;
        $this->indicator_parent = $parent_indicator_name;
    }

    /**
     * Custruir um objecto do indicador - para quando addicionar um indicador a tarefa
     * o builder pode ser tabem usado para inicializar indicadores ao editar tarefas que tenha algum indicador
     */
    public function indicator_object_builder($isEdit = true, array $indicador_objects = [])
    {
        // dd($indicador_objects);
        // $this->indicador_parent = $issue['indicators']['related_to'] ?? null;
        // $this->indicador_pri_parent = $issue['indicators']['pri_relation_id'] ?? null;
        if (!$isEdit) {
            $ini_indicatores =  array(
                'related_to' => null,
                'pri_relation_id' => null,
                'indicator_isNew' => true,
                'indicator_id' => null,
                'indicator_name' => null,
                'indicator_type' => null,
                'meta_value' => null,
                'meta_type' => null,
                'fonte_ver' => null,
                'base_ref' => null,
            );

            return array($ini_indicatores);
            // return [];s

        } else {

            if (sizeof($indicador_objects) <= 0) {
                $ini_indicatores =  array(
                    'related_to' => null,
                    'pri_relation_id' => null,
                    'indicator_isNew' => true,
                    'indicator_id' => null,
                    'indicator_name' => null,
                    'indicator_type' => null,
                    'meta_value' => null,
                    'meta_type' => null,
                    'fonte_ver' => null,
                    'base_ref' => null,
                );
                return array($ini_indicatores);
            }
            // dd($indicador_objects);
            return $indicador_objects;
        }
    }
}
