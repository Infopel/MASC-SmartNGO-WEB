<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partners extends Model
{
    use SoftDeletes;

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
    protected $table = 'partners';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'type', 'natureza' ,'address', 'email_address', 'identity_url', 'type_fund' ,'start_date', 'end_date','created_on', 'updated_on', 'deleted_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_on', 'updated_on'];



    public function tipo()
    {
        return $this->belongsTo('App\Models\Enumerations', 'type', 'id')->where('type', 'PartnersCategory');
    }

    public function attachments()
    {
        return $this->hasMany(Attachments::class, 'container_id', 'id')->where('container_type', 'Partner');
    }
}
