<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkFlowDecisionTree extends Model
{
    use SoftDeletes;
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
    protected $table = 'workflow_decision_tree';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'on_positive_goto', 'on_negative_goto', 'app_workflow_id', 'author_id', 'created_on', 'updated_on', 'deleted_at'
    ];


    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }

    public function app_workflow()
    {
        return $this->belongsTo('App\Models\AppApprovementFlows', 'app_workflow_id', 'id');
    }

    public function approvement_flow()
    {
        return $this->belongsTo('App\Models\ApprovementFlow', 'id', 'decision_tree_id');
    }

    public function wf_positive_decision()
    {
        return ApprovementFlow::where('id', \str_replace('flow_', '', $this->on_positive_goto))->first();
    }
    public function wf_negative_decision()
    {
        return ApprovementFlow::where('id', \str_replace('flow_', '', $this->on_negative_goto))->first();
    }
}
