<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Accao
 * 
 * @property int $id
 * @property int|null $tipoAccao
 * @property string|null $assunto
 * @property Carbon|null $dataFormacao
 * @property string|null $coordenador
 * @property string|null $descricao
 * @property int|null $createdBy
 * @property Carbon|null $createdOn
 * @property Carbon|null $updatedOn
 * @property Carbon|null $removedOn
 * @property int $updatedBy
 * @property int|null $removedBy
 * @property int|null $nrParticipantesHomesn
 * @property string|null $resultados
 * @property string|null $observacoes
 * @property int|null $nrParticipantesMulheres
 * 
 * @property Tipoaccao|null $tipoaccao
 * @property Collection|Participantesaccao[] $participantesaccaos
 *
 * @package App\Models
 */
class Accao extends Model
{
	protected $table = 'accao';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'tipoAccao' => 'int',
		'createdBy' => 'int',
		'updatedBy' => 'int',
		'removedBy' => 'int',
		'nrParticipantesHomesn' => 'int',
		'nrParticipantesMulheres' => 'int'
	];

	protected $dates = [
		'dataFormacao',
		'createdOn',
		'updatedOn',
		'removedOn'
	];

	protected $fillable = [
		'tipoAccao',
		'assunto',
		'dataFormacao',
		'coordenador',
		'descricao',
		'createdBy',
		'createdOn',
		'updatedOn',
		'removedOn',
		'updatedBy',
		'removedBy',
		'nrParticipantesHomesn',
		'resultados',
		'observacoes',
		'nrParticipantesMulheres'
	];

	public function tipoaccao()
	{
		return $this->belongsTo(Tipoaccao::class, 'tipoAccao');
	}

	public function participantesaccaos()
	{
		return $this->hasMany(Participantesaccao::class, 'idAccao');
	}
}
