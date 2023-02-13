<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndicatorRelation extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'indicator_relation';

    protected $fillable = ['parent', 'pri_parent', 'child', 'relationed_by', 'created_on', 'deleted_at'];
}
