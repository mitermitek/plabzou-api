<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PromotionTimeslot
 *
 * @property int $id
 * @property int $promotion_id
 * @property int $timeslot_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Promotion $promotion
 * @property Timeslot $timeslot
 *
 * @package App\Models
 */
class PromotionTimeslot extends Model
{
    use SoftDeletes;

    protected $table = 'promotion_timeslot';

    protected $casts = [
        'promotion_id' => 'int',
        'timeslot_id' => 'int'
    ];

    protected $fillable = [
        'promotion_id',
        'timeslot_id'
    ];

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    public function timeslot(): BelongsTo
    {
        return $this->belongsTo(Timeslot::class);
    }
}
