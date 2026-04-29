<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash; 
use App\Models\User;

class AuthController extends Controller
{
    // ==========================================
    // 1. Mostrar la vista del Login
    // ==========================================
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ==========================================
    // 2. Procesar el formulario de Login
    // ==========================================
    public function login(Request $request)
    {
        // Validar que llenaron los campos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Auth::attempt busca al usuario y verifica automáticamente la contraseña
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Obtenemos al usuario que acaba de iniciar sesión
            $usuarioLogueado = Auth::user();
            
            // REDIRECCIÓN INTELIGENTE BASADA EN ROLES
            if ($usuarioLogueado->rol === 'Administrador') {
                return redirect()->intended('/dashboard');
            } else {
                return redirect()->intended('/mi-portal'); // <-- Corregido para ir al portal del alumno
            }
        }

        // Si falla, regresa con un mensaje de error
        return back()->withErrors([
            'email' => 'Credenciales inválidas. Verifica tu correo y contraseña.',
        ])->onlyInput('email');
    }

    // ==========================================
    // 3. Cerrar sesión
    // ==========================================
    public function logout(Request $request)
    {
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
        
        return redirect('/'); 
    }

    // ==========================================
    // 4. Mostrar la vista pública de Registro
    // ==========================================
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // ==========================================
    // 5. Procesar y guardar al nuevo usuario
    // ==========================================
    public function register(Request $request)
    {
        // 1. Validamos que lleguen todos los datos del formulario de registro
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'matricula' => 'required|string|unique:users,matricula',
            'password' => 'required|string|min:6|confirmed', // Asumo que usas confirmación de contraseña
            'rol' => 'required|in:Estudiante,Profesor',
            'carrera' => 'nullable|string' // Validamos que llegue la carrera
        ]);

        // 2. Lógica inteligente para la carrera
        $carreraFinal = null;
        if ($request->rol == 'Estudiante') {
            $carreraFinal = $request->carrera;
        }

        // 3. Creamos al usuario en la base de datos
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'matricula' => $request->matricula,
            'rol' => $request->rol,
            'carrera' => $carreraFinal, // <-- AQUÍ YA SE GUARDA AUTOMÁTICAMENTE
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'estado' => 'Activo' // Por defecto entran activos
        ]);

        // Opcional: Si quieres que inicien sesión automáticamente tras registrarse
        // \Illuminate\Support\Facades\Auth::login($user);

        // 4. Redirigimos al login con mensaje de éxito
        return redirect('/')->with('success', '¡Registro exitoso! Ya puedes iniciar sesión.');
    }
}