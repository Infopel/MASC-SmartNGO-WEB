<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Localizacao
 * 
 * @property int $id
 * @property string|null $designacao
 * @property int|null $idPai
 * 
 * @property Localizacao|null $localizacao
 * @property Collection|Iniciativa[] $iniciativas
 * @property Collection|Localizacao[] $localizacaos
 *
 * @package App\Models
 */
class Localizacao extends Model
{
	protected $table = 'localizacao';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'idPai' => 'int'
	];

	protected $fillable = [
		'designacao',
		'idPai'
	];

	public function localizacao()
	{
		return $this->belongsTo(Localizacao::class, 'idPai');
	}

	public function iniciativas()
	{
		return $this->hasMany(Iniciativa::class, 'idLocalizacao');
	}

	public function localizacaos()
	{
		return $this->hasMany(Localizacao::class, 'idPai');
	}
}
