<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovementFlow extends Model
{

    use SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Databse Table
     */
    protected $table = 'approvement_flow';

    /**
     * Database Columns
     */
    protected $fillable = ['id', 'type', 'position', 'description', 'trigger', 'role_id', 'is_active', 'email_content', 'unapproval_email_content', 'author_id', 'approved_goto', 'has_decision_tree', 'decision_tree_id', 'approved_goto', 'not_approved_goto', 'created_on', 'updated_on', 'deleted_at', 'is_flow_end'];

    /**
     * Casts
     */
    protected $casts = ['created_on', 'updated_on'];

    public function role()
    {
        return $this->belongsTo('App\Models\Roles', 'role_id', 'id');
    }


    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }


    /**
     * Trigger
     */
    public function trigger_by()
    {
        return $this->hasOne($this, 'id', 'trigger');
        // ->where('trigger', '!=', 'NewIssue');
    }

    public function approvement_models()
    {
        return $this->hasMany(ApprovementFlowModels::class, 'approvement_flow_id', 'id');
    }

    public function aprovement_flow_step(string $stepFlow)
    {
        return $this->hasMany(ValidationFlowDataStore::class, 'flow_id', 'id')
            ->where('flow_id', $stepFlow)
            ->with('project');
        // ->where('customized_type', 'ProjectValitionAction');
    }

    public function decision_tree()
    {
        return $this->hasOne(WorkFlowDecisionTree::class, 'id', 'decision_tree_id');
    }
}
