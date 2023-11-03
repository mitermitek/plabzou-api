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
 * Class Teacher
 *
 * @property int $user_id
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property User $user
 * @property Collection|Conversation[] $conversations
 * @property Collection|Request[] $requests
 * @property Collection|Timeslot[] $timeslots
 * @property Collection|Training[] $trainings
 *
 * @package App\Models
 */
class Teacher extends Model
{
    use SoftDeletes, HasFactory;

    public $incrementing = false;
    protected $table = 'teachers';
    protected $primaryKey = 'user_id';
    protected $casts = [
        'user_id' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'status'
    ];

    protected $appends = ['full_name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class, 'teacher_id', 'user_id')->withTrashed()->orderBy('created_at', 'desc');
    }

    public function timeslots(): BelongsToMany
    {
        return $this->belongsToMany(
            Timeslot::class,
            'teacher_timeslot',
            'teacher_id',
            'timeslot_id'
        )
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }

    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(
            Training::class,
            'teacher_training',
            'teacher_id',
            'training_id'
        )
            ->withPivot('id', 'latest_upgrade_date', 'is_active', 'reason', 'deleted_at')
            ->withTimestamps();
    }

    public function getFullNameAttribute(): string
    {
        return $this->user->full_name;
    }
}
