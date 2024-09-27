<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday_Dates extends Model
{
    use HasFactory;
    protected $fillable = [
        'holiday_date',
        'description',
        'religion',
        'category_id',
        'subcategory_id',
    ];
    // Define the relationships if necessary
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
