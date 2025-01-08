<?php

namespace App\Http\Controllers;

use App\Models\TaskCategory;
use Illuminate\Http\Request;

class TaskCategoryController extends Controller
{
    /**
     * Criar uma nova categoria de tarefa.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:task_categories',
            'color' => 'required|string|max:7|regex:/^#[0-9a-fA-F]{6}$/', // Exemplo: #FFFFFF
        ]);

        $category = TaskCategory::create([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        return response()->json($category, 201);
    }

    /**
     * Listar todas as categorias.
     */
    public function index()
    {
        $categories = TaskCategory::all();
        return response()->json($categories);
    }

    /**
     * Atualizar uma categoria específica.
     */
    public function update(Request $request, $id)
    {
        $category = TaskCategory::findOrFail($id);

        $request->validate([
            'name' => 'nullable|string|max:255|unique:task_categories,name,' . $id,
            'color' => 'nullable|string|max:7|regex:/^#[0-9a-fA-F]{6}$/',
        ]);

        $category->update($request->all());

        return response()->json($category);
    }

    /**
     * Deletar uma categoria específica.
     */
    public function delete($id)
    {
        $category = TaskCategory::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }
}
