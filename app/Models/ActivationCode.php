<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'code',
        'uses_left',
        'expires_at',
        'created_by',
    ];

    protected $casts = [
        'uses_left'  => 'integer',
        'expires_at' => 'datetime',
    ];

    /**
     * الباقة التي ينتمي لها هذا الرمز
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * المشرف الذي أنشأ الرمز
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
