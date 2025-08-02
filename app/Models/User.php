<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\SavedCode;
use App\Models\UserNotification;
use App\Models\UserSubscription;
use App\Models\Notification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, MustVerifyEmailTrait;


    /**
     * الحقول القابلة للتعبئة
     */
    protected $fillable = [
        'username',
        'email',
        'phone',
        'firebase_uid',
        'job_title',
        'package_name',
        'user_mode',
        'current_plan',
        'plan_start_date',
        'plan_renewal_date',
        'profile_image',
        'is_admin',
        'password',
        'role',
        'status',
        'email_verified_at',
        'remember_token',
    ];

    /**
     * الحقول المخفية عند الإرجاع
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * التحويلات التلقائية للأنواع
     */
    protected $casts = [
        'email_verified_at'   => 'datetime',
        'plan_start_date'     => 'date',
        'plan_renewal_date'   => 'date',
        'is_admin'            => 'boolean',
    ];

    /**
     * الأكواد التي حفظها المستخدم
     */
    public function savedCodes(): HasMany
    {
        return $this->hasMany(SavedCode::class, 'user_id');
    }

    /**
     * إشعارات المستخدم
     */
    public function userNotifications(): HasMany
    {
        return $this->hasMany(UserNotification::class, 'user_id');
    }

    /**
     * اشتراكات المستخدم
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class, 'user_id');
    }
    public function notifications()
    {
        return $this->belongsToMany(
            Notification::class,
            'notification_user',
            'user_id',
            'notification_id'
        )->withPivot('read_at', 'created_at', 'updated_at');
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
