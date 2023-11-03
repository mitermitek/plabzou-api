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
 * Class LearnerTimeslot
 *
 * @property int $id
 * @property int $learner_id
 * @property int $timeslot_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Learner $learner
 * @property Timeslot $timeslot
 *
 * @package App\Models
 */
class LearnerTimeslot extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'learner_timeslot';

    protected $casts = [
        'learner_id' => 'int',
        'timeslot_id' => 'int'
    ];

    protected $fillable = [
        'learner_id',
        'timeslot_id'
    ];

    public function learner(): BelongsTo
    {
        return $this->belongsTo(Learner::class);
    }

    public function timeslot(): BelongsTo
    {
        return $this->belongsTo(Timeslot::class);
    }
}
