<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTrackers extends Model
{
    protected $primaryKey = 'tracker_id';

    public $incrementing = false;

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
    protected $table = 'projects_trackers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id', 'tracker_id'
    ];

    protected $project_id;

    /**
     * Project tracker belengo to tracker
     */
    public function tracker($project_id = null)
    {
        return $this->belongsTo('App\Models\Trackers', 'tracker_id', 'id')->with(['issues' => function ($q) use ($project_id) {
            $q->where('issues.project_id', $project_id)->with('status');
        }])->with('default_status');
    }
}
