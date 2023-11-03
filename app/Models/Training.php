<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Training
 *
 * @property int $id
 * @property string $name
 * @property int $duration
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Collection|Teacher[] $teachers
 * @property Collection|Timeslot[] $timeslots
 * @property Collection|Category[] $categories
 * @property Collection|Course[] $courses
 *
 * @package App\Models
 */
class Training extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'trainings';

    protected $casts = [
        'duration' => 'int'
    ];

    protected $fillable = [
        'name',
        'duration'
    ];

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(
            Teacher::class,
            'teacher_training',
            'training_id',
            'teacher_id'
        )
            ->withPivot('id', 'latest_upgrade_date', 'is_active', 'reason', 'deleted_at')
            ->withTimestamps();
    }

    public function timeslots(): HasMany
    {
        return $this->hasMany(Timeslot::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'training_category')
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'training_course')
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }
}
