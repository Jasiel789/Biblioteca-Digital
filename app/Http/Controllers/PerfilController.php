<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    // 1. Mostrar la pantalla del perfil
    public function index()
    {
        $usuario = Auth::user();
        return view('perfil.index', compact('usuario'));
    }

    // 2. Guardar los cambios
    public function update(Request $request)
    {
        $usuario = Auth::user();

        // Validamos los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:5', // Nullable significa que no es obligatorio
        ]);

        // Actualizamos nombre y correo
        $usuario->name = $request->name;
        $usuario->email = $request->email;

        // Si escribió una nueva contraseña, la encriptamos y la guardamos
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return back()->with('success', '¡Tus datos personales han sido actualizados con éxito!');
    }
}