<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journals extends Model
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
    protected $table = 'journals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'journalized_id', 'journalized_type', 'user_id', 'notes', 'created_on', 'private_notes'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_on'];

    public function journal_details()
    {
        return $this->hasMany('App\Models\JournalDetails', 'journal_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id', 'user_id');
    }
}
