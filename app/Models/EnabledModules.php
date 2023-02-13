<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnabledModules extends Model
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
    protected $table = 'enabled_modules';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'project_id', 'name'
    ];
}
