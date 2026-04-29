<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\User;
use App\Models\Material;
use App\Models\Multa;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    // ==========================================
    // 1. Mostrar la pantalla de Préstamos
    // ==========================================
    public function index(\Illuminate\Http\Request $request)
    {
        // 1. Usuarios para el buscador del Nuevo Préstamo
        $usuarios = \App\Models\User::all();

        // 2. Materiales disponibles (stock mayor a 0)
        $materiales = \App\Models\Material::where('stock_fisico', '>', 0)->get();

        // 3. Préstamos Activos para el buscador de Gestionar Préstamo
        $prestamosActivos = \App\Models\Prestamo::with(['user', 'material'])
                                ->where('estado', 'Activo')
                                ->get();

        // 4. Multas Pendientes (Con la lógica para que el cuadro de búsqueda funcione)
        $queryMultas = \App\Models\Multa::where('estatus', 'Pendiente')->with(['user', 'prestamo.material']);
        
        if ($request->has('buscar_multa') && $request->buscar_multa != '') {
            $termino = $request->buscar_multa;
            // Buscamos dentro de la relación del usuario (por nombre o matrícula)
            $queryMultas->whereHas('user', function($q) use ($termino) {
                $q->where('name', 'LIKE', '%' . $termino . '%')
                  ->orWhere('matricula', 'LIKE', '%' . $termino . '%');
            });
        }
        $multas = $queryMultas->get();

        // 5. ¡AQUÍ ESTÁ LA VARIABLE QUE FALTABA! El historial de últimos movimientos
        $todosLosPrestamos = \App\Models\Prestamo::with(['user', 'material', 'admin'])
                                ->orderBy('created_at', 'desc')
                                ->take(20) // Traemos solo los últimos 20 para no saturar la página
                                ->get();

        // Mandamos TODAS las variables a la vista
        return view('prestamos.index', compact('usuarios', 'materiales', 'prestamosActivos', 'multas', 'todosLosPrestamos'));
    }

    // ==========================================
    // 2. Registrar un Nuevo Préstamo
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'material_id' => 'required|exists:materials,id',
        ]);

        $material = Material::findOrFail($request->material_id);

        if ($material->stock_fisico <= 0) {
            return back()->withErrors(['error' => 'Este material ya no tiene stock disponible.']);
        }

       Prestamo::create([
            'user_id' => $request->user_id,
            'material_id' => $request->material_id,
            'admin_id' => \Illuminate\Support\Facades\Auth::id(), // <- NUEVO: Guarda al Admin actual
            'fecha_prestamo' => \Carbon\Carbon::now(),
            'fecha_limite' => \Carbon\Carbon::now()->addDays(7),
            'estado' => 'Activo'
        ]);

        $material->decrement('stock_fisico');

        return back()->with('success', '¡Préstamo registrado exitosamente!');
    }

    // ==========================================
    // 3. Lógica principal para Devolver y Multar
    // ==========================================
    public function devolver($id)
    {
        $prestamo = Prestamo::findOrFail($id);

        if ($prestamo->estado != 'Activo') {
            return back()->withErrors(['error' => 'Este material ya fue devuelto.']);
        }

        // Cambiar estado y regresar stock
        $prestamo->update(['estado' => 'Devuelto']);
        $prestamo->material->increment('stock_fisico');

        $mensaje = '¡Material devuelto con éxito y stock actualizado!';
        
        // Validar si hay multa por retraso
        if (Carbon::now()->startOfDay()->greaterThan(Carbon::parse($prestamo->fecha_limite)->startOfDay())) {
            Multa::create([
                'user_id' => $prestamo->user_id,
                'prestamo_id' => $prestamo->id,
                'monto' => 10.00,
                'estatus' => 'Pendiente'
            ]);
            $mensaje .= ' Nota: Se generó una multa de $10.00 por entrega tardía.';
        }

        return back()->with('success', $mensaje);
    }

    // ==========================================
    // 4. Procesar la búsqueda del nuevo formulario
    // ==========================================
    // Recibe la petición y decide si es devolución o renovación
    public function gestionarPrestamo(Request $request)
    {
        $request->validate([
            'prestamo_id' => 'required|exists:prestamos,id',
            'accion' => 'required|in:devolver,renovar' // Validamos qué botón presionó
        ]);

        if ($request->accion == 'devolver') {
            return $this->devolver($request->prestamo_id);
        } else {
            return $this->renovar($request->prestamo_id);
        }
    }

    // Lógica estricta de Renovación
    public function renovar($id)
    {
        $prestamo = Prestamo::findOrFail($id);

        if ($prestamo->estado != 'Activo') {
            return back()->withErrors(['error' => 'El préstamo ya no está activo.']);
        }

        $hoy = \Carbon\Carbon::now()->startOfDay();
        $limite = \Carbon\Carbon::parse($prestamo->fecha_limite)->startOfDay();

        // 1. Regla: Si ya pasó la fecha límite, se bloquea y toca multa
        if ($hoy->greaterThan($limite)) {
            return back()->withErrors(['error' => '❌ El préstamo ya venció. El usuario debe devolver el material y pagar su multa.']);
        }

        // 2. Regla: Solo renovar en el último día (fecha límite)
        // (Si vas a hacer pruebas hoy mismo, puedes comentar estas 3 líneas temporalmente)
        if ($hoy->lessThan($limite)) {
            return back()->withErrors(['error' => '⚠️ Aún no es la fecha límite. Solo se puede renovar en el último día del préstamo.']);
        }

        // Extendemos 7 días más a partir de la fecha límite actual
        $prestamo->update([
            'fecha_limite' => $limite->addDays(7)
        ]);

        return back()->with('success', '¡Préstamo renovado exitosamente! El usuario tiene 7 días adicionales.');
    }
}