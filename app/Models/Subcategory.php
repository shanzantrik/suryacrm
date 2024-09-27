<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    // Define the fillable properties
    protected $table = 'subcategories';
    protected $fillable = [
        'name',
        'category_id', // Ensure category_id is fillable
    ];

    // Define the relationship to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
