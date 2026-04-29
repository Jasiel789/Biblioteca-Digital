<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Portal | Biblioteca Digital</title>
    <style>
        body { margin: 0; font-family: 'Helvetica', 'Arial', sans-serif; background-color: #f8fafc; color: #333; }
        
        /* Barra de Navegación Superior */
        .navbar { background: linear-gradient(90deg, #311042 0%, #4a1a63 100%); padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; color: white; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .nav-logo { font-size: 20px; font-weight: 900; letter-spacing: 1px; display: flex; align-items: center; gap: 10px; }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-link { color: #cbd5e1; text-decoration: none; font-size: 14px; font-weight: bold; transition: 0.2s; }
        .nav-link:hover { color: white; }
        .btn-logout { background-color: #e51d38; color: white; padding: 8px 20px; border-radius: 50px; text-decoration: none; font-size: 13px; font-weight: bold; transition: 0.2s; }
        .btn-logout:hover { background-color: #c8162f; }

        /* Contenedor Principal */
        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        
        /* Bienvenida */
        .welcome-section { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; border-left: 5px solid #f59e0b; }
        .welcome-text h1 { margin: 0 0 5px 0; color: #311042; font-size: 24px; }
        .welcome-text p { margin: 0; color: #64748b; font-size: 15px; }
        
        /* Grid de Tarjetas */
        .dashboard-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; }
        
        /* Tarjetas (Cards) */
        .card { background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); overflow: hidden; border: 1px solid #e2e8f0; }
        .card-header { padding: 15px 20px; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; font-weight: bold; color: #1e293b; font-size: 16px; display: flex; align-items: center; gap: 8px; }
        .card-body { padding: 20px; }
        
        /* Listas de Préstamos */
        .loan-item { display: flex; justify-content: space-between; align-items: center; padding: 15px; border-bottom: 1px solid #f1f5f9; transition: 0.2s; }
        .loan-item:hover { background-color: #f8fafc; }
        .loan-item:last-child { border-bottom: none; }
        .book-title { font-weight: bold; color: #311042; font-size: 15px; margin-bottom: 5px; }
        .due-date { font-size: 12px; color: #64748b; }
        
        /* Etiquetas de Estatus */
        .badge-success { background-color: #dcfce7; color: #166534; padding: 5px 12px; border-radius: 50px; font-size: 11px; font-weight: bold; }
        .badge-danger { background-color: #fef2f2; color: #b91c1c; padding: 5px 12px; border-radius: 50px; font-size: 11px; font-weight: bold; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-logo">
            Biblioteca Digital
        </div>
        <div class="nav-links">
            <a href="/mi-portal" class="nav-link" style="color: white;">Mi Panel</a>
            <a href="/catalogo-publico" class="nav-link">Explorar Catálogo</a>
            <a href="/logout" class="btn-logout">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-section">
            <div class="welcome-text">
                <h1>¡Hola, {{ $user->name }}! 👋</h1>
                <p>Matrícula: <strong>{{ $user->matricula }}</strong> | Rol: {{ $user->rol }}</p>
            </div>
            <div>
                <a href="/catalogo-publico" style="background-color: #311042; color: white; padding: 12px 25px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block; transition: 0.2s;" onmouseover="this.style.backgroundColor='#4a1a63'" onmouseout="this.style.backgroundColor='#311042'">
                    🔍 Buscar Libros
                </a>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="card">
                <div class="card-header">
                    📖 Mis Préstamos Activos ({{ $misPrestamos->count() }})
                </div>
                <div class="card-body" style="padding: 0;">
                    @forelse($misPrestamos as $prestamo)
                        @php
                            // Calculamos si está vencido comparando con hoy
                            $fechaLimite = \Carbon\Carbon::parse($prestamo->fecha_limite);
                            $estaVencido = $fechaLimite->isPast() && !$fechaLimite->isToday();
                        @endphp
                        
                        <div class="loan-item">
                            <div>
                                <div class="book-title">{{ $prestamo->material->titulo ?? 'Material Desconocido' }}</div>
                                <div class="due-date">Prestado el: {{ \Carbon\Carbon::parse($prestamo->created_at)->format('d/m/Y') }}</div>
                            </div>
                            <div style="text-align: right;">
                                @if($estaVencido)
                                    <span class="badge-danger">Vencido</span>
                                    <div style="color: #b91c1c; font-size: 11px; margin-top: 5px; font-weight: bold;">Debió entregarse: {{ $fechaLimite->format('d/m/Y') }}</div>
                                @else
                                    <span class="badge-success">A tiempo</span>
                                    <div style="color: #64748b; font-size: 11px; margin-top: 5px;">Entregar antes de: {{ $fechaLimite->format('d/m/Y') }}</div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="padding: 30px; text-align: center; color: #94a3b8;">
                            <div style="font-size: 30px; margin-bottom: 10px;">🎒</div>
                            No tienes ningún libro prestado actualmente.<br>¡Anímate a explorar el catálogo!
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <div class="card-header" style="background-color: #fef2f2; color: #b91c1c; border-bottom-color: #fecaca;">
                    🚨 Estado de Cuenta
                </div>
                <div class="card-body">
                    @php
                        $totalDeuda = collect($misMultas)->sum('monto');
                    @endphp

                    @if($totalDeuda > 0)
                        <div style="text-align: center; margin-bottom: 20px;">
                            <div style="font-size: 13px; color: #64748b;">Adeudo Total Pendiente</div>
                            <div style="font-size: 32px; font-weight: 900; color: #b91c1c;">${{ number_format($totalDeuda, 2) }}</div>
                            <div style="font-size: 11px; color: #e51d38; margin-top: 5px;">No podrás solicitar más libros hasta liquidar en caja.</div>
                        </div>
                        
                        <div style="border-top: 1px dashed #cbd5e1; padding-top: 15px;">
                            <div style="font-weight: bold; font-size: 13px; margin-bottom: 10px;">Detalle de multas:</div>
                            @foreach($misMultas as $multa)
                                <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 8px; color: #475569;">
                                    <span>{{ $multa->motivo }}</span>
                                    <span style="font-weight: bold; color: #b91c1c;">${{ number_format($multa->monto, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 20px 0;">
                            <div style="font-size: 40px; margin-bottom: 10px;">✅</div>
                            <h3 style="color: #166534; margin: 0 0 5px 0; font-size: 18px;">¡Todo en orden!</h3>
                            <p style="color: #64748b; font-size: 13px; margin: 0;">No tienes multas ni adeudos pendientes en la biblioteca.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</body>
</html>