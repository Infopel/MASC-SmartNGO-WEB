<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalRolesUsers extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'global_roles_users';

    protected $fillable = ['global_role_id', 'user_id', 'created_on','deleted_at'];
}
