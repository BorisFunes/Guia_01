<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prestamo extends Model
{
    protected $table = 'Prestamos';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'fecha_prestamo',
        'fecha_devolucion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_prestamo' => 'date',
            'fecha_devolucion' => 'date',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetallePrestamo::class, 'id_prestamo');
    }
}
