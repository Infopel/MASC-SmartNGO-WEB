<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Monitoriagrupo
 * 
 * @property int $id
 * @property int|null $idGrupoPoupanca
 * @property int|null $idCiclo
 * @property float|null $jurosObtidosPoupanca
 * @property float|null $jurosObtidosFundoSocial
 * @property bool|null $evoluiuCooperativa
 * @property Carbon|null $tipoCooperativa
 * @property string|null $problemasGrupo
 * @property Carbon|null $createdOn
 * @property Carbon|null $updatedOn
 * @property Carbon|null $removedOn
 * @property int|null $createdBy
 * @property Carbon|null $dataMonitoria
 * @property int|null $updatedBy
 * @property int|null $removedBy
 * 
 * @property Grupopoupanca|null $grupopoupanca
 * @property Ciclo|null $ciclo
 * @property User|null $user
 *
 * @package App\Models
 */
class Monitoriagrupo extends Model
{
	protected $table = 'monitoriagrupo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'idGrupoPoupanca' => 'int',
		'idCiclo' => 'int',
		'jurosObtidosPoupanca' => 'float',
		'jurosObtidosFundoSocial' => 'float',
		'evoluiuCooperativa' => 'bool',
		'createdBy' => 'int',
		'updatedBy' => 'int',
		'removedBy' => 'int'
	];

	protected $dates = [
		'tipoCooperativa',
		'createdOn',
		'updatedOn',
		'removedOn',
		'dataMonitoria'
	];

	protected $fillable = [
		'idGrupoPoupanca',
		'idCiclo',
		'jurosObtidosPoupanca',
		'jurosObtidosFundoSocial',
		'evoluiuCooperativa',
		'tipoCooperativa',
		'problemasGrupo',
		'createdOn',
		'updatedOn',
		'removedOn',
		'createdBy',
		'dataMonitoria',
		'updatedBy',
		'removedBy'
	];

	public function grupopoupanca()
	{
		return $this->belongsTo(Grupopoupanca::class, 'idGrupoPoupanca');
	}

	public function ciclo()
	{
		return $this->belongsTo(Ciclo::class, 'idCiclo');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'createdBy');
	}
}
