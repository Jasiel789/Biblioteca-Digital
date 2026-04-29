<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prestamo;
use App\Models\Multa;

class PortalController extends Controller
{
    public function inicio()
    {
        // 1. Obtenemos al usuario que inició sesión
        $user = Auth::user();

        // 2. Buscamos SOLO sus préstamos activos
        $misPrestamos = Prestamo::with('material')
            ->where('user_id', $user->id)
            ->where('estado', 'Activo')
            ->orderBy('fecha_limite', 'asc')
            ->get();

        // 3. Buscamos SOLO sus multas pendientes
        $misMultas = [];
        if (class_exists(\App\Models\Multa::class)) {
            $misMultas = Multa::where('user_id', $user->id)
                ->where('estatus', 'Pendiente')
                ->get();
        }

        return view('portal.inicio', compact('user', 'misPrestamos', 'misMultas'));
    }

    // Mostrar el catálogo de libros a los alumnos
    // Mostrar el catálogo de libros a los alumnos
    // Catálogo Público para Alumnos y Profesores
    public function catalogo(Request $request)
    {
        // 1. Iniciamos la consulta de materiales
        $query = \App\Models\Material::query();

        // 2. Filtro de Búsqueda por Texto (Título, Autor o Código)
        if ($request->has('buscar') && $request->buscar != '') {
            $termino = $request->buscar;
            $query->where(function($q) use ($termino) {
                $q->where('titulo', 'LIKE', '%' . $termino . '%')
                  ->orWhere('autor', 'LIKE', '%' . $termino . '%')
                  ->orWhere('codigo_bibupem', 'LIKE', '%' . $termino . '%');
            });
        }

        // 3. Filtro por Categoría
        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('categoria', $request->categoria);
        }

        // 4. Filtro por Formato (clasificacion)
        if ($request->has('formato') && $request->formato != '') {
            $query->where('clasificacion', $request->formato);
        }

        // 5. Ejecutamos la consulta paginada (12 libros por página para que se vea una cuadrícula perfecta de 3x4 o 4x3)
        $materiales = $query->orderBy('titulo', 'asc')->paginate(12);
        
        // Conservamos los parámetros en la URL al cambiar de página
        $materiales->appends($request->all());

        // 6. Obtenemos las categorías y formatos únicos que existen en la BD para llenar los menús desplegables automáticamente
        $categorias = \App\Models\Material::select('categoria')->distinct()->whereNotNull('categoria')->pluck('categoria');
        $formatos = \App\Models\Material::select('clasificacion')->distinct()->whereNotNull('clasificacion')->pluck('clasificacion');

        return view('portal.catalogo', compact('materiales', 'categorias', 'formatos'));
    }
}