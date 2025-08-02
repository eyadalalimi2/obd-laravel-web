<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    // جميع المقالات التابعة لهذا التصنيف
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
    public function codes()
    {
        return $this->hasMany(ObdCode::class, 'category', 'slug');
    }
}
