<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ciclo
 * 
 * @property int $id
 * @property string|null $cod
 * @property Carbon|null $dataInicio
 * @property Carbon|null $dataFim
 * @property Carbon|null $createdOn
 * @property Carbon|null $updatedOn
 * @property Carbon|null $removedOn
 * @property int|null $idGrupoPoupanca
 * @property int|null $createdBy
 * @property int|null $updatedBy
 * @property int|null $removedBy
 * 
 * @property User|null $user
 * @property Grupopoupanca|null $grupopoupanca
 * @property Collection|Monitoriagrupo[] $monitoriagrupos
 * @property Collection|Poupancabeneficiario[] $poupancabeneficiarios
 *
 * @package App\Models
 */
class Ciclo extends Model
{
	protected $table = 'ciclo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'idGrupoPoupanca' => 'int',
		'createdBy' => 'int',
		'updatedBy' => 'int',
		'removedBy' => 'int'
	];

	protected $dates = [
		'dataInicio',
		'dataFim',
		'createdOn',
		'updatedOn',
		'removedOn'
	];

	protected $fillable = [
		'cod',
		'dataInicio',
		'dataFim',
		'createdOn',
		'updatedOn',
		'removedOn',
		'idGrupoPoupanca',
		'createdBy',
		'updatedBy',
		'removedBy'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'createdBy');
	}

	public function grupopoupanca()
	{
		return $this->belongsTo(Grupopoupanca::class, 'idGrupoPoupanca');
	}

	public function monitoriagrupos()
	{
		return $this->hasMany(Monitoriagrupo::class, 'idCiclo');
	}

	public function poupancabeneficiarios()
	{
		return $this->hasMany(Poupancabeneficiario::class, 'idCiclo');
	}
}
