<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'prestamo_id',
        'monto',
        'estatus',
        'motivo'
    ];

    // Una multa pertenece a un alumno
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Una multa se genera por un préstamo
    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }
}