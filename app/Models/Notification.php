<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'title',
        'message',
        'type',
        'data',
    ];

    // إذا أردت أن يُخزّن JSON في العمود `data` كمصفوفة أوبجيكت في الـ Model:
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * علاقة many-to-many مع المستخدمين عبر جدول notification_user
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'notification_user',      // اسم جدول الـ Pivot
            'notification_id',        // المفتاح الأجنبي في جدول Pivot الذي يشير إلى Notification
            'user_id'                 // المفتاح الأجنبي في جدول Pivot الذي يشير إلى User
        )
        ->withPivot('read_at')       // نحتاج هذا الحقل للإشارة إلى متى قرأ المستخدم الإشعار
        ->withTimestamps();          // created_at & updated_at على Pivot
    }
}
