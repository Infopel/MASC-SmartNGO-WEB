<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndicatorFieldsIssues extends Model
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
    protected $table = 'indicator_fields_issues';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'indicator_fields_id', 'issue_id', 'deleted_at'
    ];

    public function indicator_field()
    {
        return $this->belongsTo('App\Models\IndicatorFields', 'indicator_fields_id', 'id')->with(['indicator_issue_values' => function($q){
            // $q->where('customized_id', '=', 'issue_id');
        }]);
    }
}
