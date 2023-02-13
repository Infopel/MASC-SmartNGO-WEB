<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vdo
 * 
 * @property int $id
 * @property string|null $nome
 * @property int|null $idResponsavel
 * @property int|null $idMobilizador
 * @property int|null $idIniciativa
 * @property int|null $createdBy
 * @property int|null $updatedBy
 * @property int|null $removedBy
 * 
 * @property Iniciativa|null $iniciativa
 * @property User|null $user
 *
 * @package App\Models
 */
class Vdo extends Model
{
	protected $table = 'vdo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'idResponsavel' => 'int',
		'idMobilizador' => 'int',
		'idIniciativa' => 'int',
		'createdBy' => 'int',
		'updatedBy' => 'int',
		'removedBy' => 'int'
	];

	protected $fillable = [
		'nome',
		'idResponsavel',
		'idMobilizador',
		'idIniciativa',
		'createdBy',
		'updatedBy',
		'removedBy'
	];

	public function iniciativa()
	{
		return $this->belongsTo(Iniciativa::class, 'idIniciativa');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'idMobilizador');
	}
}
