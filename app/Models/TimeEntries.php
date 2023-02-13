<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeEntries extends Model
{
    use SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'time_entries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 
        'project_id', 
        'user_id', 
        'issue_id', 
        'indicator_id', 
        'hours', 
        'comments', 
        'activity_id', 
        'spent_on', 
        'tyear', 
        'tmonth', 
        'tweek', 
        'start_date', 
        'due_date', 
        'peoople_to_inform',
        'evidence_type',
        'verification_type',
        'metting_descrption',
        'metting_result',
        'challenge_lessons',
        'falloup',
        'masc_contribuition',
        'created_on', 
        'updated_on', 
        'deleted_at', 
        'is_reported', 
        'is_approved'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_on', 'updated_on'];

    /**
     * Retorna o valor das entradas do tempo de trabalho do indicador
     */
    public function time_entries_values()
    {
        return $this->hasMany('App\Models\TimeEntriesValues', 'time_entry_id', 'id')->with(['rubrica', 'indicator_issue_values', 'indicador']);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function issue()
    {
        return $this->belongsTo('App\Models\Issues', 'issue_id', 'id')->with(['project']);
    }

    public function atividade()
    {
        return $this->belongsTo('App\Models\Enumerations', 'activity_id', 'id')->where('type', 'TimeEntryActivity');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Projects', 'project_id', 'id');
    }

    public function approvements()
    {
        return $this->hasMany('App\Models\FlowReportTask', 'time_entrie_id', 'id');
    }
}
