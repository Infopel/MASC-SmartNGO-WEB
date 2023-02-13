<?php

namespace App\Http\Controllers;

use App\Models\CustomFields;
use Illuminate\Http\Request;

class QueriesController extends Controller
{
    protected $table = [];
    protected $selectable_columns = [];
    protected $customized_id = [];
    protected $custom_fields = [];
    protected $filters = null;

    public function builder($q_parameters)
    {
        $this->selectable_columns[] = 'issues.id';
        $abrv = null;
        foreach($q_parameters['columns'] as $column ){
            $abrv = \substr($column, 0, 3);
            $cf_id = \substr($column, 3);
            if($abrv == 'cf_'){
                $this->table['thead'][] = $this->getCF($cf_id);
                $this->customized_id[] = $cf_id;
                $this->custom_fields[] = array('id'=> $cf_id, 'name' => $column);

                $this->selectable_columns[] = $column.'.value as '.$column;
            }else{
                $this->table['thead'][] = __('lang.field_' . $column);
                switch ($column) {
                    case 'assigned_to':
                        $this->selectable_columns[] = 'firstname';
                        $this->selectable_columns[] = 'lastname';
                        break;

                    case 'tracker':
                        $this->selectable_columns[] = 'trackers.id as tracker_id';
                        $this->selectable_columns[] = 'trackers.name as tracker';
                        break;

                    case 'project':
                        $this->selectable_columns[] = 'projects.name as project';
                        $this->selectable_columns[] = 'projects.identifier as identifier';
                        break;

                    case 'status':
                        $this->selectable_columns[] = 'issue_statuses.name as status';
                        break;
                    case 'priority':
                        $this->selectable_columns[] = 'enumerations.name as priority';
                        break;

                    case 'updated_on':
                        $this->selectable_columns[] = 'issues.updated_on';
                        break;
                    default:
                        $this->selectable_columns[] = $column;
                        break;
                }
            };

        }

        foreach ($q_parameters['filters'] as $key => $filters) {
            $values = null;

            $i = 0;
            foreach($filters['values'] as $q => $filter){

                $operator = $filters['operator'] == '!' ? '!=' : $filters['operator'];

                $operator = $operator == 'c' ? $filter = 1 : $filters['operator'];
                $operator = $operator == 'c' ? '=' : $filters['operator'];

                $operator = $operator == 'o' ? $filter = 0 : $filters['operator'];
                $operator = $operator == 'o' ? '=' : $filters['operator'];

                $q_column = $key == 'status_id' ? 'issue_statuses.is_closed' : $key;
                $abrv = \substr($q_column, 0, 3);
                $q_column = $abrv == 'cf_' ? $key.'.value' : $q_column;

                if($i > 0){
                    $values .= ' or '. $q_column.' '.$operator . ' ' . "'$filter'";
                }else{
                    $values = $operator . ' ' . "'$filter'";
                }
                ++$i;
            }
            $this->filters[] = $q_column . ' '.$values;
        }

        if($q_parameters['sort_criteria'][1] == 'id') $q_parameters['sort_criteria'][1] = 'issues.id';

        $this->table['rows'] = $q_parameters['columns'];
        $data = array(
            'table' => $this->table,
            'selectable_columns' => $this->selectable_columns,
            'custom_fields' => $this->custom_fields,
            'filters' => implode(' and ', $this->filters),
            'sort_criteria' => $q_parameters['sort_criteria'],
        );

        $test = array(
            'filters' => implode(' and ', $this->filters),
            'sort_criteria' => $q_parameters['sort_criteria'],
            'q' => $q_parameters
        );
        return $data;
        return $test;
    }

    /**
     * collect the costum fields name and ids
     */
    protected static function getCF(int $cf_id)
    {
        try {
            $custom_field = CustomFields::where('id', $cf_id)->firstOrFail();
            return $custom_field->name;
        } catch (\Throwable $th) {
            return $cf_id;
        }
    }
}
