<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolesManagedRoles extends Model
{
    //

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles_managed_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'managed_role_id'
    ];


    public function role()
    {
        return $this->belongsTo('App\Models\Roles', 'role_id', 'id');
    }

}
