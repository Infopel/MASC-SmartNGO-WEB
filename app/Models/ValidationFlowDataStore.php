<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidationFlowDataStore extends Model
{
    /**
     * Desable timestamps
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'flow_data_store';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'tagCode', 'flow_id', 'flow_description', 'validator_category', 'customized_id', 'customized_type', 'assignedTo', 'is_approved', 'request_by', 'approved_by', 'approved_on', 'created_on', 'deleted_at', 'is_rejected', 'rejected_by', 'rejected_on'
    ];


    public function project()
    {
        return $this->belongsTo('App\Models\Projects', 'customized_id', 'id');
        return $this->belongsTo(Projects::class, 'a');
    }
}
