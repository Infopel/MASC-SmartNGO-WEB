<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetCustomFields extends Model
{
    use SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'budget_custom_fields';

    protected $fillable = ['id', 'custom_field_id', 'created_on', 'updated_on', 'deleted_at'];

    protected $casts = ['created_on', 'updated_on'];
}
