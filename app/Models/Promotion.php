<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Promotion
 *
 * @property int $id
 * @property int $course_id
 * @property int|null $city_id
 * @property string $name
 * @property Carbon $starts_at
 * @property Carbon $ends_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property City|null $city
 * @property Course $course
 * @property Collection|Learner[] $learners
 * @property Collection|Timeslot[] $timeslots
 *
 * @package App\Models
 */
class Promotion extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'promotions';

    protected $casts = [
        'course_id' => 'int',
        'city_id' => 'int',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime'
    ];

    protected $fillable = [
        'course_id',
        'city_id',
        'name',
        'starts_at',
        'ends_at'
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function learners(): BelongsToMany
    {
        return $this->belongsToMany(
            Learner::class,
            'learner_promotion',
            'promotion_id',
            'learner_id'
        )
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }

    public function timeslots(): BelongsToMany
    {
        return $this->belongsToMany(
            Timeslot::class,
            'promotion_timeslot',
            'promotion_id',
            'timeslot_id'
        )
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }
}
