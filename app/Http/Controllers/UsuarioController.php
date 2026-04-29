<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Mostrar la vista con la tabla y el formulario
    public function index(Request $request)
    {
        // 1. Empezamos la consulta a la base de datos
        $query = User::query();

        // 2. Filtro 1: Buscador por Texto (Nombre, Correo o Matrícula)
        if ($request->has('buscar') && $request->buscar != '') {
            $termino = $request->buscar;
            $query->where(function($q) use ($termino) {
                $q->where('name', 'LIKE', '%' . $termino . '%')
                  ->orWhere('email', 'LIKE', '%' . $termino . '%')
                  ->orWhere('matricula', 'LIKE', '%' . $termino . '%');
            });
        }

       // 3. Filtro 2: Por Rol (Estudiante, Profesor, Administrador)
        if ($request->has('rol') && $request->rol != '') {
            $query->where('rol', $request->rol);
        }

        // ---> NUEVO: Filtro por Carrera <---
        if ($request->has('carrera') && $request->carrera != '') {
            $query->where('carrera', $request->carrera);
        }

        // 4. Filtro 3: Ordenamiento A-Z o Z-A
        if ($request->has('orden') && $request->orden != '') {
       
        }else {
            // Por defecto, ordenamos de la A a la Z
            $query->orderBy('name', 'asc');
        }

        // 5. Traemos a los usuarios junto con sus préstamos y multas para la tabla
        // Usamos paginate(15) para que si hay 1000 alumnos, no colapse la página
        $usuarios = $query->with(['prestamos' => function($q) {
            $q->where('estado', 'Activo')->with('material');
        }, 'multas' => function($q) {
            $q->where('estatus', 'Pendiente');
        }])->paginate(15);
        
        // Conservamos los parámetros de búsqueda en la URL para la paginación
        $usuarios->appends($request->all());

        return view('usuarios.index', compact('usuarios'));
    }
    
    // Guardar un nuevo alumno en la BD (Registro rápido opcional)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'matricula' => 'required|string|unique:users,matricula',
            'carrera' => 'nullable|string' // <-- Validamos que llegue
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'matricula' => $request->matricula,
            'rol' => 'Estudiante',
            'carrera' => $request->carrera, // <-- LA GUARDAMOS AQUÍ
            'password' => Hash::make($request->matricula), 
        ]);

        return back()->with('success', '¡Estudiante registrado exitosamente!');
    }

    // ==========================================
    // NUEVAS FUNCIONES DE EDICIÓN
    // ==========================================

    // 1. Mostrar el formulario de edición
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    // 2. Guardar los datos editados
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        
        // Validamos que los datos estén correctos y no se repitan con otros usuarios
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'matricula' => 'required|string|unique:users,matricula,'.$id,
            'rol' => 'required|in:Estudiante,Profesor,Administrador',
            'estado' => 'required|in:Activo,Baja Temporal,Suspendido,Baja Definitiva'
        ]);
        
        // Asignamos los nuevos valores
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->matricula = $request->matricula;
        $usuario->rol = $request->rol;
        $usuario->estado = $request->estado;
        
        // Lógica inteligente: Si es profesor o admin, limpiamos la carrera. 
        // Si es estudiante, le guardamos la carrera que eligieron.
        if($request->rol == 'Profesor' || $request->rol == 'Administrador') {
            $usuario->carrera = null;
        } else {
            $usuario->carrera = $request->carrera;
        }

        $usuario->save();

        return redirect('/usuarios')->with('success', '¡Los datos de ' . $usuario->name . ' han sido actualizados correctamente!');
    }
}