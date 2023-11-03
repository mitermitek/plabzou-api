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
 * Class Place
 *
 * @property int $id
 * @property string $name
 * @property string $street_address
 * @property int $city_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property City $city
 * @property Collection|Building[] $buildings
 *
 * @package App\Models
 */
class Place extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'places';

    protected $casts = [
        'city_id' => 'int'
    ];

    protected $fillable = [
        'name',
        'street_address',
        'city_id'
    ];

    protected $with = ['city'];

    protected $appends = ['full_address'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }

    public function getFullAddressAttribute(): string
    {
        return $this->street_address . ' - ' . $this->city->postcode . ' ' . $this->city->name;
    }
}
