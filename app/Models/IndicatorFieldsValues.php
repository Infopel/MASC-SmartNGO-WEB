<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndicatorFieldsValues extends Model
{
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
    protected $table = 'indicator_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'indicator_type', 'indicator_field_id', 'customized_id', 'value', 'meta', 'meta_type', 'm_trim_01', 'm_trim_02', 'm_trim_03', 'm_trim_04', 'fonte_ver', 'base_ref', 'created_on', 'updated_on'
    ];

    /**
     * Retorna o valor das entradas do tempo de trabalho do indicador
     */
    public function time_entries_values()
    {
        return $this->hasMany('App\Models\TimeEntriesValues', 'customized_id', 'indicator_field_id');
    }

    // /**
    //  * Entradas de tempo de trabalho
    //  */
    public function time_entries()
    {
        return $this->hasMany('App\Models\TimeEntries', 'indicator_id', 'id')->with('time_entries_values');
    }

    public function indicator_field()
    {
        return $this->belongsTo('App\Models\IndicatorFields', 'indicator_field_id', 'id');
    }
}
