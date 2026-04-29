<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear el Administrador por defecto
        User::create([
            'name' => 'Pablo Bernal (Admin)',
            'email' => 'admin@upemor.edu.mx',
            'matricula' => 'admin', // Puedes cambiarla si usabas otra
            'rol' => 'Administrador',
            'password' => Hash::make('admin'), // Contraseña será 'admin'
        ]);
    }
}