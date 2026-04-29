<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Imports\MaterialesImport;
use Maatwebsite\Excel\Facades\Excel;

class MaterialController extends Controller
{
    // Mostrar la vista con la tabla, formulario, buscador y ordenamiento
    public function index(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\Material::query();

        // 1. Lógica del Buscador
        if ($request->buscar) {
            $query->where('titulo', 'LIKE', '%' . $request->buscar . '%')
                  ->orWhere('autor', 'LIKE', '%' . $request->buscar . '%')
                  ->orWhere('codigo_bibupem', 'LIKE', '%' . $request->buscar . '%');
        }

        // 2. NUEVA Lógica de Ordenamiento
        if ($request->orden == 'asc') {
            $query->orderBy('titulo', 'asc');
        } elseif ($request->orden == 'desc') {
            $query->orderBy('titulo', 'desc');
        } elseif ($request->orden == 'antiguos') {
            // Ordena del ID más chico al más grande
            $query->orderBy('id', 'asc'); 
        } else {
            // Por defecto, o si eligen 'recientes', mostramos el ID más grande primero
            $query->orderBy('id', 'desc'); 
        }

        $materiales = $query->get();

        return view('materiales.index', compact('materiales'));
    }

    // 1. Mostrar el formulario de nuevo material
    public function create()
    {
        return view('materiales.create');
    }

    // 2. Guardar el material con autogeneración de Código
    public function store(\Illuminate\Http\Request $request)
    {
        // 1. Validamos lo básico (el código puede venir vacío)
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'stock_fisico' => 'required|integer|min:0',
        ]);

        // 2. Tomamos todos los datos del formulario
        $datos = $request->all();

        // 3. LA MAGIA: Autogenerador de Códigos UPEMOR
        if (empty($datos['codigo_bibupem'])) {
            $anioActual = date('Y'); // Sacamos el año actual (Ej. 2026)
            
            // Contamos cuántos libros se han registrado este año para saber el consecutivo
            $cantidadEsteAnio = \App\Models\Material::whereYear('created_at', $anioActual)->count();
            $siguienteNumero = $cantidadEsteAnio + 1;
            
            // Armamos el código rellenando con ceros a la izquierda (Ej. UPEM-2026-0001)
            $codigoGenerado = 'UPEM-' . $anioActual . '-' . str_pad($siguienteNumero, 4, '0', STR_PAD_LEFT);
            
            // Se lo asignamos a los datos antes de guardarlos
            $datos['codigo_bibupem'] = $codigoGenerado;
        }

        // 4. Guardamos en la base de datos
        \App\Models\Material::create($datos);

        return redirect('/materiales')->with('success', '¡Material catalogado exitosamente! Código asignado: ' . $datos['codigo_bibupem']);
    }

    // Mostrar el formulario para editar un material existente
    public function edit($id)
    {
        $material = \App\Models\Material::findOrFail($id);
        return view('materiales.edit', compact('material'));
    }

    // Guardar los cambios editados en la base de datos
    public function update(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'stock_fisico' => 'required|integer|min:0',
        ]);

        $material = \App\Models\Material::findOrFail($id);
        
        // Actualizamos el libro con lo que sea que traiga el formulario (incluyendo si corrigieron el código)
        $material->update($request->all());

        return redirect('/materiales')->with('success', '¡El material ha sido actualizado y corregido correctamente!');
    }
    
    // Recibe el archivo Excel y lo manda a importar
    // Recibe el archivo Excel y lo manda a importar
    public function importar(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'documento_excel' => 'required|mimes:xlsx,xls,csv,txt'
        ]);

        try {
            Excel::import(new MaterialesImport, $request->file('documento_excel'));
            return back()->with('success', '¡Catálogo importado masivamente con éxito!');
        } catch (\Exception $e) {
            // 1. Guardar el error técnico en el archivo de logs (storage/logs/laravel.log)
            \Illuminate\Support\Facades\Log::error('Error de importación masiva: ' . $e->getMessage());

            // 2. Retornar alerta segura para la interfaz del administrador
            return back()->withErrors(['error' => 'Hubo un problema al procesar el archivo. Verifica que las columnas coincidan con el formato requerido.']);
        }
    }

    // Eliminar un material de la base de datos
    public function destroy($id)
    {
        $material = \App\Models\Material::findOrFail($id);
        $material->delete();

        return redirect('/materiales')->with('success', '¡El material ha sido eliminado correctamente del catálogo!');
    }
}