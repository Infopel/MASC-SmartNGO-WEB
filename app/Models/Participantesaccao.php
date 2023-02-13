<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Participantesaccao
 * 
 * @property int $id
 * @property int|null $idAccao
 * @property int|null $idBeneficiario
 * @property Carbon|null $createdOn
 * @property Carbon|null $updatedOn
 * @property Carbon|null $removedOn
 * @property int|null $createdBy
 * @property int|null $updatedBy
 * @property int|null $removedBy
 * 
 * @property Accao|null $accao
 * @property Beneficiario|null $beneficiario
 *
 * @package App\Models
 */
class Participantesaccao extends Model
{
	protected $table = 'participantesaccao';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'idAccao' => 'int',
		'idBeneficiario' => 'int',
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
		'idAccao',
		'idBeneficiario',
		'createdOn',
		'updatedOn',
		'removedOn',
		'createdBy',
		'updatedBy',
		'removedBy'
	];

	public function accao()
	{
		return $this->belongsTo(Accao::class, 'idAccao');
	}

	public function beneficiario()
	{
		return $this->belongsTo(Beneficiario::class, 'idBeneficiario');
	}
}
