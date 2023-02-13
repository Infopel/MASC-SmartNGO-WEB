<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlowReportTask extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'flow_report_task';

    protected $fillable = ['id', 'time_entrie_id', 'custom_type', 'flow_id', 'flow_description', 'validator_category', 'assigned_to', 'request_by', 'is_approved', 'approved_by', 'approved_on', 'is_rejected', 'rejected_on', 'rejected_by', 'notes', 'created_on', 'updated_on'];


    protected $appends = [
        'route',
    ];

    public function getRouteAttribute()
    {
        return $this->url_route();
    }

    /**
     * Rota do report
     */
    public function url_route()
    {

        if ($this->id !== null) {
            return route('time_entries.issues', ['issue' => $this->time_entrie->issue->id]);
        }

        return null;
    }

    public function assignedTo()
    {
        return $this->belongsTo('App\Models\User', 'assigned_to', 'id');
    }

    public function flow()
    {
        return $this->belongsTo('App\Models\ApprovementFlow', 'flow_id', 'id')->with('role');
    }

    public function requestBy()
    {
        return $this->belongsTo('App\Models\User', 'request_by', 'id');
    }

    public function rejectedBy()
    {
        return $this->belongsTo('App\Models\User', 'rejected_by', 'id');
    }

    public function approvedBy()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }

    public function time_entrie()
    {
        return $this->belongsTo('App\Models\TimeEntries', 'time_entrie_id', 'id')->with('issue')->whereHas('issue');
    }
}
