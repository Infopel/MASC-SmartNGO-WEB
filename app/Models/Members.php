<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
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
    protected $table = 'members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'project_id', 'created_on', 'mail_notification'
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
        'created_on' => 'datetime',
    ];

    /**
     * GET Members
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->select('id', 'firstname', 'lastname');
    }

    public function member_roles()
    {
        return $this->belongsTo('App\Models\MemberRoles', 'id', 'member_id')->with('roles');
    }

    public function project_roles()
    {
        return $this->hasMany('App\Models\MemberRoles', 'member_id', 'id')->with('role');
    }

    /**
     * GET Members Projects
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Projects', 'project_id', 'id');
    }

    public function memeberAssigenedIssues()
    {
        return Issues::where('assigned_to_id', $this->user->id)->count();
    }

    public function memeberCreatedIssues()
    {
        return Issues::where('author_id', $this->user->id)->count();
    }
}
