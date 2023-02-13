<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppApprovementFlows extends Model
{
    use SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Databse Table
     */
    protected $table = 'app_approvement_flows';

    /**
     * Database Columns
     */
    protected $fillable = ['id', 'tagCode', 'title', 'isActive', 'isAssociated_with', 'created_on', 'updated_on', 'deleted_at'];

    /**
     * Casts
     */
    protected $casts = ['created_on', 'updated_on'];
}
