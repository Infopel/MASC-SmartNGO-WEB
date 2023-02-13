<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'position', 'assignable', 'builtin', 'permissions', 'issues_visibility', 'users_visibility', 'time_entries_visibility', 'all_roles_managed', 'settings'
    ];

    public function managed_roles()
    {
        return $this->hasMany('App\Models\RolesManagedRoles', 'role_id', 'id');
    }
}
