<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSubscription extends Model
{
    use HasFactory;

    /**
     * اسم الجدول
     */
    protected $table = 'user_subscriptions';

    /**
     * الحقول القابلة للكتابة بالجملة
     */
    protected $fillable = [
        'user_id',
        'subscription_id', // foreign key إلى جدول plans
        'status',
        'expires_at',
    ];

    /**
     * تحويل أنواع الأعمدة تلقائيًا عند القراءة/الكتابة
     */
    protected $casts = [
        'user_id'          => 'integer',
        'subscription_id'  => 'integer',
        'status'           => 'string',
        'expires_at'       => 'datetime',
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع الباقة (يشار إليها هنا بالـ subscription_id لكنها تشير إلى جدول plans)
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'subscription_id');
    }
}
