<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomFieldsTrackers extends Model
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
    protected $table = 'custom_fields_trackers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'custom_field_id', 'tracker_id'
    ];


    /**
     * Tracker
     */
    public function tracker()
    {
        return $this->belongsTo('App\Models\Trackers', 'tracker_id', 'id');
    }

    /**
     * Field Object
     */
    public function custom_field()
    {
        return $this->belongsTo(CustomFields::class, 'custom_field_id', 'id');
    }
}
