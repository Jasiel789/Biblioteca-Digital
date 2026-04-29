<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        // Públicos
        'codigo_bibupem',
        'titulo',
        'autor',
        'edicion',
        'lugar_publicacion',
        'editorial',
        'isbn',
        'clasificacion',
        'categoria',     
        'visibilidad',
        'portada_url',
        'fecha_publicacion',
        'stock_fisico', // "Cuántos ejemplares"
        
        // Privados (Solo Admin)
        'numero_paginas',
        'solicitado_por',
        'tipo_adquisicion',
        'precio',
        'fecha_compra',
    ];

    // Relación con los préstamos
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}