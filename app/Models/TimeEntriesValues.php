<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeEntriesValues extends Model
{
    use SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    //table
    public $table = 'time_entries_values';

    protected $fillable = ['id', 'customized_id', 'customized_type', 'time_entry_id', 'variavel', 'value', 'created_on', 'deleted_at'];

    protected $casts = ['created_on'];

    protected $dates = ['created_on'];

    public function indicator_issue_values()
    {
        return $this->belongsTo('App\Models\IndicatorFieldsValues', 'customized_id', 'id')
            ->with([
                'indicator_field' => function ($query) {
            // $q->where('customized_id', '=', 'issue_id');
                }
            ]);
    }

    public function indicador()
    {
        return $this->belongsTo('App\Models\IndicatorFields', 'customized_id', 'id')->with('indicator_issue_values');
    }

    public function time_entry()
    {
        return $this->belongsTo('App\Models\TimeEntries', 'time_entry_id', 'id')->with('user:id,firstname,lastname');
    }

    public function rubrica()
    {
       return $this->belongsTo('App\Models\BudgetsValues', 'customized_id', 'id')->where('customized_type', 'issue');
    }
}
