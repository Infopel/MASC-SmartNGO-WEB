<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budgets extends Model
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
    protected $table = 'budgets';

    protected $fillable = ['id', 'budget_tracker_id', 'customized_type', 'customized_id', 'value', 'value_at_currency', 'is_plan', 'is_pedding', 'validated_on', 'validated_by', 'author_id', 'is_iva', 'iva', 'created_on', 'updated_on', 'deleted_at'];

    protected $casts = [
        'created_on',
        'updated_on',
    ];

    protected $dates = ['created_on', 'updated_on'];

    /**
     * Trackers do Orcamento
     */
    public function budget_tracker()
    {
        return $this->belongsTo('App\Models\BudgetTrackers', 'budget_tracker_id', 'id');
    }

    public function budget_details()
    {
        return $this->hasMany('App\Models\BudgetsDetails', 'budget_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }

    public function aprovado_por()
    {
        return $this->hasOne('App\Models\User', 'id', 'validated_by');
    }
}
