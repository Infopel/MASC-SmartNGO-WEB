<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Watchers extends Model
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
    protected $table = 'watchers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'watchable_type', 'watchable_id', 'user_id'];


    /**
     * User watchers
     */

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

}
