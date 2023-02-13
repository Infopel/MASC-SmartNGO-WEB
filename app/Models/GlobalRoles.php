<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GlobalRoles extends Model
{

    use SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'global_roles';

    protected $fillable = ['id', 'identifier', 'name', 'permissions', 'created_by', 'created_on', 'updated_on', 'deleted_at', 'deleted_by', 'builtin'];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'global_roles_users', 'global_role_id', 'user_id');
    }

    public function global_role_users()
    {
        return $this->hasMany('App\Models\GlobalRolesUsers', 'global_role_id', 'id');
    }
}
