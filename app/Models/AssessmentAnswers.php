<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentAnswers extends Model
{
    // use SoftDeletes;

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
    protected $table = 'assessment_answers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'assessment_id', 'partner_id', 'question_id',  'category_id', 'value', 'status', 'created_on', 'updated_on', 'deleted_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_on'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_on' => 'created_on',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\QuestionnaireCategories', 'category_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo('App\Models\Questions', 'question_id', 'id');
    }
}
