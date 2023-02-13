<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Espacoparticipacao
 * 
 * @property int $id
 * @property string|null $designacao
 * 
 * @property Collection|Beneficiarioespaco[] $beneficiarioespacos
 *
 * @package App\Models
 */
class Espacoparticipacao extends Model
{
	protected $table = 'espacoparticipacao';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'designacao'
	];

	public function beneficiarioespacos()
	{
		return $this->hasMany(Beneficiarioespaco::class, 'idEspaco');
	}
}
