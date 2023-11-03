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
 * Class AdministrativeEmployee
 *
 * @property int $user_id
 * @property bool $is_super_admin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property User $user
 * @property Collection|Request[] $requests
 *
 * @package App\Models
 */
class AdministrativeEmployee extends Model
{
    use SoftDeletes, HasFactory;

    public $incrementing = false;
    protected $table = 'administrative_employees';
    protected $primaryKey = 'user_id';
    protected $casts = [
        'user_id' => 'int',
        'is_super_admin' => 'bool'
    ];

    protected $fillable = [
        'is_super_admin',
        'user_id'
    ];

    protected $appends = ['full_name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->user->full_name;
    }
}
