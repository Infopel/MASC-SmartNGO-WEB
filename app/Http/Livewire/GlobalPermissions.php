<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\GlobalRoles;
use Livewire\Component;
use App\Models\GlobalRolesUsers;
use Symfony\Component\Yaml\Yaml;

class GlobalPermissions extends Component
{
    public $groups = [];
    public $users = [];

    public $search;
    public $filter_by;
    public $group_role;
    public $selected_group_role;

    public $show_modal_add_users = false;
    public $show_modal_create_group_role = false;
    public $username;

    public $selected_members_ids = [];

    public $group_role_name;
    public $role_available_permissions = [];

    public $role_permissions = [];
    public $list_permissions;

    public function mount()
    {
        $this->groups = GlobalRoles::get();
        $this->load_role_group_data();
    }

    public function render()
    {
        return view('livewire.global-permissions');
    }


    /**
     * Mostrar Modal com lista de user para add
     * no grupo de permission selecionado
     */
    public function show_modal_add_users()
    {
        $this->load_users();
        $this->show_modal_add_users = true;
    }

    /**
     * Mostrar Modal para criar nova
     */
    public function show_modal_create_group_role()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->role_available_permissions = [];
        $this->show_modal_create_group_role = true;
    }

    /**
     * Modal para editar grupo de permissões
     */
    public $is_grupo_role_update = false;
    public function show_modal_edit_group_role($selected_group_role_id = null)
    {
        if($selected_group_role_id == null){
            session()->flash('error', 'Por favor selecione um grupo de permissões');
            return;
        }
        $this->is_grupo_role_update = true;
        $this->group_role_name = $this->selected_group_role->name;
        $this->show_modal_create_group_role = true;
        // $this->selected_group_role->permissions;
    }

    /**
     * Carregar lista de usuarios
     */
    public function load_users()
    {
        $this->users = User::where('status', 1)->get();
    }

    /**
     * Fechac os Modals
     */
    public function closeModal()
    {
        $this->show_modal_create_group_role = false;
        $this->show_modal_add_users = false;
        $this->load_role_group_data();
    }

    /**
     * Pesquisar
     * Grupos, usuarios ou permissionss
     */
    public function updatedSearch()
    {

    }
    /**
     * Pesquisar
     * Grupos, usuarios ou permissionss
     */
    public function updatedGroupRole()
    {
        $this->load_role_group_data();
    }

    public function load_role_group_data()
    {
        try {
            $this->selected_group_role = GlobalRoles::where('identifier', $this->group_role)->with('users')->first();
        } catch (\Throwable $th) {
            session()->flash('Ocorreu um erro, ou um conflito no grupo.
                Esse grupo pode ter sido removido por um outro usuario no
                momento em que tentou acessar os dados. Reporte com administrator caso esse volte a ocorrer');
        }
        if($this->show_modal_create_group_role) return;
        $this->role_available_permissions = Yaml::parse($this->selected_group_role['permissions'] ?? '') ?? [];
        $this->role_permissions = Yaml::parse($this->selected_group_role['permissions'] ?? '') ?? [];
    }

    /**
     * Pesqusar usuarios na lista de usuarios a
     * add no grupo de permissions
     */
    public function updatedUsername()
    {
        if($this->username !== null){
            $this->users = User::where('status', true)->where('type', 'User')
                ->where(function($query){
                    $query->where('firstname', 'like', '%'.$this->username . '%')
                    ->orWhere('lastname', 'like', '%'.$this->username. '%');
                })->get();
        }
    }

    public function store_users_on_roles()
    {
        foreach($this->selected_members_ids as $user_id){
            try {
                if(!GlobalRolesUsers::where('user_id', $user_id)->where('global_role_id', $this->selected_group_role->id)->first()){
                    $grupo_role_user = new GlobalRolesUsers();
                    $grupo_role_user->global_role_id = $this->selected_group_role->id;
                    $grupo_role_user->user_id = $user_id;
                    $grupo_role_user->created_on = now();
                    $grupo_role_user->save();
                }
            } catch (\Throwable $th) {
                session()->flash('error', "Ocorreu um erro ao adicionar user no grupo de permissões");
                // throw $th;
            }
        }
        session()->flash('success', __('lang.notice_successful_create'));
        $this->closeModal();
    }

    public function store_global_role()
    {
        $this->resetErrorBag();
        $this->resetValidation();

        if($this->is_grupo_role_update){
            $this->validate([
                'group_role_name' => 'required',
            ], [
                'required' => __('lang.errors.messages.required'),
            ], [
                'group_role_name' => 'Nome do grupo de permissões'
            ]);

            try {
                $this->selected_group_role->name = $this->group_role_name;
                $this->selected_group_role->identifier = str_replace(' ', '_', strtolower($this->group_role_name));
                $this->selected_group_role->permissions = Yaml::dump($this->role_permissions);
                $this->selected_group_role->updated_on = now();
                $this->selected_group_role->save(); // Save data into database
                session()->flash('success', __('lang.notice_successful_update'));
                $this->closeModal();
            } catch (\Throwable $th) {
                session()->flash('error', "Ocorreu um erro ao atualziar o grupo de permissões");
                // throw $th;
            }
        }else{
            $this->validate([
                'group_role_name' => 'required|unique:global_roles,name',
            ], [
                'required' => __('lang.errors.messages.required'),
                'unique' => __('lang.errors.messages.taken')
            ], [
                'group_role_name' => 'Nome do grupo de permissões'
            ]);

            try {
                $grupo_role = new GlobalRoles();
                $grupo_role->name = $this->group_role_name;
                $grupo_role->identifier = str_replace(' ', '_', strtolower($this->group_role_name));
                $grupo_role->permissions = Yaml::dump($this->role_permissions);
                $grupo_role->created_by = auth()->user()->id;
                $grupo_role->created_on = now();
                $grupo_role->updated_on = now();

                $grupo_role->save(); // Save data into database
                session()->flash('success', __('lang.label.notice_successful_create'));
                $this->closeModal();
            } catch (\Throwable $th) {
                session()->flash('error', "Ocorreu um erro ao criar grupo de permissões");
                // throw $th;
            }
        }
    }

    public $enable_delete_grupo_role = [];
    public function remover_grupo_role($grupo_role_id = null, $is_submit = false)
    {
        if(!$is_submit){
            $this->enable_delete_grupo_role = array($grupo_role_id);
            return;
        }
        try {
            $this->selected_group_role->deleted_by = auth()->user()->id;
            $this->selected_group_role->deleted_at = now();

            $this->selected_group_role->global_role_users()->delete();
            $this->selected_group_role->save();

            $this->groups = GlobalRoles::get();
            $this->load_role_group_data();

            session()->flash('success', __('lang.notice_successful_delete'));
            return;
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', 'Ocorreu um erro ao remover o grupo de permissões');
            return;
        }

    }

    public function uncheckAll($permission)
    {
        $this->role_permissions = [];
    }

    public $enable_delete_on = [];
    public function remover_role_member($global_role_id = null, $user_id = null, $is_submit = false)
    {
        if(!$is_submit){
            $this->enable_delete_on = array($user_id);
            return;
        }

        try {
            GlobalRolesUsers::where('global_role_id', $global_role_id)->where('user_id', $user_id)->delete();
            $this->load_role_group_data();
            $this->cancel_action();
            session()->flash('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            // throw $th;
            session()->flash('error', "Ocorreu um erro ao remover o usuario do grupo de permissões");
        }
    }

    public function cancel_action()
    {
        $this->enable_delete_grupo_role = [];
        $this->enable_delete_on = [];
    }
}
