<?php

namespace App\Http\Livewire;

use App\Models\Issues;
use Livewire\Component;
use App\Models\Projects;

class MasterSearchComponent extends Component
{


    public $search = null;

    public $searchResults;
    public $search_projects = true;

    public $search_ProjectsResults = [];
    public $search_IssuesResults = [];

    public function mount()
    {
        $this->searchResults = [];
    }

    public function render()
    {
        return view('livewire.master-search-component');
    }


    /**
     * Pesquisar na app
     */
    public function updatedSearch()
    {
        if ($this->search_projects) {
            if ($this->search !== "") {
                $this->search_ProjectsResults = Projects::where(function ($query) {
                    $query->where('identifier', 'like', '%' . $this->search . '%')->orWhere('name', 'like', '%' . $this->search . '%');
                })->limit(15)->get();

                $this->search_IssuesResults = Issues::where(function ($query) {
                    $query->where('subject', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%');
                })->where('status_id', '!=', 5)->where('is_aproved', true)->limit(15)->get();
            } else {
                $this->search_ProjectsResults = [];
                $this->search_IssuesResults = [];
            }
            // return $this->search_ProjectsResults = [];
        }
    }

    /**
     * Adicionar project para a lista de vistos recetemente
     *
     * @param string $type
     * @param string $project_identifier
     * @param int $project_id
     * @return void
     */
    public function addToRecentViewed(string $type, string $project_identifier, int $project_id): void
    {
    }

    public $isSearchModal = false;

    public function toogelSearchModal()
    {
        $this->search = null;
        $this->isSearchModal = !$this->isSearchModal;
        $this->search_ProjectsResults = [];
        $this->search_IssuesResults = [];
    }
}
