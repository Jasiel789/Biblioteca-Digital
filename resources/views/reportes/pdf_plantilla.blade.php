<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte - {{ ucfirst(str_replace('_', ' ', $tipo)) }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #311042;
            padding-bottom: 15px;
        }
        .title {
            color: #311042;
            font-size: 22px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        .subtitle {
            color: #64748b;
            font-size: 14px;
            margin-top: 5px;
        }
        .info-row {
            margin-bottom: 15px;
            font-size: 12px;
            color: #475569;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px; /* Letra más pequeña para que quepan todas las columnas nuevas */
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #f8fafc;
            color: #311042;
            font-weight: bold;
            text-transform: uppercase;
        }
        .correo-small {
            font-size: 9px;
            color: #64748b;
            display: block;
            margin-top: 2px;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 4px;
            background-color: #f1f5f9;
            color: #475569;
            font-weight: bold;
            font-size: 9px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="title">Biblioteca Digital</h1>
        <div class="subtitle">Reporte Oficial: {{ strtoupper(str_replace('_', ' ', $tipo)) }}</div>
    </div>

    <div class="info-row">
        <strong>Fecha de Generación:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }} <br>
        <strong>Periodo Analizado:</strong> {{ ucfirst(str_replace('_', ' ', $periodo)) }}
    </div>

    <table>
        <thead>
            <tr>
                @if($tipo == 'inventario')
                    <th>ID</th>
                    <th>Cód. BIBUPEM</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Formato</th>
                    <th>Categoría</th>
                    <th>Stock Físico</th>
                
                @elseif($tipo == 'prestamos')
                    <th>Fecha</th>
                    <th>Matrícula</th>
                    <th>Usuario / Correo</th>
                    <th>Carrera</th>
                    <th>Cód. BIBUPEM</th>
                    <th>Material Prestado</th>
                    <th>Estatus</th>
                
                @elseif($tipo == 'cobranza')
                    <th>Fecha de Pago</th>
                    <th>Folio</th>
                    <th>Matrícula</th>
                    <th>Usuario / Correo</th>
                    <th>Carrera</th>
                    <th>Ingreso ($)</th>
                
                @elseif($tipo == 'lista_negra')
                    <th>Matrícula</th>
                    <th>Usuario Moroso / Correo</th>
                    <th>Carrera</th>
                    <th>Multas Pendientes</th>
                    <th>Deuda Total ($)</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($datos as $item)
                <tr>
                    @if($tipo == 'inventario')
                        <td>{{ $item->id }}</td>
                        <td><strong>{{ $item->codigo_bibupem ?? 'S/C' }}</strong></td>
                        <td><strong>{{ $item->titulo }}</strong></td>
                        <td>{{ $item->autor ?? 'N/A' }}</td>
                        <td>{{ $item->clasificacion ?? 'N/A' }}</td>
                        <td>{{ $item->categoria ?? 'General' }}</td>
                        <td style="text-align: center;"><strong>{{ $item->stock_fisico }}</strong></td>
                    
                    @elseif($tipo == 'prestamos')
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        <td><strong>{{ $item->user->matricula ?? 'S/M' }}</strong></td>
                        <td>
                            <strong>{{ $item->user->name ?? 'Usuario Desconocido' }}</strong>
                            <span class="correo-small">{{ $item->user->email ?? 'Sin correo' }}</span>
                        </td>
                        <td>
                            @if(($item->user->rol ?? '') == 'Profesor' || empty($item->user->carrera))
                                N/A
                            @else
                                <span class="badge">{{ $item->user->carrera }}</span>
                            @endif
                        </td>
                        <td>{{ $item->material->codigo_bibupem ?? 'S/C' }}</td>
                        <td>{{ $item->material->titulo ?? 'N/A' }}</td>
                        <td>{{ $item->estado }}</td>
                    
                    @elseif($tipo == 'cobranza')
                        <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                        <td>#000{{ $item->id }}</td>
                        <td><strong>{{ $item->user->matricula ?? 'S/M' }}</strong></td>
                        <td>
                            <strong>{{ $item->user->name ?? 'Usuario Desconocido' }}</strong>
                            <span class="correo-small">{{ $item->user->email ?? 'Sin correo' }}</span>
                        </td>
                        <td>
                            @if(($item->user->rol ?? '') == 'Profesor' || empty($item->user->carrera))
                                N/A
                            @else
                                <span class="badge">{{ $item->user->carrera }}</span>
                            @endif
                        </td>
                        <td style="color: #166534; font-weight: bold;">${{ number_format($item->monto, 2) }}</td>
                    
                    @elseif($tipo == 'lista_negra')
                        <td><strong>{{ $item->matricula }}</strong></td>
                        <td>
                            <strong>{{ $item->name }}</strong>
                            <span class="correo-small">{{ $item->email ?? 'Sin correo' }}</span>
                        </td>
                        <td>
                            @if(($item->rol ?? '') == 'Profesor' || empty($item->carrera))
                                N/A
                            @else
                                <span class="badge">{{ $item->carrera }}</span>
                            @endif
                        </td>
                        <td>
                            <ul style="margin: 0; padding-left: 15px; font-size: 9px;">
                                @foreach($item->multas as $multa)
                                    <li>{{ $multa->motivo }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td style="color: #b91c1c; font-weight: bold;">${{ number_format($item->multas->sum('monto'), 2) }}</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #64748b;">
                        No hay datos registrados en este periodo con los filtros seleccionados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>