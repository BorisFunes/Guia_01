<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'Categorias';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];

    public function libros(): HasMany
    {
        return $this->hasMany(Libro::class, 'id_categoria');
    }
}
