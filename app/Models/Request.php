<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Request
 *
 * @property int $id
 * @property int $administrative_employee_id
 * @property int $teacher_id
 * @property int $timeslot_id
 * @property bool $is_approved
 * @property string|null $comment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property AdministrativeEmployee $administrative_employee
 * @property Teacher $teacher
 * @property Timeslot $timeslot
 *
 * @package App\Models
 */
class Request extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'requests';

    protected $casts = [
        'administrative_employee_id' => 'int',
        'teacher_id' => 'int',
        'timeslot_id' => 'int',
        'is_approved_by_admin' => 'bool',
        'is_approved_by_teacher' => 'bool'
    ];

    protected $fillable = [
        'administrative_employee_id',
        'teacher_id',
        'timeslot_id',
        'is_approved_by_admin',
        'is_approved_by_teacher',
        'comment'
    ];

    public function administrativeEmployee(): BelongsTo
    {
        return $this->belongsTo(AdministrativeEmployee::class, 'administrative_employee_id', 'user_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'user_id');
    }

    public function timeslot(): BelongsTo
    {
        return $this->belongsTo(Timeslot::class);
    }
}
