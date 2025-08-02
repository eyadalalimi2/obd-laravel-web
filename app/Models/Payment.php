<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Subscription;
use App\Models\UserSubscription;

class Payment extends Model
{
    use HasFactory;

    /**
     * اسم جدول المدفوعات
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * الحقول القابلة للتعيين جماعياً
     *
     * @var array
     */
    protected $fillable = [
        'subscription_id',
        'user_subscription_id',
        'amount',
        'payment_method',
        'transaction_id',
        'paid_at',
        'status',
    ];

    /**
     * تحويل أنواع الأعمدة تلقائياً
     *
     * @var array
     */
    protected $casts = [
        'subscription_id'      => 'integer',
        'user_subscription_id' => 'integer',
        'amount'               => 'decimal:2',
        'paid_at'              => 'datetime',
        'status'               => 'string',
    ];

    /**
     * علاقة بالاشتراك الرئيسي (من جدول subscriptions)
     *
     * @return BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'id');
    }

    /**
     * علاقة باشتراك المستخدم (من جدول user_subscriptions)
     *
     * @return BelongsTo
     */
    public function userSubscription(): BelongsTo
    {
        return $this->belongsTo(UserSubscription::class, 'user_subscription_id', 'id');
    }
}
