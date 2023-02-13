<?php

namespace App\Http\Livewire;

use App\Models\Issues;
use App\Models\Partners;
use App\Models\Projects;
use Livewire\Component;

class Quick extends Component
{
    public $showQuick = false;
    public $bt_quick = true;

    public $search = null;
    public $search_results = [];

    public $search_projects = true;
    public $search_issues = false;
    public $search_partners = false;

    public $search_title = "Pesquisar projectos";

    public function mount()
    {
        $this->search_results = collect([])->all();
    }

    public function render()
    {
        return view('livewire.quick');
    }


    /**
     * Show Quick
     */
    public function showQuick()
    {
        $this->showQuick = true;
        $this->bt_quick = false;
    }

    public function closeQuick()
    {
        $this->showQuick = false;
        $this->bt_quick = true;
    }

    public function updatedSearch()
    {

        if($this->search_projects){
            if ($this->search !== "") {
                return $this->search_results = Projects::where(function ($query) {
                    $query->where('identifier', 'like', '%' . $this->search . '%')->orWhere('name', 'like', '%' . $this->search . '%');
                })->get();
            }
            return $this->search_results = [];
        }

        if ($this->search_issues){
            if ($this->search !== "") {
                return $this->search_results = Issues::where(function ($query) {
                    $query->where('subject', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%');
                })->where('status_id', '!=', 5)->where('is_aproved', true)->get();
            }
            return $this->search_results = [];
        }

        if ($this->search_partners){
            if ($this->search !== "") {
                return $this->search_results = Partners::where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })->get();
            }
            return $this->search_results = [];
        }

        return $this->search_results = [];

    }

    public function search_on($action)
    {
        switch ($action) {
            case 'projects':
                $this->search_results = [];
                $this->search = null;
                $this->search_title = "Pesquisar projectos";
                $this->search_projects = true;
                $this->search_issues = false;
                $this->search_partners = false;
                break;

            case 'issues':
                $this->search_results = [];
                $this->search = null;
                $this->search_title = "Pesquisar tarefas";
                $this->search_issues = true;
                $this->search_projects = false;
                $this->search_partners = false;
                break;

            case 'partners':
                $this->search_results = [];
                $this->search = null;
                $this->search_title = "Pesquisar parceiros";
                $this->search_partners = true;
                $this->search_projects = false;
                $this->search_issues = false;
                break;

            default:
                $this->search_projects = true;
                break;
        }
    }
}
