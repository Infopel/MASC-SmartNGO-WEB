<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workflows extends Model
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
    protected $table = 'workflows';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'tracker_id', 'old_status_id', 'new_status_id', 'role_id', 'assignee', 'author', 'type', 'field_name', 'rule'
    ];
}
