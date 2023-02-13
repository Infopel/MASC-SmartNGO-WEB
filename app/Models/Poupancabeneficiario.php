<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Poupancabeneficiario
 * 
 * @property int $id
 * @property int|null $idCiclo
 * @property int|null $idGrupoPoupanca
 * @property int|null $idBeneficiario
 * @property float|null $valorPoupanca
 * @property float|null $valorEmprestimo
 * @property float|null $taxaJuro
 * @property float|null $valorMulta
 * @property float|null $taxaJuroMulta
 * @property float|null $juro
 * @property float|null $valorFundoSocal
 * @property string|null $actividade
 * @property Carbon|null $createdOn
 * @property Carbon|null $updatedOn
 * @property Carbon|null $removedOn
 * @property int|null $createdBy
 * @property int|null $updatedBy
 * @property int|null $removedBy
 * 
 * @property Ciclo|null $ciclo
 * @property Grupopoupanca|null $grupopoupanca
 * @property Beneficiario|null $beneficiario
 * @property User|null $user
 * @property Collection|Monitoriapoupanca[] $monitoriapoupancas
 *
 * @package App\Models
 */
class Poupancabeneficiario extends Model
{
	protected $table = 'poupancabeneficiario';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'idCiclo' => 'int',
		'idGrupoPoupanca' => 'int',
		'idBeneficiario' => 'int',
		'valorPoupanca' => 'float',
		'valorEmprestimo' => 'float',
		'taxaJuro' => 'float',
		'valorMulta' => 'float',
		'taxaJuroMulta' => 'float',
		'juro' => 'float',
		'valorFundoSocal' => 'float',
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
		'idCiclo',
		'idGrupoPoupanca',
		'idBeneficiario',
		'valorPoupanca',
		'valorEmprestimo',
		'taxaJuro',
		'valorMulta',
		'taxaJuroMulta',
		'juro',
		'valorFundoSocal',
		'actividade',
		'createdOn',
		'updatedOn',
		'removedOn',
		'createdBy',
		'updatedBy',
		'removedBy'
	];

	public function ciclo()
	{
		return $this->belongsTo(Ciclo::class, 'idCiclo');
	}

	public function grupopoupanca()
	{
		return $this->belongsTo(Grupopoupanca::class, 'idGrupoPoupanca');
	}

	public function beneficiario()
	{
		return $this->belongsTo(Beneficiario::class, 'idBeneficiario');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'createdBy');
	}

	public function monitoriapoupancas()
	{
		return $this->hasMany(Monitoriapoupanca::class, 'idPoupancaBen');
	}
}
