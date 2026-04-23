<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestamoController extends Controller
{
    public function index()
    {
        $prestamos = Prestamo::query()
            ->with([
                'usuario:id,nombre,email,telefono',
                'detalles.libro',
            ])
            ->orderByDesc('fecha_prestamo')
            ->get();

        return response()->json($prestamos);
    }

    public function show(Prestamo $prestamo)
    {
        $prestamo->load([
            'usuario:id,nombre,email,telefono',
            'detalles.libro',
        ]);

        return response()->json($prestamo);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_usuario' => 'required|exists:Usuarios,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_prestamo',
            'libros' => 'required|array|min:1',
            'libros.*' => 'integer|distinct|exists:Libros,id',
        ]);

        $prestamo = DB::transaction(function () use ($data) {
            $prestamo = Prestamo::create([
                'id_usuario' => $data['id_usuario'],
                'fecha_prestamo' => $data['fecha_prestamo'],
                'fecha_devolucion' => $data['fecha_devolucion'] ?? null,
            ]);

            $prestamo->detalles()->createMany(
                collect($data['libros'])
                    ->map(fn (int $libroId) => ['id_libro' => $libroId])
                    ->all()
            );

            return $prestamo;
        });

        return response()->json($prestamo->load(['usuario:id,nombre,email,telefono', 'detalles.libro']), 201);
    }

    public function update(Request $request, Prestamo $prestamo)
    {
        $data = $request->validate([
            'id_usuario' => 'sometimes|required|exists:Usuarios,id',
            'fecha_prestamo' => 'sometimes|required|date',
            'fecha_devolucion' => 'sometimes|nullable|date',
            'libros' => 'sometimes|array|min:1',
            'libros.*' => 'integer|distinct|exists:Libros,id',
        ]);

        DB::transaction(function () use ($prestamo, $data) {
            $prestamo->update([
                'id_usuario' => $data['id_usuario'] ?? $prestamo->id_usuario,
                'fecha_prestamo' => $data['fecha_prestamo'] ?? $prestamo->fecha_prestamo,
                'fecha_devolucion' => array_key_exists('fecha_devolucion', $data)
                    ? $data['fecha_devolucion']
                    : $prestamo->fecha_devolucion,
            ]);

            if (array_key_exists('libros', $data)) {
                $prestamo->detalles()->delete();
                $prestamo->detalles()->createMany(
                    collect($data['libros'])
                        ->map(fn (int $libroId) => ['id_libro' => $libroId])
                        ->all()
                );
            }
        });

        return response()->json($prestamo->fresh()->load(['usuario:id,nombre,email,telefono', 'detalles.libro']));
    }

    public function destroy(Prestamo $prestamo)
    {
        $prestamo->delete();

        return response()->json([
            'message' => 'Prestamo eliminado correctamente.',
        ]);
    }
}
