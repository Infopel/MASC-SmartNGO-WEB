<?php

namespace App\Http\Livewire;

use App\Models\Issues;
use Livewire\Component;
use App\Models\IssueRelations;

class RelatedIssuesComponent extends Component
{

    public $add_related_issue = false;
    public $search_issues = null;
    public $issue;
    public $project;


    public $available_issues = [];
    public $related_issues = [];
    public $selectedIssue = null;
    public $relation_type = null;

    public function mount($params)
    {
        $this->issue = $params['issue'];
        $this->project = $params['issue']['project'];

        $this->loadRelatedIssues();
    }

    public function render()
    {
        return view('livewire.related-issues-component');
    }


    public function loadRelatedIssues()
    {
        $this->related_issues = IssueRelations::where('issue_from_id', $this->issue['id'])->with('issueTo')->get();
    }

    public function updatedSearchIssues()
    {
        if ($this->search_issues == '' || $this->search_issues == null) {
            return $this->available_issues = [];
        }

        $this->available_issues = Issues::where('subject', 'like', '%' . $this->search_issues . '%')
            ->where('project_id', $this->project->id)
            ->orWhere('id', 'like', '%' . $this->search_issues . '%')
            ->whereNotIn('id', [$this->issue['id']])
            ->limit('15')
            ->get();
    }


    public function add_related_issue_form()
    {
        session()->forget('error');
        session()->forget('success');
        session()->forget('warning');
        $this->add_related_issue = !$this->add_related_issue;
        $this->search_issues = null;
        $this->available_issues = [];
    }

    public function relate_issue_to($id, $subject)
    {
        $this->selectedIssue = $id;
        $this->search_issues = $subject;
        $this->available_issues = [];
    }

    public function addRelatedIssue()
    {
        $this->add_related_issue = false;

        if ($this->selectedIssue == null) {
            session()->flash('error', "<b>Error</b>: Ocoreu um erro. Não foi possível gravar dados. Por favor contacte o Administrador, <br><b>Details do Erro</b>: Nenhuma tarefa selecionda. - Selecione uma tarefa.");
            return;
        }

        try {

            Issues::where('id', $this->selectedIssue)->firstOrFail();

            $issueRelation = new IssueRelations();
            $issueRelation->issue_from_id = $this->issue['id'];
            $issueRelation->issue_to_id = $this->selectedIssue;
            $issueRelation->relation_type = $this->relation_type;
            $issueRelation->delay = null;
            $issueRelation->save();

            $this->loadRelatedIssues();
            $this->selectedIssue = null;
            session()->flash('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            session()->flash('error', "<b>Error</b>: Ocoreu um erro não foi possível gravar dados. Por favor contacte o Administrador, <br><br><b>Details do Erro</b>: " . $th->getMessage());
            // throw $th;
        }
    }
}
