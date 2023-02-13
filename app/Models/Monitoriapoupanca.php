<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Monitoriapoupanca
 * 
 * @property int $id
 * @property int|null $idPoupancaBen
 * @property float|null $valorPoupado
 * @property float|null $valorEmprestimo
 * @property float|null $valorJuro
 * @property bool|null $contribuiuFundoSocial
 * @property Carbon|null $dataMonitoria
 * @property float|null $valorMulta
 * @property string|null $actividadeRendimento
 * @property string|null $aplicacaoDinheiro
 * @property string|null $beneficioCredito
 * @property Carbon|null $createdOn
 * @property Carbon|null $updatedOn
 * @property Carbon|null $removedOn
 * @property int|null $createdBy
 * @property int|null $updatedBy
 * @property int|null $removedBy
 * 
 * @property Poupancabeneficiario|null $poupancabeneficiario
 * @property User|null $user
 *
 * @package App\Models
 */
class Monitoriapoupanca extends Model
{
	protected $table = 'monitoriapoupanca';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'idPoupancaBen' => 'int',
		'valorPoupado' => 'float',
		'valorEmprestimo' => 'float',
		'valorJuro' => 'float',
		'contribuiuFundoSocial' => 'bool',
		'valorMulta' => 'float',
		'createdBy' => 'int',
		'updatedBy' => 'int',
		'removedBy' => 'int'
	];

	protected $dates = [
		'dataMonitoria',
		'createdOn',
		'updatedOn',
		'removedOn'
	];

	protected $fillable = [
		'idPoupancaBen',
		'valorPoupado',
		'valorEmprestimo',
		'valorJuro',
		'contribuiuFundoSocial',
		'dataMonitoria',
		'valorMulta',
		'actividadeRendimento',
		'aplicacaoDinheiro',
		'beneficioCredito',
		'createdOn',
		'updatedOn',
		'removedOn',
		'createdBy',
		'updatedBy',
		'removedBy'
	];

	public function poupancabeneficiario()
	{
		return $this->belongsTo(Poupancabeneficiario::class, 'idPoupancaBen');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'createdBy');
	}
}
