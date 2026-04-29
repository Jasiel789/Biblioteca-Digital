<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Agregamos esta importación

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cambiamos la función global por Auth:: para que Intelephense no se queje
        if (Auth::check() && Auth::user()->rol === 'Administrador') {
            return $next($request);
        }

        // Si es alumno e intenta entrar a una URL de admin, le mostramos error de acceso
        abort(403, 'Acceso Denegado. Esta área es exclusiva para Administradores de la Biblioteca.');
    }
}