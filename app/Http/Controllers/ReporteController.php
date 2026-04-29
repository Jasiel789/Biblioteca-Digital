<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Material;
use App\Models\Prestamo;
use App\Models\Multa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReporteController extends Controller
{
    // 1. Mostrar la página principal
    public function index(Request $request)
    {
        $tipo = $request->query('tipo');
        $periodo = $request->query('periodo', 'este_mes');
        $orden = $request->query('orden', 'recientes'); 
        $carrera = $request->query('carrera'); // NUEVO FILTRO DE CARRERA
        
        $datosPreview = collect();
        if ($tipo) {
            $rango = $this->obtenerRangoFechas($periodo);
            // Pasamos el nuevo parámetro de carrera
            $datosPreview = $this->obtenerDatos($tipo, $rango[0], $rango[1], $orden, $carrera);
        }

        return view('reportes.index', compact('tipo', 'periodo', 'datosPreview', 'orden'));
    }

    // 2. Procesar las descargas (PDF o Excel)
    public function exportar($formato, $tipo, Request $request)
    {
        $periodo = $request->query('periodo', 'este_mes');
        $orden = $request->query('orden', 'recientes');
        $carrera = $request->query('carrera'); // NUEVO FILTRO DE CARRERA
        $rango = $this->obtenerRangoFechas($periodo);
        $datos = $this->obtenerDatos($tipo, $rango[0], $rango[1], $orden, $carrera);

        if ($formato == 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf_plantilla', compact('tipo', 'periodo', 'datos', 'rango'));
            return $pdf->stream("Reporte_{$tipo}_UPEMOR.pdf");
        }

        if ($formato == 'excel') {
            $fileName = "Reporte_{$tipo}_" . date('Y_m_d') . ".csv";
            
            $headers = [
                "Content-type"        => "text/csv; charset=UTF-8",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];

            $callback = function() use($datos, $tipo) {
                $file = fopen('php://output', 'w');
                // Truco para que Excel lea los acentos (BOM UTF-8)
                fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); 

                if ($tipo == 'inventario') {
                    // ACTUALIZADO CON AUTOR
                    fputcsv($file, ['ID', 'Cód. BIBUPEM', 'Título', 'Autor', 'Formato', 'Categoría', 'Stock Físico']);
                    foreach ($datos as $row) {
                        fputcsv($file, [$row->id, $row->codigo_bibupem ?? 'S/C', $row->titulo, $row->autor ?? 'N/A', $row->clasificacion ?? 'N/A', $row->categoria ?? 'General', $row->stock_fisico]);
                    }
                } elseif ($tipo == 'prestamos') {
                    // ACTUALIZADO CON MATRICULA, CORREO Y CARRERA
                    fputcsv($file, ['Fecha', 'Matrícula', 'Usuario', 'Correo', 'Carrera', 'Cód. BIBUPEM', 'Material Prestado', 'Estado']);
                    foreach ($datos as $row) {
                        $carrera = ($row->user->rol ?? '') == 'Profesor' ? 'N/A' : ($row->user->carrera ?? 'N/A');
                        fputcsv($file, [$row->created_at->format('d/m/Y'), $row->user->matricula ?? 'S/M', $row->user->name ?? '', $row->user->email ?? '', $carrera, $row->material->codigo_bibupem ?? 'S/C', $row->material->titulo ?? '', $row->estado]);
                    }
                } elseif ($tipo == 'cobranza') {
                    // ACTUALIZADO CON MATRICULA, CORREO Y CARRERA
                    fputcsv($file, ['Fecha Pago', 'Folio', 'Matrícula', 'Usuario', 'Correo', 'Carrera', 'Ingreso ($)']);
                    foreach ($datos as $row) {
                        $carrera = ($row->user->rol ?? '') == 'Profesor' ? 'N/A' : ($row->user->carrera ?? 'N/A');
                        fputcsv($file, [$row->updated_at->format('d/m/Y'), '#000'.$row->id, $row->user->matricula ?? 'S/M', $row->user->name ?? '', $row->user->email ?? '', $carrera, '$'.$row->monto]);
                    }
                } elseif ($tipo == 'lista_negra') {
                    // ACTUALIZADO CON CARRERA
                    fputcsv($file, ['Matrícula', 'Usuario Moroso', 'Correo', 'Carrera', 'Multas Pendientes', 'Deuda Total ($)']);
                    foreach ($datos as $row) {
                        $carrera = ($row->rol ?? '') == 'Profesor' ? 'N/A' : ($row->carrera ?? 'N/A');
                        fputcsv($file, [$row->matricula, $row->name, $row->email ?? '', $carrera, $row->multas->count(), '$'.$row->multas->sum('monto')]);
                    }
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }
    }

    private function obtenerRangoFechas($periodo)
    {
        $inicio = Carbon::now()->startOfMonth();
        $fin = Carbon::now()->endOfMonth();

        if ($periodo == 'mes_pasado') {
            $inicio = Carbon::now()->subMonth()->startOfMonth();
            $fin = Carbon::now()->subMonth()->endOfMonth();
        } elseif ($periodo == 'cuatrimestre') {
            $inicio = Carbon::now()->subMonths(3)->startOfMonth();
        } elseif ($periodo == 'todo') {
            $inicio = Carbon::create(2000, 1, 1);
        }
        return [$inicio, $fin];
    }

    // ACTUALIZADA CON EL FILTRO DE CARRERA
    private function obtenerDatos($tipo, $inicio, $fin, $orden = 'recientes', $carrera = null)
    {
        if ($tipo == 'inventario') {
            $query = Material::query();
            if ($orden == 'antiguos') {
                $query->orderBy('id', 'asc');
            } else {
                $query->orderBy('id', 'desc');
            }
            return $query->get();
            
        } elseif ($tipo == 'prestamos') {
            $query = Prestamo::with(['user', 'material'])->whereBetween('created_at', [$inicio, $fin])->orderBy('created_at', 'desc');
            
            // Si el coordinador filtró por carrera, cruzamos la tabla de usuarios
            if ($carrera) {
                $query->whereHas('user', function($q) use ($carrera) {
                    $q->where('carrera', $carrera);
                });
            }
            return $query->get();

        } elseif ($tipo == 'cobranza') {
            $query = Multa::with(['user', 'prestamo.material'])->where('estatus', 'Pagado')->whereBetween('updated_at', [$inicio, $fin])->orderBy('updated_at', 'desc');
            
            if ($carrera) {
                $query->whereHas('user', function($q) use ($carrera) {
                    $q->where('carrera', $carrera);
                });
            }
            return $query->get();

        } elseif ($tipo == 'lista_negra') {
            $query = User::whereHas('multas', function($q) use ($inicio, $fin) {
                $q->where('estatus', 'Pendiente')->whereBetween('created_at', [$inicio, $fin]);
            })->with(['multas' => function($q) use ($inicio, $fin) {
                $q->where('estatus', 'Pendiente')->whereBetween('created_at', [$inicio, $fin]);
            }]);

            // Filtrado directo por carrera
            if ($carrera) {
                $query->where('carrera', $carrera);
            }

            return $query->get();
        }
        return collect();
    }
}