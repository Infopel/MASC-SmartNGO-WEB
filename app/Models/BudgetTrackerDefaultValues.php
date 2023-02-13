<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetTrackerDefaultValues extends Model
{
    use SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'budgets_default_values';

    protected $fillable = ['id', 'budget_tracker_id', 'provincia', 'value', 'author_id', 'created_on', 'updated_on', 'deleted_at'];

    protected $casts = [
        'created_on',
        'updated_on'
    ];

    protected $dates = [
        'created_on',
        'updated_on'
    ];

    public function budget_tracker()
    {
        return $this->belongsTo('App\Models\BudgetTrackers', 'budget_tracker_id', 'id');
    }
}
