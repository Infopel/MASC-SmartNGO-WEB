<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enumerations extends Model
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
    protected $table = 'enumerations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'position', 'is_default', 'type', 'active', 'project_id', 'parent_id', 'position_name'
    ];

    public function issues()
    {
        return $this->hasMany('App\Models\Issues', 'priority_id', 'id')->where('type', 'IssuePriority');
    }
}
