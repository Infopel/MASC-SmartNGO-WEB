<?php

namespace App\Models;

use Symfony\Component\Yaml\Yaml;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Questions extends Model
{
    use SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'questions';

    protected $fillable = ['id', 'category_id', 'title', 'format', 'options_values', 'multiple', 'is_outro_available', 'required', 'created_on', 'updated_on', 'deleted_at'];

    protected $casts = ['created_on', 'updated_on'];

    public function category()
    {
        return $this->belongsTo('App\QuestionnaireCategories', 'category_id', 'id');
    }

    protected $appends = [
        'options',
    ];

    public function getOptionsAttribute()
    {
        // return $this->options_values;
        return Yaml::parse($this->options_values ?? "");
    }
}
