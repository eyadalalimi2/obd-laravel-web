<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\ObdCode;

class SavedCode extends Model
{
    protected $table = 'saved_codes';

    protected $fillable = [
        'user_id',
        'obd_code_id',
        'saved_at',
    ];

    protected $casts = [
        'saved_at' => 'datetime',
    ];

    /**
     * علاقة بالمستخدم
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * علاقة بكود الـ OBD
     *
     * @return BelongsTo
     */
    public function obdCode(): BelongsTo
    {
        return $this->belongsTo(ObdCode::class, 'obd_code_id', 'id');
    }
}
