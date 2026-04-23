<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    public function index()
    {
        $libros = Libro::query()
            ->with(['categoria', 'autores'])
            ->orderBy('titulo')
            ->get();

        return response()->json($libros);
    }

    public function show(Libro $libro)
    {
        $libro->load(['categoria', 'autores']);

        return response()->json($libro);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'año_publicacion' => 'nullable|integer|min:0|max:2100',
            'id_categoria' => 'nullable|exists:Categorias,id',
            'autores' => 'sometimes|array',
            'autores.*' => 'integer|exists:Autores,id',
        ]);

        $libro = Libro::create([
            'titulo' => $data['titulo'],
            'año_publicacion' => $data['año_publicacion'] ?? null,
            'id_categoria' => $data['id_categoria'] ?? null,
        ]);

        if (array_key_exists('autores', $data)) {
            $libro->autores()->sync($data['autores']);
        }

        return response()->json($libro->load(['categoria', 'autores']), 201);
    }

    public function update(Request $request, Libro $libro)
    {
        $data = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'año_publicacion' => 'sometimes|nullable|integer|min:0|max:2100',
            'id_categoria' => 'sometimes|nullable|exists:Categorias,id',
            'autores' => 'sometimes|array',
            'autores.*' => 'integer|exists:Autores,id',
        ]);

        $libro->update([
            'titulo' => $data['titulo'] ?? $libro->titulo,
            'año_publicacion' => array_key_exists('año_publicacion', $data)
                ? $data['año_publicacion']
                : $libro->año_publicacion,
            'id_categoria' => array_key_exists('id_categoria', $data)
                ? $data['id_categoria']
                : $libro->id_categoria,
        ]);

        if (array_key_exists('autores', $data)) {
            $libro->autores()->sync($data['autores']);
        }

        return response()->json($libro->load(['categoria', 'autores']));
    }

    public function destroy(Libro $libro)
    {
        $libro->delete();

        return response()->json([
            'message' => 'Libro eliminado correctamente.',
        ]);
    }
}
