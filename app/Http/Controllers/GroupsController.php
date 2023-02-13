<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use App\Models\Groups;
use App\Models\Members;
use App\Models\GroupUsers;
use App\Models\CustomFields;
use App\Models\CustomValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Helpers\CustomFieldsHelper;

class GroupsController extends Controller
{
    use CustomFieldsHelper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = User::select('id', 'lastname', 'status')
            ->where('type', 'like', '%Group%')
            ->where('status', true)
            ->orderby('created_on', 'desc')->get();

        foreach ($groups as $group) {
            $_userGroup = GroupUsers::where('group_id', $group->id)->get();
            $group['_users'] = $_userGroup->count();
            $group['default'] = false;

            if($group->lastname == 'Anonymous users'){
                $group['lastname'] = __('lang.label_group_anonymous');
                $group['default'] = true;
            }
            if($group->lastname == 'Non member users'){
                $group['lastname'] = __('lang.label_group_non_member');
                $group['default'] = true;
            }
        }
        // return $groups;
        $data = array(
            'groups' => $groups
        );
        return view('groups.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $group = [];
        $_custom_fields = CustomFields::select('*')->where('type', 'GroupCustomField')->get();
        $custom_fields = $this->custom_field_tag_with_label(null, [], $_custom_fields);

        // return $custom_fields;
        return view('groups.new', compact('group', 'custom_fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'group.name' => 'required|unique:users,lastname',
        ],[
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken')
        ],[
            'group.name' => __('lang.field_name')
        ]);
        // return $request;
        try {
            DB::beginTransaction();
            $group = new User();
            $group->lastname = $request->group['name'];
            $group->type = 'Group';
            $group->created_on = now();
            $group->updated_on = now();
            $group->save();

            $this->user_custom_fildes_values($request['custom_field_values'] ?? [], $group->id);

            DB::commit();
            return back()->with('status', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('erros', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function show($group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function edit(User $group)
    {

        $_custom_fields = CustomFields::select('*')->where('type', 'GroupCustomField')->get();
        $custom_fields = $this->custom_field_tag_with_label($group->id, $group->groups_custom_values()->get(), $_custom_fields);

        // return $custom_fields;

        $_userGroup = GroupUsers::select('users.id as id', 'firstname', 'lastname', 'created_on')
            ->join('users', 'users.id', 'user_id')
            ->where('group_id', $group->id)
            ->get();

        $projects = Members::select('project_id', 'name', 'identifier', 'role_id')
            ->where('user_id', $group->id)
            ->join('projects', 'projects.id', 'project_id')
            ->join('member_roles', 'member_id', 'members.id')
            ->orderby('members.created_on', 'desc')
            ->get();

        $_role = [];
        $_project = [];
        $old_project = null;
        foreach ($projects as $project) {
            $roles = Roles::select('name')->where('id', $project->role_id)->first();

            if ($project->project_id == $old_project) {
                $__role[] = $roles->name;
                $_role = \implode(', ', $__role);

                $_project[$project->identifier] = array(
                    'project_id' => $project->project_id,
                    'name' => $project->name,
                    'identifier' => $project->identifier,
                    'role_id' => $project->role_id,
                    'roles' => $_role,
                );
            } else {
                $__role = array($roles->name);
                $_role = \implode(', ', $__role);
                $_project[$project->identifier] = array(
                    'project_id' => $project->project_id,
                    'name' => $project->name,
                    'identifier' => $project->identifier,
                    'role_id' => $project->role_id,
                    'roles' => $_role,
                );
            }
            // $__role = [];
            $old_project = $project->project_id;
        }

        $projects = [];


        $group['projects'] = $_project;
        $group['users'] = $_userGroup;

        // return $group;
        return view('groups.edit', compact('group', 'custom_fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  User $group)
    {

        // $this->authorize('update', $group, User::class);

        // if(Auth::user()->can('update', 1)){
        // }else{
        //     return back()->with('erros', 'This action is unauthorized');
        // }

        $request->validate([
            'group.name' => 'required',
        ],[
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken')
        ],[
            'group.name' => __('lang.field_name')
        ]);
        if ($group->lastname == $request->group['name']) {
            // return back()->with('status', __('lang.notice_successful_update'));
        }else{
            $request->validate([
                'group.name' => 'unique:users,lastname',
            ], [
                'unique' => __('lang.errors.messages.taken')
            ], [
                'group.name' => __('lang.field_name')
            ]);
        }
        // return $request;
        try {
            DB::beginTransaction();

            $group->lastname = $request->group['name'];
            $group->updated_on = now();
            $group->update();

            $this->user_custom_fildes_values($request['custom_field_values'] ?? [], $group->id);

            DB::commit();

            return back()->with('status', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('erros', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = User::where('type', 'Group')->where('id', $id)->firstOrFail();
        if (GroupUsers::where('group_id', $id)->first()) {
            return back()->with('erros', "Ocorreu um Erro! Esse grupo não pode ser removido.");
        }
        try {
            $group->delete();
            return back()->with('status', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            return back()->with('erros', $th->getMessage());
        }
    }


    /**
     * Adicional Group CustomValues
     */
    protected function user_custom_fildes_values($custom_field_values, $customized_id)
    {
        foreach ($custom_field_values as $field => $value) {
            if (\is_array($value)) {

                CustomValues::where('customized_type', 'Group')
                    ->where('customized_id', $customized_id)
                    ->where('custom_field_id', $field)
                    ->delete();

                foreach ($value as $user_cv_value) {
                    if ($user_cv_value == null) {
                    } else {
                        // Performe save query
                        $custom_values = new CustomValues();
                        $custom_values->customized_type = 'Group';
                        $custom_values->customized_id = $customized_id;
                        $custom_values->custom_field_id = $field;
                        $custom_values->value = $user_cv_value;
                        $custom_values->save(); // Save data into database
                    }
                }
            } else {
                // Performe save query
                $custom_values = CustomValues::where('customized_type', 'Group')
                    ->where('customized_id', $customized_id)
                    ->where('custom_field_id', $field)
                    ->first();

                if ($custom_values) {
                    $custom_values->value = $value;
                    $custom_values->update(); // Save data into database
                } else {
                    $custom_values = new CustomValues();
                    $custom_values->customized_type = 'Group';
                    $custom_values->customized_id = $customized_id;
                    $custom_values->custom_field_id = $field;
                    $custom_values->value = $value;
                    $custom_values->save(); // Save data into database
                }
            }
        }
    }


    /**
     * Add Users to group
     */

    public function addUsers(User $group, Request $request)
    {
        foreach($request->user_ids as $key => $status){
            if($status){
                $isUserAdded = GroupUsers::where('group_id', $group->id)->where('user_id', $key)->first();
                if($isUserAdded){
                }else{
                    // echo 'save';
                    // Create new UserGroups Resource
                    $add_to_group = new GroupUsers();
                    $add_to_group->group_id = $group->id;
                    $add_to_group->user_id = $key;
                    $add_to_group->save(); // Save data into database
                }
            }
        }

        return GroupUsers::where('group_id', $group->id)->with('user')->get();
    }
}
