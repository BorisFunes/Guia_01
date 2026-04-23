<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Libro extends Model
{
    protected $table = 'Libros';

    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'año_publicacion',
        'id_categoria',
    ];

    protected function casts(): array
    {
        return [
            'año_publicacion' => 'integer',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function autores(): BelongsToMany
    {
        return $this->belongsToMany(Autor::class, 'Libro_Autor', 'id_libro', 'id_autor');
    }

    public function detallePrestamos(): HasMany
    {
        return $this->hasMany(DetallePrestamo::class, 'id_libro');
    }
}
