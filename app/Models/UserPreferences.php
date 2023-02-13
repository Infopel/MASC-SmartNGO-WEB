<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreferences extends Model
{
    /**
     * Desable timestamps
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_preferences';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'others', 'hide_mail', 'time_zone'];

}
