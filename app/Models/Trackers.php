<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trackers extends Model
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
    protected $table = 'trackers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'is_in_chlog', 'position', 'is_in_roadmap', 'fields_bits', 'core_fields', 'default_status_id', 'use_workflow', 'assined_workflow_tag', 'updated_on', 'deleted_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'created_at',
    ];

    public function default_status()
    {
        return $this->belongsTo('App\Models\IssueStatuses', 'default_status_id', 'id');
    }

    public function issues()
    {
        return $this->hasMany('App\Models\Issues', 'tracker_id', 'id');
    }

    public function workflow_rules()
    {
        return $this->hasMany('App\Models\Workflows', 'tracker_id', 'id');
    }

    public function custom_fields_trackers()
    {
        return $this->hasMany('App\Models\CustomFieldsTrackers', 'tracker_id', 'id');
    }

    public function projects_trackers()
    {
        return $this->hasMany('App\Models\ProjectTrackers', 'tracker_id', 'id');
    }
}
