<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    protected $table = 'Usuarios';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
    ];

    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class, 'id_usuario');
    }
}
