<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IssuesBeneficiarios extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'issues_beneficiarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'issue_id', 'type', 'faixa_etaria', 'meta', 'realizado', 'author_id', 'created_on', 'updated_on', 'deleted_on', 'reported_on', 'reported_by'];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_on', 'updated_on', 'reported_on', 'deleted_on'];


    public function issue()
    {
        return $this->belongsTo('App\Models\Issue', 'issue_id', 'id');
    }

    public function author()
    {
        return $this->hasOne('App\Models\User', 'id', 'author_id');
    }
}
