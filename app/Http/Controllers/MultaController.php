<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Multa;
// Esta es la línea clave para Laravel 11:
use Barryvdh\DomPDF\Facade\Pdf; 

class MultaController extends Controller
{
    public function generarFicha($id)
    {
        // Buscamos la multa con sus relaciones
        $multa = Multa::with(['user', 'prestamo.material'])->findOrFail($id);
        
        // Ahora cargamos la vista usando la clase que importamos arriba
        // Fíjate que 'Pdf' empieza con P mayúscula
        $pdf = Pdf::loadView('multas.ficha', compact('multa'));
        
        return $pdf->stream('Ficha_Pago_UPEMOR_'.$multa->user->matricula.'.pdf');
    }

    public function pagar($id)
    {
        $multa = Multa::findOrFail($id);
        $multa->estatus = 'Pagado';
        $multa->save();

        return back()->with('success', '¡El pago ha sido registrado correctamente!');
    }
}