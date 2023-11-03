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
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Timeslot
 *
 * @property int $id
 * @property int $training_id
 * @property int $room_id
 * @property Carbon $starts_at
 * @property Carbon $ends_at
 * @property bool $is_validated
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Room $room
 * @property Training $training
 * @property Collection|Learner[] $learners
 * @property Collection|Request[] $requests
 * @property Collection|Teacher[] $teachers
 * @property Collection|Promotion[] $promotions
 *
 * @package App\Models
 */
class Timeslot extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'timeslots';

    protected $casts = [
        'training_id' => 'int',
        'room_id' => 'int',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_validated' => 'bool'
    ];

    protected $fillable = [
        'training_id',
        'room_id',
        'starts_at',
        'ends_at',
        'is_validated'
    ];

    protected $appends = [
        'name'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class)->withDefault();
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    public function learners(): BelongsToMany
    {
        return $this->belongsToMany(
            Learner::class,
            'learner_timeslot',
            'timeslot_id',
            'learner_id'
        )
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(
            Teacher::class,
            'teacher_timeslot',
            'timeslot_id',
            'teacher_id'
        )
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(
            Promotion::class,
            'promotion_timeslot',
            'timeslot_id',
            'promotion_id'
        )
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }

    public function getNameAttribute(): string
    {
        return strtoupper($this->training->name) . ' du '
                . Carbon::create($this->starts_at)->format('d/m/y') . ' de '
                . Carbon::create($this->starts_at)->format('H:i') . ' à '
                . Carbon::create($this->ends_at)->format('H:i');
    }
}
