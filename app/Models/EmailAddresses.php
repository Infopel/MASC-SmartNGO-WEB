<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailAddresses extends Model
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
    protected $table = 'email_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'address', 'is_default', 'notify', 'created_on', 'updated_on'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_on', 'updated_on'];

    /**
     * The users that belong to the Email Address.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id', 'user_id');
    }
}
