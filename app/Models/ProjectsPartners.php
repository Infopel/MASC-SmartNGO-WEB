<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectsPartners extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'projects_partners';

    protected $fillable = ['id', 'project_id', 'partner_id', 'type'];


    public function project()
    {
        return $this->belongsTo('App\Models\Projects', 'project_id', 'id');
    }

    public function partner()
    {
        return $this->belongsTo('App\Models\Partners', 'partner_id', 'id');
    }
}
