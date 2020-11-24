<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BookCategory;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category() 
    {
        return $this->belongsTo(BookCategory::class);
    }
}
