@extends('layouts.admin')

@section('contenido')
    <div style="background-color: white; border-radius: 16px; padding: 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(0,0,0,0.03); border-left: 8px solid #311042; margin-bottom: 25px;">
        <div>
            <h2 style="margin: 0; color: #0f172a; font-size: 24px; font-weight: 800;">Centro de Reportes y Estadísticas</h2>
            <p style="margin: 8px 0 0 0; color: #64748b; font-size: 14px;">Selecciona un módulo para visualizar los datos y exportar los documentos oficiales.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <a href="?tipo=inventario&periodo={{ $periodo ?? 'este_mes' }}&orden={{ $orden ?? 'recientes' }}" style="text-decoration: none; color: inherit;">
            <div style="background: {{ ($tipo ?? '') == 'inventario' ? '#eff6ff' : 'white' }}; border-radius: 12px; border: {{ ($tipo ?? '') == 'inventario' ? '2px solid #3b82f6' : '1px solid #e2e8f0' }}; box-shadow: 0 4px 6px rgba(0,0,0,0.02); overflow: hidden; transition: 0.2s; cursor: pointer; height: 100%;">
                <div style="background-color: #3b82f6; height: 4px; width: 100%;"></div>
                <div style="padding: 20px;">
                    <h3 style="margin: 0 0 5px 0; color: #1e293b; font-size: 15px; font-weight: 800;">Inventario Físico</h3>
                    <p style="color: #64748b; font-size: 12px; margin: 0;">Catálogo y stock de materiales.</p>
                </div>
            </div>
        </a>

        <a href="?tipo=prestamos&periodo={{ $periodo ?? 'este_mes' }}" style="text-decoration: none; color: inherit;">
            <div style="background: {{ ($tipo ?? '') == 'prestamos' ? '#ecfdf5' : 'white' }}; border-radius: 12px; border: {{ ($tipo ?? '') == 'prestamos' ? '2px solid #10b981' : '1px solid #e2e8f0' }}; box-shadow: 0 4px 6px rgba(0,0,0,0.02); overflow: hidden; transition: 0.2s; cursor: pointer; height: 100%;">
                <div style="background-color: #10b981; height: 4px; width: 100%;"></div>
                <div style="padding: 20px;">
                    <h3 style="margin: 0 0 5px 0; color: #1e293b; font-size: 15px; font-weight: 800;">Histórico de Préstamos</h3>
                    <p style="color: #64748b; font-size: 12px; margin: 0;">Registro de movimientos.</p>
                </div>
            </div>
        </a>

        <a href="?tipo=cobranza&periodo={{ $periodo ?? 'este_mes' }}" style="text-decoration: none; color: inherit;">
            <div style="background: {{ ($tipo ?? '') == 'cobranza' ? '#fffbeb' : 'white' }}; border-radius: 12px; border: {{ ($tipo ?? '') == 'cobranza' ? '2px solid #f59e0b' : '1px solid #e2e8f0' }}; box-shadow: 0 4px 6px rgba(0,0,0,0.02); overflow: hidden; transition: 0.2s; cursor: pointer; height: 100%;">
                <div style="background-color: #f59e0b; height: 4px; width: 100%;"></div>
                <div style="padding: 20px;">
                    <h3 style="margin: 0 0 5px 0; color: #1e293b; font-size: 15px; font-weight: 800;">Cobranza (Ingresos)</h3>
                    <p style="color: #64748b; font-size: 12px; margin: 0;">Multas pagadas por alumnos.</p>
                </div>
            </div>
        </a>

        <a href="?tipo=lista_negra&periodo={{ $periodo ?? 'este_mes' }}" style="text-decoration: none; color: inherit;">
            <div style="background: {{ ($tipo ?? '') == 'lista_negra' ? '#fef2f2' : 'white' }}; border-radius: 12px; border: {{ ($tipo ?? '') == 'lista_negra' ? '2px solid #e51d38' : '1px solid #e2e8f0' }}; box-shadow: 0 4px 6px rgba(0,0,0,0.02); overflow: hidden; transition: 0.2s; cursor: pointer; height: 100%;">
                <div style="background-color: #e51d38; height: 4px; width: 100%;"></div>
                <div style="padding: 20px;">
                    <h3 style="margin: 0 0 5px 0; color: #1e293b; font-size: 15px; font-weight: 800;">Lista Negra (Adeudos)</h3>
                    <p style="color: #64748b; font-size: 12px; margin: 0;">Alumnos con adeudos activos.</p>
                </div>
            </div>
        </a>
    </div>

    @if(isset($tipo) && $tipo != '')
        <div style="background: white; padding: 25px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
            
            <div style="background-color: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                
                <form method="GET" action="/reportes" style="margin: 0; display: flex; align-items: center; gap: 15px; flex-wrap: wrap; flex: 1;">
                    <input type="hidden" name="tipo" value="{{ $tipo }}">
                    
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-weight: 800; color: #475569; font-size: 13px;">Periodo:</span>
                        <select name="periodo" onchange="this.form.submit()" style="padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: white; cursor: pointer; outline: none;">
                            <option value="este_mes" {{ $periodo == 'este_mes' ? 'selected' : '' }}>Mes actual</option>
                            <option value="mes_pasado" {{ $periodo == 'mes_pasado' ? 'selected' : '' }}>Mes Pasado</option>
                            <option value="cuatrimestre" {{ $periodo == 'cuatrimestre' ? 'selected' : '' }}>Cuatrimestre Actual</option>
                            <option value="todo" {{ $periodo == 'todo' ? 'selected' : '' }}>Histórico Completo</option>
                        </select>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-weight: 800; color: #475569; font-size: 13px;">Orden:</span>
                        <select name="orden" onchange="this.form.submit()" style="padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: white; cursor: pointer; outline: none;">
                            <option value="recientes" {{ ($orden ?? 'recientes') == 'recientes' ? 'selected' : '' }}>Más Recientes Primero</option>
                            <option value="antiguos" {{ ($orden ?? 'recientes') == 'antiguos' ? 'selected' : '' }}>Más Antiguos Primero</option>
                        </select>
                    </div>

                    @if(in_array($tipo, ['prestamos', 'cobranza', 'lista_negra']))
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-weight: 800; color: #475569; font-size: 13px;">Carrera:</span>
                            <select name="carrera" onchange="this.form.submit()" style="padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: white; cursor: pointer; outline: none;">
                                <option value="">Todas las Carreras</option>
                                <option value="IIN" {{ request('carrera') == 'IIN' ? 'selected' : '' }}>Ing. Industrial (IIN)</option>
                                <option value="IFI" {{ request('carrera') == 'IFI' ? 'selected' : '' }}>Ing. Financiera (IFI)</option>
                                <option value="LAD" {{ request('carrera') == 'LAD' ? 'selected' : '' }}>Lic. Administración (LAD)</option>
                                <option value="IID" {{ request('carrera') == 'IID' ? 'selected' : '' }}>Ing. Tecnologías (IID)</option>
                                <option value="ISE" {{ request('carrera') == 'ISE' ? 'selected' : '' }}>Ing. Sistemas (ISE)</option>
                                <option value="IBT" {{ request('carrera') == 'IBT' ? 'selected' : '' }}>Ing. Biotecnología (IBT)</option>
                                <option value="IAS" {{ request('carrera') == 'IAS' ? 'selected' : '' }}>Ing. Ambiental (IAS)</option>
                            </select>
                        </div>
                    @endif
                </form>

                <div style="display: flex; gap: 10px;">
                    <a href="/reportes/exportar/excel/{{ $tipo }}?periodo={{ $periodo }}&orden={{ $orden ?? 'recientes' }}&carrera={{ request('carrera') }}" style="background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 10px 18px; border-radius: 8px; font-size: 13px; font-weight: 800; cursor: pointer; text-decoration: none; transition: 0.2s;" onmouseover="this.style.backgroundColor='#dcfce7'" onmouseout="this.style.backgroundColor='#f0fdf4'">
                        Exportar a Excel
                    </a>
                    
                    <a href="/reportes/exportar/pdf/{{ $tipo }}?periodo={{ $periodo }}&orden={{ $orden ?? 'recientes' }}&carrera={{ request('carrera') }}" target="_blank" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; padding: 10px 18px; border-radius: 8px; font-size: 13px; font-weight: 800; cursor: pointer; text-decoration: none; transition: 0.2s;" onmouseover="this.style.backgroundColor='#fee2e2'" onmouseout="this.style.backgroundColor='#fef2f2'">
                        Exportar a PDF
                    </a>
                </div>
            </div>

            <h3 style="color: #0f172a; font-size: 16px; margin-top: 0; font-weight: 800;">Vista Previa de Datos ({{ collect($datosPreview)->count() }} registros encontrados)</h3>
            
            <div style="width: 100%; overflow-x: hidden;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <tr>
                            @if($tipo == 'inventario')
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">ID</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Cód. BIBUPEM</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Título</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Autor</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Formato</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Categoría</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Stock Físico</th>
                            
                            @elseif($tipo == 'prestamos')
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Fecha</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Matrícula</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Usuario</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Carrera</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Cód. BIBUPEM</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Material</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Estatus</th>
                            
                            @elseif($tipo == 'cobranza')
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Fecha</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Folio</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Matrícula</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Usuario</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Carrera</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Ingreso</th>
                            
                            @elseif($tipo == 'lista_negra')
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Matrícula</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Usuario Moroso</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Carrera</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Multas Pendientes</th>
                                <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Deuda Total</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($datosPreview as $item)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                                
                                @if($tipo == 'inventario')
                                    <td style="padding: 15px 10px; font-size: 13px; color: #64748b;">{{ $item->id }}</td>
                                    <td style="padding: 15px 10px; font-size: 13px; font-weight: 800; color: #0f766e;">{{ $item->codigo_bibupem ?? 'S/C' }}</td>
                                    <td style="padding: 15px 10px; font-size: 13px; font-weight: 800; color: #1e293b;">{{ $item->titulo }}</td>
                                    <td style="padding: 15px 10px; font-size: 12px; color: #475569;">{{ $item->autor ?? 'N/A' }}</td>
                                    <td style="padding: 15px 10px;"><span style="background-color: #f1f5f9; padding: 4px 8px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 11px; font-weight: bold; color: #475569;">{{ $item->clasificacion ?? 'N/A' }}</span></td>
                                    <td style="padding: 15px 10px; font-size: 13px; color: #475569;">{{ $item->categoria ?? 'General' }}</td>
                                    <td style="padding: 15px 10px;">
                                        @if($item->stock_fisico > 0)
                                            <span style="color: #166534; background-color: #dcfce7; padding: 4px 10px; font-size: 12px; font-weight: 800; border-radius: 12px; border: 1px solid #bbf7d0;">{{ $item->stock_fisico }}</span>
                                        @else
                                            <span style="color: #b91c1c; background-color: #fee2e2; padding: 4px 10px; font-size: 12px; font-weight: 800; border-radius: 12px; border: 1px solid #fecaca;">{{ $item->stock_fisico }}</span>
                                        @endif
                                    </td>
                                
                                @elseif($tipo == 'prestamos')
                                    <td style="padding: 15px 10px; font-size: 13px; color: #64748b;">{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td style="padding: 15px 10px; font-size: 13px; font-weight: 800; color: #0f766e;">{{ $item->user->matricula ?? 'S/M' }}</td>
                                    <td style="padding: 15px 10px;">
                                        <div style="font-weight: 800; font-size: 13px; color: #1e293b;">{{ $item->user->name ?? 'Usuario Desconocido' }}</div>
                                        <div style="font-size: 12px; color: #64748b; margin-top: 4px; word-break: break-all;">{{ $item->user->email ?? 'Sin correo' }}</div>
                                    </td>
                                    <td style="padding: 15px 10px;">
                                        @if(($item->user->rol ?? '') == 'Profesor' || empty($item->user->carrera))
                                            <span style="color: #94a3b8; font-style: italic; font-size: 12px;">N/A</span>
                                        @else
                                            <span style="background-color: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: bold; border: 1px solid #bae6fd; display: inline-block;">
                                                {{ $item->user->carrera }}
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 15px 10px; font-size: 13px; font-weight: 800; color: #d97706;">{{ $item->material->codigo_bibupem ?? 'S/C' }}</td>
                                    <td style="padding: 15px 10px; font-size: 13px; font-weight: 800; color: #475569;">{{ $item->material->titulo ?? 'N/A' }}</td>
                                    <td style="padding: 15px 10px;">
                                        @if($item->estado == 'Activo')
                                            <span style="background-color: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 50px; font-size: 11px; font-weight: bold; border: 1px solid #bbf7d0;">Activo</span>
                                        @else
                                            <span style="background-color: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 50px; font-size: 11px; font-weight: bold; border: 1px solid #e2e8f0;">Devuelto</span>
                                        @endif
                                    </td>
                                
                                @elseif($tipo == 'cobranza')
                                    <td style="padding: 15px 10px; font-size: 13px; color: #64748b;">{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                    <td style="padding: 15px 10px; font-size: 13px; font-weight: 800; color: #475569;">#000{{ $item->id }}</td>
                                    <td style="padding: 15px 10px; font-size: 13px; font-weight: 800; color: #0f766e;">{{ $item->user->matricula ?? 'S/M' }}</td>
                                    <td style="padding: 15px 10px;">
                                        <div style="font-weight: 800; font-size: 13px; color: #1e293b;">{{ $item->user->name ?? 'Usuario Desconocido' }}</div>
                                        <div style="font-size: 12px; color: #64748b; margin-top: 4px; word-break: break-all;">{{ $item->user->email ?? 'Sin correo' }}</div>
                                    </td>
                                    <td style="padding: 15px 10px;">
                                        @if(($item->user->rol ?? '') == 'Profesor' || empty($item->user->carrera))
                                            <span style="color: #94a3b8; font-style: italic; font-size: 12px;">N/A</span>
                                        @else
                                            <span style="background-color: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: bold; border: 1px solid #bae6fd; display: inline-block;">
                                                {{ $item->user->carrera }}
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 15px 10px; color: #166534; font-weight: 800; font-size: 14px;">${{ number_format($item->monto, 2) }}</td>
                                
                                @elseif($tipo == 'lista_negra')
                                    <td style="padding: 15px 10px; font-size: 13px; font-weight: 800; color: #0f766e;">{{ $item->matricula }}</td>
                                    <td style="padding: 15px 10px;">
                                        <div style="font-weight: 800; font-size: 13px; color: #1e293b;">{{ $item->name }}</div>
                                        <div style="font-size: 12px; color: #64748b; margin-top: 4px; word-break: break-all;">{{ $item->email ?? 'Sin correo' }}</div>
                                    </td>
                                    <td style="padding: 15px 10px;">
                                        @if(($item->rol ?? '') == 'Profesor' || empty($item->carrera))
                                            <span style="color: #94a3b8; font-style: italic; font-size: 12px;">N/A</span>
                                        @else
                                            <span style="background-color: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: bold; border: 1px solid #bae6fd; display: inline-block;">
                                                {{ $item->carrera }}
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 15px 10px;">
                                        <ul style="margin:0; padding-left:15px; color: #475569; font-size: 12px;">
                                            @foreach($item->multas as $multa)
                                                <li style="margin-bottom: 4px;">{{ $multa->motivo }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td style="padding: 15px 10px; color: #b91c1c; font-weight: 800; font-size: 14px;">${{ number_format($item->multas->sum('monto'), 2) }}</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 40px; text-align: center; color: #94a3b8; font-size: 14px;">
                                    No hay datos registrados con estos filtros.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div style="background-color: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 16px; padding: 50px; text-align: center;">
            <h3 style="color: #334155; margin: 0 0 10px 0; font-weight: 800;">Selecciona un reporte en la parte superior</h3>
            <p style="color: #64748b; font-size: 14px; margin: 0;">Haz clic en cualquiera de las tarjetas para visualizar la información y habilitar las opciones de exportación.</p>
        </div>
    @endif
@endsection