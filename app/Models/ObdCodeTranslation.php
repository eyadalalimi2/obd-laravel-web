<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ObdCodeTranslation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'obd_code_translations';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'obd_code_id',
        'language_code',
        'title',
        'description',
        'symptoms',
        'causes',
        'diagnosis',
        'severity',
        'solutions',
        'embedding',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'embedding' => 'array',
    ];

    /**
     * Relationship to the parent OBD code.
     */
    public function obdCode()
    {
        return $this->belongsTo(ObdCode::class, 'obd_code_id');
    }

    /**
     * Relationship to the language.
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_code', 'code');
    }
}
