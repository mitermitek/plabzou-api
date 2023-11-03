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
 * Class TrainingCourse
 *
 * @property int $id
 * @property int $training_id
 * @property int $course_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Course $course
 * @property Training $training
 *
 * @package App\Models
 */
class TrainingCourse extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'training_course';

    protected $casts = [
        'training_id' => 'int',
        'course_id' => 'int'
    ];

    protected $fillable = [
        'training_id',
        'course_id'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }
}
