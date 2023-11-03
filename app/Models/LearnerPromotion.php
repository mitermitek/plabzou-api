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
 * Class LearnerPromotion
 *
 * @property int $id
 * @property int $learner_id
 * @property int $promotion_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Learner $learner
 * @property Promotion $promotion
 *
 * @package App\Models
 */
class LearnerPromotion extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'learner_promotion';

    protected $casts = [
        'learner_id' => 'int',
        'promotion_id' => 'int'
    ];

    protected $fillable = [
        'learner_id',
        'promotion_id'
    ];

    public function learner(): BelongsTo
    {
        return $this->belongsTo(Learner::class);
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }
}
