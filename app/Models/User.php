<?php

namespace App\Models;

use App\Macro\AppBoot;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $appends = [
        'full_name'
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->user_formats(AppBoot::application()['user_format']);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'login', 'password', 'firstname', 'lastname', 'admin', 'status', 'email_verified_at', 'last_login_on', 'language', 'auth_source_id', 'remember_token', 'created_on', 'updated_on', 'type', 'identity_url', 'must_change_passwd', 'passwd_changed_on', 'high_privileg', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'identity_url', 'must_change_passwd', 'auth_source_id', 'high_privileg', 'last_login_on', 'high_privilege', 'email_verified_at', 'passwd_changed_on',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = ['created_on', 'updated_on'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'created_on' => 'datetime',
        // 'updated_on' => 'datetime',
    ];

    /**
     * The Eamil address that belong to the user.
     */
    public function email()
    {
        return $this->hasOne('App\Models\EmailAddresses', 'user_id', 'id');
    }

    public function email_address()
    {
        return $this->hasOne('App\Models\EmailAddresses', 'user_id', 'id');
    }

    public function email_addresses()
    {
        return $this->hasMany('App\Models\EmailAddresses', 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\GlobalRoles', 'global_roles_users', 'user_id', 'global_role_id');
    }

    /**
     * user custom values
     */
    public function groups()
    {
        return $this->hasMany($this, 'id', 'id')->where('type', 'Group')->where('status', true);
    }

    public function user_groups()
    {
        return $this->hasMany(GroupUsers::class, 'user_id', 'id');
    }

    /**
     * user custom values
     */
    public function custom_values()
    {
        return $this->hasMany('App\Models\CustomValues', 'customized_id', 'id')->where('customized_type', 'Principal')->with('custom_field')->has('custom_field');
    }

    /**
     * user custom values
     */
    public function groups_custom_values()
    {
        return $this->hasMany('App\Models\CustomValues', 'customized_id', 'id')->where('customized_type', 'Group')->with('custom_field');
    }

    /**
     * Projectos criados pelo usuario
     */
    public function projects()
    {
        return $this->hasMany('App\Models\Projects', 'author_id', 'id');
    }

    /**
     * User Project roles
     */

    public function project_roles($role_id)
    {
        return $this->hasMany('App\Models\Roles', 'id', $role_id);
    }
    /**
     * User Preferences
     */

    public function user_preferences()
    {
        return $this->hasOne('App\Models\UserPreferences', 'user_id', 'id');
    }

    /**
     * Get Issues add by user
     */
    public function issues()
    {
        return $this->hasMany('App\Models\Issues', 'author_id', 'id')->with('project', 'tracker', 'status');
    }

    /**
     * Get Issues assigned_to user
     */
    public function issues_assigned_to_me()
    {
        return $this->hasMany('App\Models\Issues', 'assigned_to_id', 'id')->with('project', 'tracker', 'status');
    }

    /**
     * Get the projects where $this->user is a Member
     */
    public function member_of()
    {
        return $this->hasMany('App\Models\Members', 'user_id', 'id')->with('project', 'member_roles');
    }

    public function member_roles()
    {
        return $this->hasMany('App\Models\Members', 'user_id', 'id')->with('member_roles');
    }

    /**
     * User custom values
     */
    public function activities()
    {
        return $this->hasMany('App\Models\Issues', 'author_id', 'id')->with('childs');
    }

    # Different ways of displaying/sorting users
    public function user_formats($format)
    {
        $user_format = [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'username' => $this->login,
            'firstname_lastname' => $this->firstname . ' ' . $this->lastname,
            'lastname_firstname' => $this->lastname . ' ' . $this->firstname,
            'firstname_lastinitial' => $this->firstname . ' ' . \substr($this->lastname, 0, 1),
            'firstinitial_lastname' => \substr($this->firstname, 0, 1) . '' . $this->lastname,
            'lastnamefirstname' => $this->firstname . '' . $this->lastname,
            'lastname_comma_firstname' => $this->firstname . '.' . $this->lastname,
        ];

        return $user_format[$format];
    }


    # Things that are not deleted are reassociated with the anonymous user
    // def remove_references_before_destroy
    //     return if self.id.nil?

    //     substitute = User.anonymous
    //     Attachment.where(['author_id = ?', id]).update_all(['author_id = ?', substitute.id])
    //     Comment.where(['author_id = ?', id]).update_all(['author_id = ?', substitute.id])
    //     Issue.where(['author_id = ?', id]).update_all(['author_id = ?', substitute.id])
    //     Issue.where(['assigned_to_id = ?', id]).update_all('assigned_to_id = NULL')
    //     Journal.where(['user_id = ?', id]).update_all(['user_id = ?', substitute.id])
    //     JournalDetail.
    //     where(["property = 'attr' AND prop_key = 'assigned_to_id' AND old_value = ?", id.to_s]).
    //     update_all(['old_value = ?', substitute.id.to_s])
    //     JournalDetail.
    //     where(["property = 'attr' AND prop_key = 'assigned_to_id' AND value = ?", id.to_s]).
    //     update_all(['value = ?', substitute.id.to_s])
    //     Message.where(['author_id = ?', id]).update_all(['author_id = ?', substitute.id])
    //     News.where(['author_id = ?', id]).update_all(['author_id = ?', substitute.id])
    //     # Remove private queries and keep public ones
    //     ::Query.where('user_id = ? AND visibility = ?', id, ::Query::VISIBILITY_PRIVATE).delete_all
    //     ::Query.where(['user_id = ?', id]).update_all(['user_id = ?', substitute.id])
    //     TimeEntry.where(['user_id = ?', id]).update_all(['user_id = ?', substitute.id])
    //     Token.where('user_id = ?', id).delete_all
    //     Watcher.where('user_id = ?', id).delete_all
    //     WikiContent.where(['author_id = ?', id]).update_all(['author_id = ?', substitute.id])
    //     WikiContent::Version.where(['author_id = ?', id]).update_all(['author_id = ?', substitute.id])
    // end
}
