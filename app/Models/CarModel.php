<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarModel extends Model
{
    protected $table = 'models';
    protected $fillable = ['name', 'brand_id'];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function years(): HasMany
    {
        return $this->hasMany(ModelYear::class, 'model_id');
    }
}
