<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Portal | Biblioteca</title>
    <style>
        :root {
            --primary: #311042;
            --primary-light: #4a1a63;
            --accent: #f59e0b;
            --success: #166534;
            --danger: #b91c1c;
            --bg: #f1f5f9;
        }

        body { 
            margin: 0; 
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; 
            background-color: var(--bg); 
            color: #1e293b; 
        }
        
        /* Barra de Navegación */
        .navbar { 
            background: var(--primary); 
            padding: 0 40px; 
            height: 70px;
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            color: white; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
        }
        .nav-logo { 
            font-size: 22px; 
            font-weight: 900; 
            letter-spacing: -0.5px; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .nav-links { display: flex; gap: 25px; align-items: center; }
        .nav-link { 
            color: #cbd5e1; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 600; 
            transition: 0.3s;
            padding: 8px 0;
            border-bottom: 2px solid transparent;
        }
        .nav-link:hover, .nav-link.active { 
            color: white; 
            border-bottom: 2px solid var(--accent);
        }
        .btn-logout { 
            background-color: #e51d38; 
            color: white; 
            padding: 10px 22px; 
            border-radius: 12px; 
            text-decoration: none; 
            font-size: 13px; 
            font-weight: 700; 
            transition: 0.3s; 
        }
        .btn-logout:hover { 
            background-color: #ff2e4d; 
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(229, 29, 56, 0.3);
        }

        /* Contenedor Principal */
        .container { max-width: 1200px; margin: 40px auto; padding: 0 30px; }
        
        /* Sección de Bienvenida */
        .welcome-section { 
            background: white; 
            padding: 35px; 
            border-radius: 20px; 
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); 
            margin-bottom: 35px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border-left: 8px solid var(--accent); 
        }
        .welcome-text h1 { margin: 0; color: var(--primary); font-size: 32px; font-weight: 800; }
        .welcome-text p { margin: 8px 0 0 0; color: #64748b; font-size: 16px; }
        .matricula-tag {
            background: #f8fafc;
            padding: 4px 12px;
            border-radius: 6px;
            color: var(--primary);
            font-weight: 700;
            border: 1px solid #e2e8f0;
        }

        .btn-search { 
            background-color: var(--primary); 
            color: white; 
            padding: 15px 30px; 
            border-radius: 14px; 
            text-decoration: none; 
            font-weight: 700; 
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s; 
            box-shadow: 0 4px 12px rgba(49, 16, 66, 0.2);
        }
        .btn-search:hover { 
            background-color: var(--primary-light); 
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(49, 16, 66, 0.3);
        }
        
        /* Grid */
        .dashboard-grid { display: grid; grid-template-columns: 1.8fr 1.2fr; gap: 30px; }
        
        /* Tarjetas */
        .card { 
            background: white; 
            border-radius: 20px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.02); 
            overflow: hidden; 
            border: 1px solid #e2e8f0; 
        }
        .card-header { 
            padding: 20px 25px; 
            background-color: #ffffff; 
            border-bottom: 1px solid #f1f5f9; 
            font-weight: 800; 
            color: var(--primary); 
            font-size: 17px; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .card-body { padding: 25px; }
        
        /* Items de Préstamo */
        .loan-item { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 20px; 
            border-radius: 15px;
            margin-bottom: 15px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            transition: 0.3s; 
        }
        .loan-item:hover { 
            background-color: #f1f5f9; 
            border-color: #cbd5e1;
            transform: scale(1.01);
        }
        .book-info .book-title { font-weight: 800; color: var(--primary); font-size: 16px; margin-bottom: 4px; }
        .book-info .due-date { font-size: 13px; color: #64748b; font-weight: 500; }
        
        /* Status */
        .badge { padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 800; text-transform: uppercase; }
        .badge-success { background-color: #dcfce7; color: var(--success); }
        .badge-danger { background-color: #fee2e2; color: var(--danger); }
        
        /* Estado de Cuenta */
        .debt-container { text-align: center; padding: 10px 0; }
        .debt-amount { font-size: 42px; font-weight: 900; color: var(--danger); margin: 10px 0; letter-spacing: -1px; }
        .fine-row {
            display: flex; 
            justify-content: space-between; 
            padding: 12px 0; 
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }
        .empty-state { text-align: center; padding: 40px 20px; color: #94a3b8; }
        .empty-icon { font-size: 50px; margin-bottom: 15px; display: block; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-logo">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="color: var(--accent)"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
            BIBLIOTECA DIGITAL
        </div>
        <div class="nav-links">
            <a href="/mi-portal" class="nav-link active">Mi Panel</a>
            <a href="/catalogo-publico" class="nav-link">Explorar Catálogo</a>
            <a href="/logout" class="btn-logout">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-section">
            <div class="welcome-text">
                <h1>¡Hola, {{ $user->name }}!</h1>
                <p>Matrícula: <span class="matricula-tag">{{ $user->matricula }}</span> | Rol: <strong>{{ $user->rol }}</strong></p>
            </div>
            <div>
                <a href="/catalogo-publico" class="btn-search">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    Buscar Libros
                </a>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="card">
                <div class="card-header">
                    Mis Préstamos Activos ({{ $misPrestamos->count() }})
                </div>
                <div class="card-body">
                    @forelse($misPrestamos as $prestamo)
                        @php
                            $fechaLimite = \Carbon\Carbon::parse($prestamo->fecha_limite);
                            $estaVencido = $fechaLimite->isPast() && !$fechaLimite->isToday();
                        @endphp
                        
                        <div class="loan-item">
                            <div class="book-info">
                                <div class="book-title">{{ $prestamo->material->titulo ?? 'Material' }}</div>
                                <div class="due-date">Solicitado: {{ \Carbon\Carbon::parse($prestamo->created_at)->format('d/m/Y') }}</div>
                            </div>
                            <div style="text-align: right;">
                                @if($estaVencido)
                                    <span class="badge badge-danger">Vencido</span>
                                    <div style="color: var(--danger); font-size: 12px; margin-top: 6px; font-weight: 700;">Límite: {{ $fechaLimite->format('d/m/Y') }}</div>
                                @else
                                    <span class="badge badge-success">En tiempo</span>
                                    <div style="color: #64748b; font-size: 12px; margin-top: 6px; font-weight: 600;">Devolver: {{ $fechaLimite->format('d/m/Y') }}</div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <span class="empty-icon">📖</span>
                            No tienes libros prestados actualmente.<br>
                            Usa el buscador para solicitar material.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <div class="card-header" style="border-bottom: 2px solid #fee2e2;">
                    Estado de Cuenta
                </div>
                <div class="card-body">
                    @php $totalDeuda = collect($misMultas)->sum('monto'); @endphp

                    @if($totalDeuda > 0)
                        <div class="debt-container">
                            <div style="font-size: 14px; font-weight: 600; color: #64748b; text-transform: uppercase;">Saldo Pendiente</div>
                            <div class="debt-amount">${{ number_format($totalDeuda, 2) }}</div>
                            <div style="background: #fff1f2; color: #be123c; padding: 10px; border-radius: 10px; font-size: 12px; font-weight: 600; margin-bottom: 20px;">
                                Debes liquidar este saldo en ventanilla para realizar nuevos préstamos.
                            </div>
                        </div>
                        
                        <div style="margin-top: 20px;">
                            <div style="font-weight: 800; font-size: 13px; color: var(--primary); margin-bottom: 10px; text-transform: uppercase;">Detalle de cargos:</div>
                            @foreach($misMultas as $multa)
                                <div class="fine-row">
                                    <span style="color: #475569;">{{ $multa->motivo }}</span>
                                    <span style="font-weight: 700; color: var(--danger);">${{ number_format($multa->monto, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div style="background: #f0fdf4; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto;">
                                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#166534" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <h3 style="color: var(--success); margin: 0; font-size: 20px; font-weight: 800;">¡Todo en orden!</h3>
                            <p style="color: #64748b; font-size: 14px; margin-top: 8px;">No tienes multas ni adeudos pendientes.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</body>
</html>