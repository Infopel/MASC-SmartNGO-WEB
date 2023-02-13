<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TsSubmission
 * 
 * @property int $id
 * @property int $flow_id
 * @property int|null $role_id
 * @property int $ts_activity_id
 * @property string $tag_code
 * @property int $request_by
 * @property int|null $assigned_to
 * @property bool $is_approved
 * @property Carbon|null $approved_on
 * @property int|null $approved_by
 * @property bool|null $is_rejected
 * @property Carbon|null $rejected_on
 * @property int|null $rejected_by
 * @property Carbon $created_on
 * @property Carbon $updated_on
 * @property string|null $deleted_at
 * @property string|null $comments
 *
 * @package App\Models
 */
class TsSubmission extends Model
{
	use SoftDeletes;
	protected $table = 'ts_submissions';
	public $timestamps = false;

	protected $casts = [
		'flow_id' => 'int',
		'role_id' => 'int',
		'ts_activity_id' => 'int',
		'request_by' => 'int',
		'assigned_to' => 'int',
		'is_approved' => 'bool',
		'approved_by' => 'int',
		'is_rejected' => 'bool',
		'rejected_by' => 'int'
	];

	protected $dates = [
		'approved_on',
		'rejected_on',
		'created_on',
		'updated_on'
	];

	protected $fillable = [
		'flow_id',
		'role_id',
		'issue_id',
		'ts_activity_id',
		'tag_code',
		'request_by',
		'assigned_to',
		'is_approved',
		'approved_on',
		'approved_by',
		'is_rejected',
		'rejected_on',
		'rejected_by',
		'created_on',
		'updated_on',
		'comments',
		'next_flow'
	];
}
