<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueRelations extends Model
{
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'issue_relations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'issue_from_id', 'issue_to_id', 'relation_type', 'delay'];


    public function issueTo()
    {
        return $this->belongsTo('App\Models\Issues', 'issue_to_id', 'id');
    }


    public function issueFrom()
    {
        return $this->belongsTo('App\Models\Issues', 'issue_from_id', 'id');
    }
}
