<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TableColumns extends Component
{

    public $available_columns = [];
    public $issue_list_default_columns = [];
    public $available_list_columns;
    public $default_selected_columns;


    public function mount()
    {
        $this->available_list_columns = $this->default_available_columns();
        $this->default_selected_columns = $this->selected_columns();
    }


    public function render()
    {
        return view('livewire.table-columns');
    }

    /**
     * Mover as options de colunas selciondas
     */
    public function moveOptions($option)
    {
        if($option == 'add'){
            $this->available_list_columns = array_diff($this->available_list_columns, $this->available_columns);
            foreach($this->available_columns as $key => $column){
                array_push($this->default_selected_columns, $column);
            }
            $this->available_columns = [];
        }elseif($option == 'remove'){
            $this->default_selected_columns = array_diff($this->default_selected_columns, $this->issue_list_default_columns);
            foreach($this->issue_list_default_columns as $column){
                array_push($this->available_list_columns, $column);
            }
            $this->issue_list_default_columns = [];
        }
    }

    /**
     * Colunas disponíveis para selecionar
     */
    public function default_available_columns()
    {
        return array(
            'project',
            'parent',
            'author',
            'category',
            'fixed_version',
            'start_date',
            'due_date',
            'estimated_hours',
            'total_estimated_hours',
            'spent_hours',
            'total_spent_hours',
            'done_ratio',
            'created_on',
            'closed_on',
            'last_updated_by',
            // 'relations',
            // 'attachments',
            'is_private',
        );
    }

    /**
     * Colunas selecionadas por default
     */
    public function selected_columns()
    {
        return array(
            'tracker',
            'status',
            'priority',
            'subject',
            'assigned_to',
            'updated_on',
        );
    }


    public function moveElementUp()
    {
        foreach($this->issue_list_default_columns as $column){
            $key = array_search($column, $this->default_selected_columns);
            $moveUp = array_splice($this->default_selected_columns, $key, 1);
            array_splice($this->default_selected_columns, --$key, 0, $moveUp);
        }
    }

    public function moveElementDown()
    {
        foreach($this->issue_list_default_columns as $column){
            $key = array_search($column, $this->default_selected_columns);
            $moveDown = array_splice($this->default_selected_columns, $key, 1);
            array_splice($this->default_selected_columns, ++$key, 0, $moveDown);
        }
    }

    public function moveElementTop()
    {
        foreach($this->issue_list_default_columns as $column){
            $key = array_search($column, $this->default_selected_columns);
            $moveDown = array_splice($this->default_selected_columns, $key, 1);
            array_splice($this->default_selected_columns, 0, 0, $moveDown);
        }
    }
    public function moveElementBottom()
    {
        foreach($this->issue_list_default_columns as $column){
            $key = array_search($column, $this->default_selected_columns);
            $moveDown = array_splice($this->default_selected_columns, $key, 1);
            array_splice($this->default_selected_columns, sizeof($this->default_selected_columns), 0, $moveDown);
        }
    }
}
