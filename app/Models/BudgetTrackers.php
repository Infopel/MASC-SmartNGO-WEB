<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetTrackers extends Model
{
    use SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'budget_trackers';

    protected $fillable = ['id', 'name', 'type', 'position', 'status', 'created_on', 'updated_on'];

    protected $casts = ['created_on', 'updated_on'];

    protected $dates = ['created_on', 'updated_on'];

    public function budgets()
    {
        return $this->hasMany('App\Models\Budgets', 'budget_tracker_id', 'id');
    }

    /**
     * Has Valor Base
     */
    public function default_value_provincia($provincia = null)
    {
        return $this->hasOne('App\Models\BudgetTrackerDefaultValues', 'budget_tracker_id', 'id')->where('provincia', $provincia)->first();
    }
}
