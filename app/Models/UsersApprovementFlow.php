<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersApprovementFlow extends Model
{
    public $timestamps = false;

    /**
     * Databse Table
     */
    protected $table = 'users_approvement_flow';

    /**
     * Database Columns
     */
    protected $fillable = ['id', 'user_id', 'approvement_flow_models_id', 'created_on', 'updated_on', 'is_approved', 'is_rejected'];

    /**
     * Casts
     */
    protected $casts = ['created_on', 'updated_on'];

    /**
     * Issues, Projects to Approve
     */
    public function aprovements()
    {
        return $this->hasMany(ApprovementFlowModels::class, 'approvement_flow_models_id', 'id');
    }

    /**
     * User Author
     */
    public function aprovement()
    {
        return $this->belongsTo(ApprovementFlowModels::class, 'approvement_flow_models_id', 'id')
            ->with('approvement_flow', 'issue', 'requestBy')
            ->whereHas('approvement_flow')
            ->whereHas('issue');
    }

    /**
     * User Author
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id', 'user_id');
    }
}
