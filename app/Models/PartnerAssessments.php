<?php

namespace App\Models;

use App\Models\Assessment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerAssessments extends Model
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
    protected $table = 'partner_assessments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'partner_id', 'assessment_id', 'is_submited', 'author_id', 'submited_on', 'created_on', 'updated_on', 'deleted_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_on', 'updated_on'];

    /**
     * Belongs to User
     *
     * @return User $user
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }

    /**
     * Has many Assessment
     *
     * @return Collection
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'assessment_id', 'id');
    }

    /**
     * This Resource belongsTo Partner
     *
     * @return \App\Models\Partners::class $partner
     */
    public function partner()
    {
        return $this->belongsTo('App\Models\Partners', 'partner_id', 'id');
    }

    /**
     * This Has many Question n Categorias
     */
    public function assessment_survey()
    {
        return $this->hasMany(AssessmentAnswers::class, 'assessment_id', 'id');
        // ->with('category', 'question');
    }
}
