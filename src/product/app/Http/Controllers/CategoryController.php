<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json($category, 201);
    }

    public function index(){
        return Category::all();
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->update($request->all());


    }

    public function delete(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();


    }
}
