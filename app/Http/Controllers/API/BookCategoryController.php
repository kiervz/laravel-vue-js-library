<?php

namespace App\Http\Controllers\API;

use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookCategoryController extends Controller
{
    public function index() 
    {
        $categories = BookCategory::all();

        return response()->json([
            'categories' => $categories,
        ]);
    }
}
