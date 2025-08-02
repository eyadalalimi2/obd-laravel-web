<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'start_at',
        'end_at',
        'status',
        'platform',
        'txn_token',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
    ];

    /**
     * المستخدم صاحب الاشتراك
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * الباقة المرتبطة بالاشتراك
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
