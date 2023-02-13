<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Iniciativa
 * 
 * @property int $id
 * @property string|null $codigo
 * @property int|null $idLocalizacao
 * @property string|null $bairro
 * @property string|null $nome
 * @property Carbon|null $dataConstituicao
 * @property int|null $idResponsavel
 * @property int|null $idMobilizador
 * @property Carbon|null $createdOn
 * @property Carbon|null $updatedOn
 * @property Carbon|null $removedOn
 * @property int|null $createdBy
 * @property string|null $tipoIniciativa
 * @property int|null $updatedBy
 * @property int|null $removedBy
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string $project_id
 * 
 * @property Localizacao|null $localizacao
 * @property User|null $user
 * @property Collection|Beneficiario[] $beneficiarios
 * @property Collection|Grupopoupanca[] $grupopoupancas
 * @property Collection|Incubadoracivica[] $incubadoracivicas
 * @property Collection|Vdo[] $vdos
 *
 * @package App\Models
 */
class Iniciativa extends Model
{
	protected $table = 'iniciativa';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'idLocalizacao' => 'int',
		'idResponsavel' => 'int',
		'idMobilizador' => 'int',
		'createdBy' => 'int',
		'updatedBy' => 'int',
		'removedBy' => 'int',
		'latitude' => 'float',
		'longitude' => 'float'
	];

	protected $dates = [
		'dataConstituicao',
		'createdOn',
		'updatedOn',
		'removedOn'
	];

	protected $fillable = [
		'codigo',
		'idLocalizacao',
		'bairro',
		'nome',
		'dataConstituicao',
		'idResponsavel',
		'idMobilizador',
		'createdOn',
		'updatedOn',
		'removedOn',
		'createdBy',
		'tipoIniciativa',
		'updatedBy',
		'removedBy',
		'latitude',
		'longitude',
		'project_id'
	];

	public function localizacao()
	{
		return $this->belongsTo(Localizacao::class, 'idLocalizacao');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'createdBy');
	}

	public function beneficiarios()
	{
		return $this->belongsToMany(Beneficiario::class, 'beneficiarioiniciativa', 'idIniciativa', 'idBeneficiario')
					->withPivot('id', 'createdOn', 'updatedOn', 'removedOn', 'createdBy', 'updatedBy', 'removedBy');
	}

	public function grupopoupancas()
	{
		return $this->hasMany(Grupopoupanca::class, 'idIniciativa');
	}

	public function incubadoracivicas()
	{
		return $this->hasMany(Incubadoracivica::class, 'idIniciativa');
	}

	public function vdos()
	{
		return $this->hasMany(Vdo::class, 'idIniciativa');
	}
}
