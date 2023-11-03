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
 * Class TeacherTraining
 *
 * @property int $id
 * @property int $teacher_id
 * @property int $training_id
 * @property Carbon|null $latest_upgrade_date
 * @property bool $is_active
 * @property string|null $reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Teacher $teacher
 * @property Training $training
 *
 * @package App\Models
 */
class TeacherTraining extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'teacher_training';

    protected $casts = [
        'teacher_id' => 'int',
        'training_id' => 'int',
        'latest_upgrade_date' => 'datetime',
        'is_active' => 'bool'
    ];

    protected $fillable = [
        'teacher_id',
        'training_id',
        'latest_upgrade_date',
        'is_active',
        'reason'
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }
}
