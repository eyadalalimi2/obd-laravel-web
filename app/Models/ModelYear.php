<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModelYear extends Model
{
    protected $fillable = ['model_id', 'year'];

    public function model(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }
}
