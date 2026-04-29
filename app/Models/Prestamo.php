<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id', 
    'material_id', 
    'admin_id', 
    'fecha_prestamo',
    'fecha_limite', 
    'estado'];
    // Relación: Un préstamo pertenece a un Alumno (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un préstamo pertenece a un Material
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    // Relación: Un préstamo es atendido por un administrador (que también es un usuario)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}