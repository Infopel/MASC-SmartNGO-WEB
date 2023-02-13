<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetTrackersBaseValues extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'Budget_trackers_base_values';

    protected $fillable = ['id', 'budget_tracker_id', 'value','variavel', 'variavel_value', 'created_on', 'updated_on'];

    protected $casts = ['created_on', 'updated_on'];
}
