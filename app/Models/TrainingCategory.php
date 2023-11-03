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
 * Class TrainingCategory
 *
 * @property int $id
 * @property int $training_id
 * @property int $category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Category $category
 * @property Training $training
 *
 * @package App\Models
 */
class TrainingCategory extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'training_category';

    protected $casts = [
        'training_id' => 'int',
        'category_id' => 'int'
    ];

    protected $fillable = [
        'training_id',
        'category_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }
}
