<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndicatorFields extends Model
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
    protected $table = 'indicator_fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'type', 'name', 'is_cumulative', 'is_parent', 'category', 'created_on', 'updated_on', 'deleted_at'
    ];


    public function indicator_values()
    {
        return $this->hasMany('App\Models\IndicatorFieldsValues', 'indicator_field_id', 'id');
    }

    public function indicator_issue_values()
    {
        return $this->belongsTo('App\Models\IndicatorFieldsValues', 'id', 'indicator_field_id');
    }
}
