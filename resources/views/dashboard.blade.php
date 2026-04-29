@extends('layouts.admin')

@section('contenido')
    <style>
        .hover-card { transition: all 0.3s ease; }
        .hover-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important; }
        .table-row-hover:hover { background-color: #f8fafc; }
    </style>

    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
        <div>
            <h2 style="margin: 0; color: #311042; font-size: 28px; font-weight: 900; letter-spacing: -0.5px;">Panel de Administración</h2>
            <p style="margin: 5px 0 0 0; color: #64748b; font-size: 14px;">Gestión y monitoreo de la biblioteca digital.</p>
        </div>
        
        @if(isset($filtro) && $filtro)
            <a href="/dashboard" style="background-color: #f1f5f9; color: #475569; padding: 8px 15px; text-decoration: none; border-radius: 6px; font-size: 13px; font-weight: bold; border: 1px solid #cbd5e1; transition: 0.2s;" onmouseover="this.style.backgroundColor='#e2e8f0';" onmouseout="this.style.backgroundColor='#f1f5f9';">Quitar Filtros</a>
        @endif
    </div>

    <div style="display: flex; gap: 20px; margin-bottom: 40px;">
        
        <a href="/dashboard?filtro=activos" class="hover-card" style="flex: 1; text-decoration: none; color: inherit; display: block; background: white; padding: 25px; border-radius: 16px; border: 1px solid #a855f7; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div style="background-color: #f3e8ff; padding: 15px; border-radius: 12px; color: #9333ea; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                </div>
                <div>
                    <h4 style="margin: 0; color: #64748b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Préstamos Activos</h4>
                    <p style="font-size: 32px; font-weight: 900; margin: 5px 0 0 0; color: #311042;">{{ $prestamosActivos ?? 0 }}</p>
                </div>
            </div>
        </a>

        <a href="/dashboard?filtro=atrasados" class="hover-card" style="flex: 1; text-decoration: none; color: inherit; display: block; background: white; padding: 25px; border-radius: 16px; border: 1px solid #ef4444; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div style="background-color: #fee2e2; padding: 15px; border-radius: 12px; color: #ef4444; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <h4 style="margin: 0; color: #64748b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Atrasados</h4>
                    <p style="font-size: 32px; font-weight: 900; margin: 5px 0 0 0; color: #ef4444;">{{ $devolucionesPendientes ?? 0 }}</p>
                </div>
            </div>
        </a>

        <a href="/dashboard?filtro=stock" class="hover-card" style="flex: 1; text-decoration: none; color: inherit; display: block; background: white; padding: 25px; border-radius: 16px; border: 1px solid #f59e0b; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div style="background-color: #fef3c7; padding: 15px; border-radius: 12px; color: #f59e0b; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div>
                    <h4 style="margin: 0; color: #64748b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Stock Bajo</h4>
                    <p style="font-size: 32px; font-weight: 900; margin: 5px 0 0 0; color: #f59e0b;">{{ $stockBajo ?? 0 }}</p>
                </div>
            </div>
        </a>

    </div>

    <div>
        <h3 style="margin-top: 0; color: #311042; font-size: 18px; margin-bottom: 20px;">
            @if(isset($filtro) && $filtro == 'activos') 🟢 Mostrando Préstamos Activos
            @elseif(isset($filtro) && $filtro == 'atrasados') 🔴 Mostrando Devoluciones Atrasadas
            @elseif(isset($filtro) && $filtro == 'stock') 🟠 Mostrando Materiales en Stock Bajo
            @else Actividad Reciente 
            @endif
        </h3>
        
        @if(isset($filtro) && $filtro == 'stock')
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr>
                        <th style="padding: 15px 12px; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase;">ID</th>
                        <th style="padding: 15px 12px; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase;">Cód. BIBUPEM</th>
                        <th style="padding: 15px 12px; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase;">Título del Material</th>
                        <th style="padding: 15px 12px; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase;">Autor</th>
                        <th style="padding: 15px 12px; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase;">Stock Actual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datosFiltro ?? [] as $libro)
                        <tr class="table-row-hover" style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.2s;">
                            <td style="padding: 15px 12px; font-size: 13px; color: #64748b;">{{ $libro->id }}</td>
                            <td style="padding: 15px 12px; font-size: 13px; font-weight: bold; color: #0f766e;">{{ $libro->codigo_bibupem ?? 'S/C' }}</td>
                            <td style="padding: 15px 12px; font-size: 14px; font-weight: bold; color: #311042;">{{ $libro->titulo }}</td>
                            <td style="padding: 15px 12px; font-size: 14px; color: #475569;">{{ $libro->autor }}</td>
                            <td style="padding: 15px 12px;">
                                @if($libro->stock_fisico == 0)
                                    <span style="background-color: #fee2e2; color: #991b1b; padding: 5px 12px; border-radius: 50px; font-size: 12px; font-weight: 700; border: 1px solid #fecaca;">Agotado (0)</span>
                                @else
                                    <span style="background-color: #fef3c7; color: #b45309; padding: 5px 12px; border-radius: 50px; font-size: 12px; font-weight: 700; border: 1px solid #fde68a;">Quedan: {{ $libro->stock_fisico }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 20px 0;">
                                <div style="background-color: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 40px; text-align: center; color: #94a3b8; font-size: 14px;">
                                    ✅ ¡Excelente! Tienes un buen nivel de inventario en todos los materiales.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        @else
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr>
                        <th style="padding: 15px 12px 15px 0; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase;">Fecha y Hora</th>
                        <th style="padding: 15px 12px; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase;">Matrícula</th>
                        <th style="padding: 15px 12px; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase;">Usuario</th>
                        <th style="padding: 15px 12px; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase;">Carrera</th>
                        <th style="padding: 15px 12px; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase;">Cód. BIBUPEM</th>
                        <th style="padding: 15px 12px; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase;">Material Prestado</th>
                        <th style="padding: 15px 12px; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase;">Estado Actual</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $datosAMostrar = (isset($filtro) && $filtro && isset($datosFiltro)) ? $datosFiltro : ($actividad ?? []);
                    @endphp

                    @forelse($datosAMostrar as $item)
                        <tr class="table-row-hover" style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.2s;">
                            
                            <td style="padding: 15px 12px 15px 0; font-size: 13px; color: #64748b;">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y - H:i') }}
                            </td>
                            
                            <td style="padding: 15px 12px; font-size: 13px; font-weight: bold; color: #0f766e;">
                                {{ $item->user->matricula ?? 'S/M' }}
                            </td>
                            
                            <td style="padding: 15px 12px;">
                                <div style="font-size: 14px; font-weight: bold; color: #311042;">{{ $item->user->name ?? 'Usuario Desconocido' }}</div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 3px;">{{ $item->user->email ?? 'Sin Correo' }}</div>
                            </td>

                            <td style="padding: 15px 12px;">
                                @if(($item->user->rol ?? '') == 'Profesor' || empty($item->user->carrera))
                                    <span style="color: #94a3b8; font-style: italic; font-size: 12px;">N/A</span>
                                @else
                                    <span style="background-color: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; border: 1px solid #bae6fd;">
                                        {{ $item->user->carrera }}
                                    </span>
                                @endif
                            </td>

                            <td style="padding: 15px 12px; font-size: 13px; font-weight: bold; color: #d97706;">
                                {{ $item->material->codigo_bibupem ?? 'S/C' }}
                            </td>
                            
                            <td style="padding: 15px 12px; font-size: 14px; color: #333;">
                                {{ $item->material->titulo ?? 'N/A' }}
                            </td>
                            
                            <td style="padding: 15px 12px;">
                                @if($item->estado == 'Activo')
                                    <span style="background-color: #dcfce7; color: #166534; padding: 5px 12px; border-radius: 50px; font-size: 12px; font-weight: 700; border: 1px solid #bbf7d0;">Activo</span>
                                @else
                                    <span style="background-color: #f1f5f9; color: #475569; padding: 5px 12px; border-radius: 50px; font-size: 12px; font-weight: 700;">Devuelto</span>
                                @endif
                            </td>
                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 20px 0;">
                                <div style="background-color: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 40px; text-align: center; color: #94a3b8; font-size: 14px;">
                                    No hay registros disponibles.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
@endsection