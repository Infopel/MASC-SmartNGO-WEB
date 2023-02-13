<?php

namespace App\Http\Controllers\Helpers;

use App\Models\User;
use App\Models\GroupUsers;

trait MembersGroupsHelper
{

    /**
     * Retorna uma lista de usuarios
     */
    public function getUsers()
    {
        $users = User::where('status', true)->where('type', 'User')->get();
        return $users;
    }

    public function searchUsers($getUser)
    {
        $this->username = $getUser;
        return User::where('status', true)->where('type', 'User')
            ->where(function ($q) {
                $q->where('firstname', 'like', '%' . $this->username . '%')
                    ->orWhere('lastname', 'like', '%' . $this->username . '%');
            })->get();
    }

    /**
     * Retorna os members do project
     *
     */
    public function group_members($group_id)
    {
        if ($group_id == null) {
            return [];
        }
        try {
            $members = GroupUsers::where('group_id', $group_id)->with('user')->get()->toArray();
            return $members;
        } catch (\Throwable $th) {
            // return back()->with('error', 'Ocorreu um erro no carregamento de dados de groupos de usarios!');
        }
    }

    /**
     * Adicionar Membros ao Projecto
     */
    public function add_group_members(array $selected_members, $group_id)
    {
        foreach ($selected_members as $key => $member_id) {
            try {
                $check_member = GroupUsers::where('group_id', $group_id)->where('user_id', $member_id)->first();
                if ($check_member) {
                } else {
                    $new_group_memmber = new GroupUsers();
                    $new_group_memmber->user_id = $member_id;
                    $new_group_memmber->group_id = $group_id;
                    $new_group_memmber->save(); // Save data into database
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        return $this->group_members($group_id);
    }

    /**
     * Remove member project
     */
    public function remove_group_members($group_id, $user_id)
    {
        try {
            GroupUsers::where('group_id', $group_id)->where('user_id', $user_id)->delete();
        } catch (\Throwable $th) {
            // throw $th;
        }
        return $this->group_members($group_id);
    }

}
