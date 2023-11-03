<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Collection|Training[] $trainings
 *
 * @package App\Models
 */
class Category extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name'
    ];

    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(
            Training::class,
            'training_category',
            'category_id',
            'training_id'
        )
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }
}
