<?php

namespace App\Http\Livewire;

use App\Models\Issues;
use Livewire\Component;
use App\Models\Trackers;
use App\Models\ProjectTrackers;

class SubIssuesComponent extends Component
{

    public $projectTracker = [];
    public $searchIssue = null;
    public $projectIsses = [];
    public $selectedTracker = null;

    public $selectedIssesID = null;

    public $issues_info = [];
    public $issue;
    public $project;

    public $disabledAddButton = true;

    public function mount($params)
    {
        $this->issue = $params['issue'];
        $this->issues_info = $params['issues_info'];
        $this->project = $params['issue']['project'];

        $this->loadProjectTracker();
    }

    public function render()
    {
        return view('livewire.sub-issues-component');
    }

    /**
     * Load projects Trackers to search for issues on selected tracker
     *
     * @return void
     */
    public function loadProjectTracker()
    {
        $this->projectTracker = ProjectTrackers::where('project_id', $this->project->id)->get();
    }


    public function updatedSelectedTracker()
    {
        $this->updatedSearchIssue();
    }

    /**
     * Load projects Trackers to search for issues on selected tracker
     *
     * @return \App\Http\Livewire\collect
     */
    public function updatedSearchIssue()
    {
        if ($this->selectedTracker == null || $this->selectedTracker == '_') {
            $this->projectIsses = Issues::whereNotIn('id', [$this->issue['id']])
                ->where('project_id', $this->project->id)
                ->where('parent_id', null)
                ->where(function ($query) {
                    $query->where('subject', 'like', '%' . $this->searchIssue . '%')
                        ->orWhere('id', 'like', '%' . $this->searchIssue . '%');
                })->limit(15)->get();
        } else {
            $this->projectIsses = Issues::whereNotIn('id', [$this->issue['id']])->where('tracker_id', $this->selectedTracker)
                ->where('project_id', $this->project->id)
                ->where('parent_id', null)
                ->where(function ($query) {
                    $query->where('subject', 'like', '%' . $this->searchIssue . '%')
                        ->orWhere('id', 'like', '%' . $this->searchIssue . '%');
                })->limit(15)->get();
        }
        return $this->projectIsses;
    }

    public function addSubIssueFromExistingIssue($issueId, $issueSubject)
    {
        $this->disabledAddButton = false;
        $this->searchIssue = $issueSubject;

        $this->projectIsses = [];

        try {
            $issue = Issues::where('id', $issueId)->first();
            $issue->parent_id = $this->issue['id'];
            $issue->updated_on = now();
            $issue->update();

            session()->flash('warning', __('lang.notice_successful_update') . ' ' . ' - por favor refresque a pagina para ver a sub actividade adicionada');
            $this->projectIsses = [];
            $this->showSubIssuesForm = !$this->showSubIssuesForm;
            $this->searchIssue = null;
        } catch (\Throwable $th) {
            session()->flash('error', "Desculpe ocorreu um erro ao adicionar subactividade. Por favor tente novamente");
            //throw $th;
        }
    }


    public $showSubIssuesForm = false;
    /**
     * Show Sub Isses component form
     */
    public function toogle_sub_issue_form()
    {
        session()->forget('error');
        session()->forget('success');
        session()->forget('warning');

        $this->projectIsses = [];
        $this->showSubIssuesForm = !$this->showSubIssuesForm;
        $this->searchIssue = null;
    }
}
