<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AutorController extends Controller
{
    public function index()
    {
        $autores = Autor::query()
            ->withCount('libros')
            ->orderBy('nombre')
            ->get();

        return response()->json($autores);
    }

    public function show(Autor $autor)
    {
        $autor->load('libros');

        return response()->json($autor);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:150|unique:Autores,nombre',
        ]);

        $autor = Autor::create($data);

        return response()->json($autor, 201);
    }

    public function update(Request $request, Autor $autor)
    {
        $data = $request->validate([
            'nombre' => [
                'sometimes',
                'required',
                'string',
                'max:150',
                Rule::unique('Autores', 'nombre')->ignore($autor->id),
            ],
        ]);

        $autor->update($data);

        return response()->json($autor);
    }

    public function destroy(Autor $autor)
    {
        $autor->delete();

        return response()->json([
            'message' => 'Autor eliminado correctamente.',
        ]);
    }
}
