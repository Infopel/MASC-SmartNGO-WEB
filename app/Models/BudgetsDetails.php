<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetsDetails extends Model
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
    protected $table = 'budgets_details';


    protected $fillable = ['id', 'note', 'attachments', 'budget_id', 'created_on', 'deleted_at'];

    protected $dates = ['created_on'];

    protected $casts = ['created_on'];
}
