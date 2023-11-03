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
 * Class Message
 *
 * @property int $id
 * @property int $sender_id
 * @property int $conversation_id
 * @property string $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Conversation $conversation
 * @property User $user
 *
 * @package App\Models
 */
class Message extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'messages';

    protected $casts = [
        'sender_id' => 'int',
        'conversation_id' => 'int'
    ];

    protected $fillable = [
        'sender_id',
        'conversation_id',
        'message'
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
