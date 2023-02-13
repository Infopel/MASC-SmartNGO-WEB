<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ApprovementFlowConfig extends Model
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
    protected $table = 'approvement_flow_config';

    /**
     * Database Columns
     */
    protected $fillable = ['id', 'approvement_flow_id', 'config_type', 'author_id', 'built_in', 'value', 'created_on', 'updated_on', 'updated_by', 'deleted_at', 'deleted_by'];
}
