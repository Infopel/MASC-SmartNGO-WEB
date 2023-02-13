<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tipoaccao
 * 
 * @property int $id
 * @property string|null $designacao
 * @property Carbon|null $createdOn
 * @property Carbon|null $updatedOn
 * @property Carbon|null $removedOn
 * @property int|null $createdBy
 * @property int|null $updatedBy
 * @property int|null $removedBy
 * 
 * @property Collection|Accao[] $accaos
 *
 * @package App\Models
 */
class Tipoaccao extends Model
{
	protected $table = 'tipoaccao';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'createdBy' => 'int',
		'updatedBy' => 'int',
		'removedBy' => 'int'
	];

	protected $dates = [
		'createdOn',
		'updatedOn',
		'removedOn'
	];

	protected $fillable = [
		'designacao',
		'createdOn',
		'updatedOn',
		'removedOn',
		'createdBy',
		'updatedBy',
		'removedBy'
	];

	public function accaos()
	{
		return $this->hasMany(Accao::class, 'tipoAccao');
	}
}
