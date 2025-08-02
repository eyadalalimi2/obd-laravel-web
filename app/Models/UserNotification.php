<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Notification;
use App\Models\User;

class UserNotification extends Model
{
    protected $table = 'notification_user';

    protected $fillable = [
        'user_id',
        'notification_id',
        'read_at',
    ];

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
