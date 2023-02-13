<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberRoles extends Model
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
    protected $table = 'member_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'member_id', 'role_id', 'inherited_from'
    ];

    public function member()
    {
        return $this->belongsTo('App\Models\User', 'id', 'member_id');
    }

    /**
     * Return Project Role
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Roles', 'role_id', 'id')->select('id', 'name', 'permissions');
    }

    /**
     * Get role tha belongsTo to member_project
     */
    public function roles()
    {
        return $this->hasMany('App\Models\Roles', 'id', 'role_id')->select('id', 'name', 'permissions');
    }
}
