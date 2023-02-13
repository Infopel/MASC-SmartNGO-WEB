<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
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
    protected $table = 'news';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'project_id', 'title', 'summary', 'description', 'author_id', 'created_on', 'comments_count'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_on'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_on' => 'created_on',
    ];


    public function project()
    {
        return $this->belongsTo('App\Models\Projects', 'project_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany('App\Models\Attachments', 'container_id', 'id')->where('container_type', 'News')->with('user');
    }
}
