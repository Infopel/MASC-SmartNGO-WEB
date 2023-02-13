<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomFields extends Model
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
    protected $table = 'custom_fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'type', 'name', 'field_format', 'possible_values', 'regexp', 'min_length', 'max_length', 'is_required', 'is_for_all', 'is_filter', 'position', 'searchable', 'editable', 'visible', 'multiple', 'format_store', 'description'
    ];

    public function custom_values()
    {
        return $this->hasMany('App\Models\CustomValues', 'custom_field_id', 'id');
    }
}
