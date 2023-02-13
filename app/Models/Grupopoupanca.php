<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Grupopoupanca
 * 
 * @property int $id
 * @property int|null $nrCiclos
 * @property int|null $nrMembros
 * @property int|null $nrMembrosActivos
 * @property float|null $fundoSocial
 * @property float|null $valorMulta
 * @property float|null $taxaJuro
 * @property string $codigo
 * @property int|null $idIniciativa
 * @property int|null $createdBy
 * @property int|null $updatedBy
 * @property int|null $removedBy
 * @property Carbon|null $dataConstituicao
 * @property int|null $idLocalizacao
 * 
 * @property Iniciativa|null $iniciativa
 * @property Collection|Ciclo[] $ciclos
 * @property Collection|Monitoriagrupo[] $monitoriagrupos
 * @property Collection|Poupancabeneficiario[] $poupancabeneficiarios
 *
 * @package App\Models
 */
class Grupopoupanca extends Model
{
	protected $table = 'grupopoupanca';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'nrCiclos' => 'int',
		'nrMembros' => 'int',
		'nrMembrosActivos' => 'int',
		'fundoSocial' => 'float',
		'valorMulta' => 'float',
		'taxaJuro' => 'float',
		'idIniciativa' => 'int',
		'createdBy' => 'int',
		'updatedBy' => 'int',
		'removedBy' => 'int',
		'idLocalizacao' => 'int'
	];

	protected $dates = [
		'dataConstituicao'
	];

	protected $fillable = [
		'nrCiclos',
		'nrMembros',
		'nrMembrosActivos',
		'fundoSocial',
		'valorMulta',
		'taxaJuro',
		'codigo',
		'idIniciativa',
		'createdBy',
		'updatedBy',
		'removedBy',
		'dataConstituicao',
		'idLocalizacao'
	];

	public function iniciativa()
	{
		return $this->belongsTo(Iniciativa::class, 'idIniciativa');
	}

	public function ciclos()
	{
		return $this->hasMany(Ciclo::class, 'idGrupoPoupanca');
	}

	public function monitoriagrupos()
	{
		return $this->hasMany(Monitoriagrupo::class, 'idGrupoPoupanca');
	}

	public function poupancabeneficiarios()
	{
		return $this->hasMany(Poupancabeneficiario::class, 'idGrupoPoupanca');
	}
}
