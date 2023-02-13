<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\Helpers\MembersGroupsHelper;

class MemberGroup extends Component
{
    use MembersGroupsHelper;


    public $users = []; // users
    public $group_id;
    public $membersGroup = [];
    public $showModal = false;
    public $selected_members_ids = [];
    public $user_ids = [];
    public $username = null;

    public $test;
    public function mount($group)
    {
        $this->group_id = $group['id'];
        $this->membersGroup = $this->group_members($group->id);
        // $this->membersGroup = \App\Models\GroupUsers::with('user')->get()->toArray();
    }

    public function render()
    {
        return view('livewire.member-group');
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
        $this->add_task_loading = true;
        $this->membersGroup = $this->add_group_members($this->selected_members_ids, $this->group_id);
        $this->closeModal();
        $this->selected_members_ids = [];
    }

    /**
     * Remover member Project
     */
    public function removeMember($member_id, $user_id)
    {
        $this->membersGroup = $this->remove_group_members($this->group_id, $user_id);
    }
}
