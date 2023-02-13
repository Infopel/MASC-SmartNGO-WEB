<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
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
    protected $table = 'documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'project_id', 'category_id', 'title', 'description', 'created_on'
    ];


    public function project()
    {
        return $this->belongsTo('App\Models\Projects', 'project_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Enumerations', 'category_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany('App\Models\Attachments', 'container_id', 'id')->where('container_type', 'Documents')->with('user');
    }

}
