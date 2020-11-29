<?php

namespace App\Http\Controllers\API;

use App\Models\BookCategory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookCategoryController extends Controller
{
    public function index() 
    {
        $categories = BookCategory::all();

        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'string|required|unique:book_categories|max:50',
        ]);

        BookCategory::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Category successfully added!'
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string|required|max:50|unique:book_categories,name,' .$request->id,
        ]);

        $book_category = BookCategory::findOrFail($id);
        $book_category->name = $request->name;
        $book_category->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Category successfully updated!',
        ], Response::HTTP_OK);
    }
}
