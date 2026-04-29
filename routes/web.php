<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\MultaController;
use Illuminate\Support\Facades\Auth;
use App\Models\Prestamo;
use App\Models\Material;
use Carbon\Carbon;
use Illuminate\Http\Request;

// ==========================================
// 1. RUTAS PÚBLICAS (No requieren sesión)
// ==========================================

// Login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Registro Público (Formulario de alumnos y profesores)
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);


// ==========================================
// 2. RUTAS GENERALES (Cualquier usuario logueado)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Cerrar sesión (Aplica para Admins y Alumnos)
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Portal Principal del Alumno
    Route::get('/mi-portal', [PortalController::class, 'inicio']);
    
    // Catálogo público para que el alumno busque libros
    // (Asegúrate de crear esta función 'catalogo' en tu PortalController después)
    Route::get('/catalogo-publico', [PortalController::class, 'catalogo']); 
});


// ==========================================
// 3. RUTAS PROTEGIDAS (Solo Administradores)
// ==========================================
Route::middleware(['auth', 'admin'])->group(function () {
    
    // ------------------------------------------
    // Dashboard (Panel Interactivo)
    // ------------------------------------------
    Route::get('/dashboard', function (Request $request) {
        $prestamosActivos = Prestamo::where('estado', 'Activo')->count();
        $devolucionesPendientes = Prestamo::where('estado', 'Activo')
                                        ->where('fecha_limite', '<', Carbon::now()->startOfDay())
                                        ->count();
        $stockBajo = Material::where('stock_fisico', '<=', 3)->count();
        $actividad = Prestamo::with(['user', 'material', 'admin'])->orderBy('created_at', 'desc')->take(5)->get();

        $filtro = $request->query('filtro');
        $datosFiltro = null;

        if ($filtro == 'activos') {
            $datosFiltro = Prestamo::with(['user', 'material'])->where('estado', 'Activo')->get();
        } elseif ($filtro == 'atrasados') {
            $datosFiltro = Prestamo::with(['user', 'material'])
                                   ->where('estado', 'Activo')
                                   ->where('fecha_limite', '<', Carbon::now()->startOfDay())
                                   ->get();
        } elseif ($filtro == 'stock') {
            $datosFiltro = Material::where('stock_fisico', '<=', 3)->get();
        }

        return view('dashboard', compact('prestamosActivos', 'devolucionesPendientes', 'stockBajo', 'actividad', 'filtro', 'datosFiltro'));
    });

    // ------------------------------------------
    // Gestión de Catálogo de Materiales
    // ------------------------------------------
    Route::get('/materiales', [MaterialController::class, 'index']);
    Route::get('/materiales/crear', [MaterialController::class, 'create']);
    Route::post('/materiales', [MaterialController::class, 'store']);
    Route::post('/materiales/importar', [MaterialController::class, 'importar']); // Importar siempre arriba de los parametros con {id}
    Route::get('/materiales/{id}/editar', [MaterialController::class, 'edit']); 
    Route::put('/materiales/{id}', [MaterialController::class, 'update']);
    Route::delete('/materiales/{id}', [MaterialController::class, 'destroy']);

    // ------------------------------------------
    // Gestión de Usuarios (Padrón)
    // ------------------------------------------
    Route::get('/usuarios', [UsuarioController::class, 'index']);
    Route::post('/usuarios', [UsuarioController::class, 'store']); // Para altas rápidas
    Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'edit']); // Carga el formulario
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);      // Guarda los cambios del formulario

    // ------------------------------------------
    // Préstamos y Devoluciones
    // ------------------------------------------
    Route::get('/prestamos', [PrestamoController::class, 'index']);
    Route::post('/prestamos', [PrestamoController::class, 'store']);
    Route::post('/prestamos/gestionar', [PrestamoController::class, 'gestionarPrestamo']);
    Route::post('/prestamos/{id}/devolver', [PrestamoController::class, 'devolver']);

    // ------------------------------------------
    // Multas y Cobranza
    // ------------------------------------------
    Route::get('/multas/{id}/ficha', [MultaController::class, 'generarFicha']);
    Route::put('/multas/{id}/pagar', [MultaController::class, 'pagar']);

    // ------------------------------------------
    // Reportes y Estadísticas
    // ------------------------------------------
    Route::get('/reportes', [ReporteController::class, 'index']);
    Route::get('/reportes/exportar/{formato}/{tipo}', [ReporteController::class, 'exportar']);

    // ------------------------------------------
    // Configuración de Perfil (Admin)
    // ------------------------------------------
    Route::get('/mi-perfil', [PerfilController::class, 'index']);
    Route::put('/mi-perfil', [PerfilController::class, 'update']);
});