<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TeacherTimeslot
 *
 * @property int $id
 * @property int $teacher_id
 * @property int $timeslot_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Teacher $teacher
 * @property Timeslot $timeslot
 *
 * @package App\Models
 */
class TeacherTimeslot extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'teacher_timeslot';

    protected $casts = [
        'teacher_id' => 'int',
        'timeslot_id' => 'int'
    ];

    protected $fillable = [
        'teacher_id',
        'timeslot_id'
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function timeslot(): BelongsTo
    {
        return $this->belongsTo(Timeslot::class);
    }
}
