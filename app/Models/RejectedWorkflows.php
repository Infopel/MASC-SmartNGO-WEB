<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RejectedWorkflows extends Model
{
    use SoftDeletes;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /* The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rejected_workflows';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'flow_id', 'flow_type', 'customized_type', 'customized_id', 'requested_by', 'action_by', 'reject_notes', 'created_on'
    ];
}
