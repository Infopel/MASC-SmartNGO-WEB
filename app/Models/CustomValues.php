<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomValues extends Model
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
    protected $table = 'custom_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'customized_type', 'customized_id', 'custom_field_id', 'value'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'created_at',
    ];

    public function custom_field()
    {
        return $this->belongsTo('App\Models\CustomFields', 'custom_field_id', 'id');
    }
}
