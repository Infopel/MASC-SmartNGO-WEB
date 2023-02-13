<?php

namespace App\Http\Livewire;

use App\Models\Projects;
use Livewire\Component;
use Symfony\Component\Yaml\Yaml;
use App\Http\Controllers\Helpers\MembersProjectsHelper;

class MemberProject extends Component
{
    use MembersProjectsHelper;

    public $users = []; // users
    public $roles = [];
    public $membersProjects = array();
    public $showModal = false;
    public $selected_members_ids = [];
    public $user_ids = [];
    public $membership_role_id;
    public $username = null;
    public $project;
    public $add_task_loading = false;
    public $error_role_null = false;

    public function loadComponent()
    {
        $this->readyToLoad = true;
    }

    public function mount($project)
    {
        $this->membersProjects = $this->project_members($project->id);

        $this->roles = $this->roles();
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.member-project');
    }

    /**
     * Show Modal with User to add as Project Members
     */
    public function showModal()
    {
        $this->showModal = true;
        $this->users = $this->getUsers();
    }

    /**
     * Close Modal and set $users to empty array
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->username = null;
        $this->add_task_loading = false;
        $this->membership_role_id = null;
        $this->error_role_null = false;
        $this->selected_members_ids = [];
    }

    /**
     * Pesquisar por um usario para adicionar como membro
     */
    public function updatedUsername()
    {
        $this->users = $this->searchUsers($this->username);
    }

    /**
     * Add users as members to the project
     */
    public function addMembers()
    {
        if ($this->membership_role_id == null) {
            return $this->error_role_null = true;
        }
        $this->add_task_loading = true;
        $add_members_project = $this->add_project_members($this->selected_members_ids, $this->project->id, $this->membership_role_id);
        /*dd($add_members_project);
        if ($add_members_project["status"]) {
            $this->membersProjects = $add_members_project["members"];
        }*/

        session()->flash('success', __('lang.notice_successful_create'));

        $this->closeModal();
        $this->membership_role_id = null;
        $this->error_role_null = false;
        $this->selected_members_ids = [];
    }

    /**
     * Remover member Project
     */
    public function removeMember($member_id, $user_id)
    {
        $this->remove_project_members($member_id, $user_id, $this->project->id);
        $this->membersProjects = $this->project_members($this->project->id);
    }
}
