<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Beneficiario
 * 
 * @property int $id
 * @property string|null $codigo
 * @property string|null $nome
 * @property string|null $apelido
 * @property Carbon|null $dataNascimento
 * @property string|null $estadoCivil
 * @property string|null $genero
 * @property string|null $escolaridade
 * @property int|null $nrFilhos
 * @property string|null $bens
 * @property bool|null $viveComParentes
 * @property Carbon|null $createdOn
 * @property Carbon|null $updatedOn
 * @property Carbon|null $removedOn
 * @property int|null $createdBy
 * @property string|null $motivoDesistencia
 * @property bool|null $conhecimentoEspaco
 * @property bool|null $participacaoEspaco
 * @property bool|null $actividadePolitica
 * @property string|null $observacoes
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $foto
 * @property string|null $conhecimentoIncubadora
 * @property string|null $funcao
 * @property string|null $povoado
 * 
 * @property Collection|Beneficiarioespaco[] $beneficiarioespacos
 * @property Collection|Iniciativa[] $iniciativas
 * @property Collection|Participantesaccao[] $participantesaccaos
 * @property Collection|Poupancabeneficiario[] $poupancabeneficiarios
 *
 * @package App\Models
 */
class Beneficiario extends Model
{
	protected $table = 'beneficiario';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'nrFilhos' => 'int',
		'viveComParentes' => 'bool',
		'createdBy' => 'int',
		'conhecimentoEspaco' => 'bool',
		'participacaoEspaco' => 'bool',
		'actividadePolitica' => 'bool',
		'latitude' => 'float',
		'longitude' => 'float'
	];

	protected $dates = [
		'dataNascimento',
		'createdOn',
		'updatedOn',
		'removedOn'
	];

	protected $fillable = [
		'codigo',
		'nome',
		'apelido',
		'dataNascimento',
		'estadoCivil',
		'genero',
		'escolaridade',
		'nrFilhos',
		'bens',
		'viveComParentes',
		'createdOn',
		'updatedOn',
		'removedOn',
		'createdBy',
		'motivoDesistencia',
		'conhecimentoEspaco',
		'participacaoEspaco',
		'actividadePolitica',
		'observacoes',
		'latitude',
		'longitude',
		'foto',
		'conhecimentoIncubadora',
		'funcao',
		'povoado'
	];

	public function beneficiarioespacos()
	{
		return $this->hasMany(Beneficiarioespaco::class, 'idBeneficiario');
	}

	public function iniciativas()
	{
		return $this->belongsToMany(Iniciativa::class, 'beneficiarioiniciativa', 'idBeneficiario', 'idIniciativa')
					->withPivot('id', 'createdOn', 'updatedOn', 'removedOn', 'createdBy', 'updatedBy', 'removedBy');
	}

	public function participantesaccaos()
	{
		return $this->hasMany(Participantesaccao::class, 'idBeneficiario');
	}

	public function poupancabeneficiarios()
	{
		return $this->hasMany(Poupancabeneficiario::class, 'idBeneficiario');
	}
}
