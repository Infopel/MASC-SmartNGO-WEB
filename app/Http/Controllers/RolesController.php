<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\RolesManagedRoles;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('ver_permisoes', Roles::class)) {
            abort(401);
        }

        $roles = Roles::select('id', 'name','position', DB::raw('case when position = 0 then 999+1 else position end as position'))
            ->orderby('position', 'asc')
            ->get();

        foreach ($roles as $role) {
            $role['default'] = false;
            if ($role->name == 'Anonymous') {
                $role['name'] = __('lang.label_role_anonymous');
                $role['default'] = true;
            }
            if ($role->name == 'Non member') {
                $role['name'] = __('lang.label_role_non_member');
                $role['default'] = true;
            }
        }

        // $data = array(
        //     'roles' => $roles
        // );
        // return $roles;
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('criar_permissoes', Roles::class)) {
            abort(401);
        }

        $roles  = Roles::select('id', 'name')->where('builtin', false)->get();
        $role = [];
        // return $roles;
        return view('roles.new', compact('role', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->can('criar_permissoes', Roles::class)){
            abort(401);
        }
        // Validar o request de cadastro de Permissoes
        $request->validate([
            'role.name' => 'required|unique:roles,name|max:30'
        ],[
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken'),
            // 'max' => __('lang.errors.messages.')
        ]);

        $position = Roles::select('position')->latest('id')->first()->position ?? 0;
        // Iniciar o cadastro
        try {
            DB::beginTransaction();

            $role = new Roles();
            $role->name = $request->role['name'];
            $role->position = ++$position;
            $role->assignable = $request->role['assignable'];
            $role->permissions = Yaml::dump(
                $request->role['permissions']
            );
            $role->issues_visibility = $request->role['issues_visibility'];
            $role->users_visibility = $request->role['users_visibility'];
            $role->time_entries_visibility = $request->role['time_entries_visibility'];
            $role->all_roles_managed = $request->role['all_roles_managed'];
            // $role->settings = $request->role['settings'];
            $role->save(); // Save data into database

            if($request->role['managed_role_ids'] != null && is_array($request->role['managed_role_ids'])){
                foreach ($request->role['managed_role_ids'] as $value) {
                    $roles_managed = new RolesManagedRoles();
                    $roles_managed->role_id = $role->id;
                    $roles_managed->managed_role_id = $value;
                    $roles_managed->save(); // Save data into database
                }
            }

            DB::commit();
            return redirect()->route('roles.index')->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return back()->with('error', 'Occoue um erro! RF007x0001 - Roles');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function show(Roles $role)
    {
        return $role;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function edit(Roles $role)
    {
        if(!auth()->user()->can('atualizar_permissoes', $role)){
            abort(401);
        }
        $roles  = Roles::select('id', 'name')->where('builtin', false)->where('id', '!=', $role->id)->get();
        $role->permissions = Yaml::parse($role->permissions);

        // Get the managed roles
        $managed_roles = array();
        foreach ($role->managed_roles()->get() as $key => $value) {
            // Create array of avalible managed roles
            $managed_roles[] = $value->managed_role_id;
        }
        // Check if roles is managed and assign true or false
        foreach ($roles as $_role){
            if(in_array($_role->id, $managed_roles)){
                $_role->is_managed = true;
            }else{
                $_role->is_managed = false;
            }
        }
        // return $roles;
        return view('roles.edit', compact('role', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Roles $role)
    {
        if (!auth()->user()->can('atualizar_permissoes', $role)) {
            abort(401);
        }
        // Validar o request de cadastro de Permissoes
        $request->validate([
            'role.name' => 'required|max:30'
        ], [
            'required' => __('lang.errors.messages.required'),
            // 'max' => __('lang.errors.messages.')
        ]);

        // return $request;
        // Iniciar o Update
        try {
            DB::beginTransaction();

            $role->name = $request->role['name'];
            $role->assignable = $request->role['assignable'];
            $role->permissions = Yaml::dump(
                $request->role['permissions']
            );
            $role->issues_visibility = $request->role['issues_visibility'];
            $role->users_visibility = $request->role['users_visibility'];
            $role->time_entries_visibility = $request->role['time_entries_visibility'];
            $role->all_roles_managed = $request->role['all_roles_managed'];

            if ($request->role['managed_role_ids'] != null && is_array($request->role['managed_role_ids'])) {
                // Remover os roles_managed
                $roles_managed_ = RolesManagedRoles::where('role_id', $role->id)->delete();
                // Adicionar o novos roles managed_role_ids
                foreach ($request->role['managed_role_ids'] as $value) {
                    $roles_managed = new RolesManagedRoles();
                    $roles_managed->role_id = $role->id;
                    $roles_managed->managed_role_id = $value;
                    $roles_managed->save(); // Save data into database
                }
            }else{
                // Remover os roles_managed
                $roles_managed_ = RolesManagedRoles::where('role_id', $role->id)->delete();
            }
            // Gravar dados
            $role->update(); // Update and Save data into database
            DB::commit();
            return redirect()->route('roles.index')->with('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
            return back()->with('error', 'Occoue um erro na actualizacao de dados! RF007x0001 - Roles');
        }

    }


    /**
     * Pedir confirmacao de remocao de Role Permissions
     */
    public function remove_permission(Roles $role)
    {
        if (!auth()->user()->can('excluir_permissoes', $role)) {
            abort(401);
        }

        return back()->with('isRemoveTrue', [
            'msg' => __('lang.text_are_you_sure'),
            'role_id' => $role->id,
            'role_name' => $role->name,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roles $role)
    {
        if (!auth()->user()->can('excluir_permissoes', $role)) {
            abort(401);
        }

        try {
            $role->delete();
            return back()->with('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Occoue um erro durante a remocao de dados.');
        }
    }
}
