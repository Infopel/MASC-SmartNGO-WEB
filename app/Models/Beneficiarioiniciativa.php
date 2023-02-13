<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Beneficiarioiniciativa
 * 
 * @property int $id
 * @property int|null $idBeneficiario
 * @property int|null $idIniciativa
 * @property Carbon|null $createdOn
 * @property Carbon|null $updatedOn
 * @property Carbon|null $removedOn
 * @property int|null $createdBy
 * @property int|null $updatedBy
 * @property int|null $removedBy
 * 
 * @property Beneficiario|null $beneficiario
 * @property Iniciativa|null $iniciativa
 * @property User|null $user
 *
 * @package App\Models
 */
class Beneficiarioiniciativa extends Model
{
	protected $table = 'beneficiarioiniciativa';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'idBeneficiario' => 'int',
		'idIniciativa' => 'int',
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
		'idIniciativa',
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

	public function iniciativa()
	{
		return $this->belongsTo(Iniciativa::class, 'idIniciativa');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'createdBy');
	}
}
