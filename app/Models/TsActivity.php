<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TsActivity
 * 
 * @property int $id
 * @property string $descrition
 * @property Carbon|null $data
 * @property float|null $nr_horas
 * @property string|null $resultado
 * @property string|null $execucao
 * @property string|null $constragimentos
 * @property string $tag_code_ts
 * @property int $project_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class TsActivity extends Model
{
	use SoftDeletes;
	protected $table = 'ts_activities';
	public $incrementing = true;

	protected $casts = [
		'id' => 'int',
		'nr_horas' => 'float',
		'project_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $dates = [
		'data'
	];

	protected $fillable = [
		'descrition',
		'data',
		'nr_horas',
		'resultado',
		'execucao',
		'constragimentos',
		'tag_code_ts',
		'project_id',
		'created_by',
		'updated_by',
		'deleted_by'
	];
}
