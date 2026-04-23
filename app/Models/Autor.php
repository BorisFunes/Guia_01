<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Autor extends Model
{
    protected $table = 'Autores';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];

    public function libros(): BelongsToMany
    {
        return $this->belongsToMany(Libro::class, 'Libro_Autor', 'id_autor', 'id_libro');
    }
}
