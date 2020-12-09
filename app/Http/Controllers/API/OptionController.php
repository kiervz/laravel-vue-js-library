<?php

namespace App\Http\Controllers\API;

use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index()
    {
        $options = Option::all();

        return response()->json([
            'options' => $options
        ]);
    }

    public function update(Request $request, $id) 
    {
        $option = Option::findOrFail($id);
        $option->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Options Successfully Updated!'
        ]);
    }

}
