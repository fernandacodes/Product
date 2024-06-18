<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'expiration_date' => 'required|date',
            'image' => 'nullable|image',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'expiration_date' => $request->expiration_date,
            'image' => $request->image,
            'category_id' => $request->category_id,
        ]);

        return response()->json($product, 201);
    }

    public function index(){
        return Product::all();
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->all());


    }

    public function delete(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();


    }

    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('description')) {
            $query->where('description', 'like', '%' . $request->input('description') . '%');
        }

        $products = $query->get();

        return response()->json($products, 200);
    }

}

