<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TimeSheet
 * 
 * @property int $id
 * @property string|null $descrition
 * @property string|null $user_id
 * @property string $tag_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property Carbon|null $data_inicio
 * @property Carbon|null $data_fim
 * @property int|null $approved
 *
 * @package App\Models
 */
class TimeSheet extends Model
{
	use SoftDeletes;
	protected $table = 'time_sheet';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'approved' => 'int'
	];

	protected $dates = [
		'data_inicio',
		'data_fim'
	];

	protected $fillable = [
		'descrition',
		'user_id',
		'tag_code',
		'data_inicio',
		'data_fim',
		'approved'
	];

	/**
     * All activities that belongs to this Timesheet
     */
    public function activities()
    {
        return $this->hasMany('App\Models\TsActivity', 'tag_code_ts', 'tag_code');
    }




	public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

}
