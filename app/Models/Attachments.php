<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
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
    protected $table = 'attachments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'container_id', 'container_type', 'filename', 'disk_filename', 'filesize', 'content_type', 'digest', 'downloads', 'author_id', 'created_on', 'description', 'disk_directory'
    ];

    public function download_link()
    {
        return route('attachments.download', ['attachment' => $this, 'filename' => $this->filename]);
    }


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }

    public function news()
    {
        return $this->hasOne('App\Models\News', 'id', 'container_id');
    }

    public function project()
    {
        return $this->hasOne('App\Models\Projects', 'id', 'container_id');
    }

    public function document()
    {
        return $this->hasOne('App\Models\Documents', 'id', 'container_id');
    }

}
