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
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Building
 *
 * @property int $id
 * @property string $name
 * @property int $place_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Place $place
 * @property Collection|Room[] $rooms
 *
 * @package App\Models
 */
class Building extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'buildings';

    protected $casts = [
        'place_id' => 'int'
    ];

    protected $fillable = [
        'name',
        'place_id'
    ];

    protected $with = ['place'];

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
