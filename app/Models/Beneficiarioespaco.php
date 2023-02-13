<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Beneficiarioespaco
 * 
 * @property int $id
 * @property int|null $idBeneficiario
 * @property int|null $idEspaco
 * @property Carbon|null $createdOn
 * @property Carbon|null $updatedOn
 * @property Carbon|null $removedOn
 * @property int|null $createdBy
 * @property int|null $updatedBy
 * @property int|null $removedBy
 * 
 * @property Beneficiario|null $beneficiario
 * @property Espacoparticipacao|null $espacoparticipacao
 *
 * @package App\Models
 */
class Beneficiarioespaco extends Model
{
	protected $table = 'beneficiarioespaco';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'idBeneficiario' => 'int',
		'idEspaco' => 'int',
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
		'idBeneficiario',
		'idEspaco',
		'createdOn',
		'updatedOn',
		'removedOn',
		'createdBy',
		'updatedBy',
		'removedBy'
	];

	public function beneficiario()
	{
		return $this->belongsTo(Beneficiario::class, 'idBeneficiario');
	}

	public function espacoparticipacao()
	{
		return $this->belongsTo(Espacoparticipacao::class, 'idEspaco');
	}
}
