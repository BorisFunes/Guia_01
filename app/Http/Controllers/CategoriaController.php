<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::query()
            ->withCount('libros')
            ->orderBy('nombre')
            ->get();

        return response()->json($categorias);
    }

    public function show(Categoria $categoria)
    {
        $categoria->load('libros');

        return response()->json($categoria);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100|unique:Categorias,nombre',
        ]);

        $categoria = Categoria::create($data);

        return response()->json($categoria, 201);
    }

    public function update(Request $request, Categoria $categoria)
    {
        $data = $request->validate([
            'nombre' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::unique('Categorias', 'nombre')->ignore($categoria->id),
            ],
        ]);

        $categoria->update($data);

        return response()->json($categoria);
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return response()->json([
            'message' => 'Categoria eliminada correctamente.',
        ]);
    }
}
