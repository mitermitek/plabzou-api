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
 * Class Learner
 *
 * @property int $user_id
 * @property int $mode_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Mode $mode
 * @property User $user
 * @property Collection|Promotion[] $promotions
 * @property Collection|Timeslot[] $timeslots
 *
 * @package App\Models
 */
class Learner extends Model
{
    use SoftDeletes, HasFactory;

    public $incrementing = false;
    protected $table = 'learners';
    protected $primaryKey = 'user_id';
    protected $casts = [
        'user_id' => 'int',
        'mode_id' => 'int'
    ];

    protected $fillable = [
        'mode_id',
        'user_id'
    ];

    protected $appends = ['full_name'];

    public function mode(): BelongsTo
    {
        return $this->belongsTo(Mode::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(
            Promotion::class,
            'learner_promotion',
            'learner_id',
            'promotion_id'
        )
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }

    public function timeslots(): BelongsToMany
    {
        return $this->belongsToMany(
            Timeslot::class,
            'learner_timeslot',
            'learner_id',
            'timeslot_id'
        )
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }

    public function getFullNameAttribute(): string
    {
        return $this->user->full_name;
    }
}
