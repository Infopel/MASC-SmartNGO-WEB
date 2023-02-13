<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueStatuses extends Model
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
    protected $table = 'issue_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'is_closed', 'position', 'default_done_ratio'
    ];
}
