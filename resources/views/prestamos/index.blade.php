@extends('layouts.admin')

@section('contenido')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Ajustes Premium para Select2 */
        .select2-container .select2-selection--single { height: 44px !important; border: 1px solid #e2e8f0 !important; border-radius: 8px !important; padding: 8px 12px !important; display: flex; align-items: center; background-color: #f8fafc; transition: 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.02); }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 42px !important; right: 10px !important; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { color: #475569 !important; font-size: 14px; padding-left: 0 !important; }
        .select2-container--default.select2-container--open .select2-selection--single { border-color: #cbd5e1 !important; background-color: white; }
    </style>

    <div style="background-color: white; border-radius: 16px; padding: 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(0,0,0,0.03); border-left: 8px solid #311042; margin-bottom: 25px;">
        <div>
            <h2 style="margin: 0; color: #0f172a; font-size: 24px; font-weight: 800;">Gestión de Préstamos y Devoluciones</h2>
            <p style="margin: 8px 0 0 0; color: #64748b; font-size: 14px;">Administra las salidas, retornos y adeudos de material.</p>
        </div>
    </div>

    @if(session('success'))
        <div style="background-color: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; border-left: 5px solid #10b981;">
             ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background-color: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; border-left: 5px solid #e51d38;">
             ⚠️ {{ session('error') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 25px; margin-bottom: 25px;">
        
        <div style="background: white; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border-top: 5px solid #311042;">
            <h3 style="margin: 0 0 20px 0; color: #311042; font-size: 18px; display: flex; align-items: center; gap: 8px; font-weight: 800;">
                 📘 Registrar Nuevo Préstamo
            </h3>
            
            <form method="POST" action="/prestamos">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="font-weight: bold; color: #475569; font-size: 13px; display: block; margin-bottom: 8px;">Seleccionar Usuario:</label>
                    <select name="user_id" class="buscador-inteligente" required style="width: 100%;">
                        <option value="">-- Escribe para buscar por nombre o matrícula --</option>
                        @foreach($usuarios ?? [] as $user)
                            <option value="{{ $user->id }}">{{ $user->matricula }} - {{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div style="margin-bottom: 25px;">
                    <label style="font-weight: bold; color: #475569; font-size: 13px; display: block; margin-bottom: 8px;">Material a Prestar:</label>
                    <select name="material_id" class="buscador-inteligente" required style="width: 100%;">
                        <option value="">-- Escribe para buscar libro, tesis, etc. --</option>
                        @foreach($materiales ?? [] as $mat)
                            <option value="{{ $mat->id }}">{{ $mat->titulo }} (Stock: {{ $mat->stock_fisico }})</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" style="width: 100%; padding: 14px; background-color: #311042; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 14px; transition: 0.2s;" onmouseover="this.style.backgroundColor='#4a1a63'" onmouseout="this.style.backgroundColor='#311042'">Autorizar Préstamo</button>
            </form>
        </div>

        <div style="background: white; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border-top: 5px solid #e51d38;">
            <h3 style="margin: 0 0 20px 0; color: #e51d38; font-size: 18px; display: flex; align-items: center; gap: 8px; font-weight: 800;">
                 🔄 Gestionar Préstamo Activo
            </h3>
            
            <form method="POST" action="/prestamos/gestionar">
                @csrf
                <div style="margin-bottom: 25px;">
                    <label style="font-weight: bold; color: #475569; font-size: 13px; display: block; margin-bottom: 8px;">Buscar Préstamo Activo:</label>
                    <select name="prestamo_id" class="buscador-inteligente" required style="width: 100%;">
                        <option value="">-- Escribe nombre del usuario o título --</option>
                        @foreach($prestamosActivos ?? [] as $prestamo)
                            <option value="{{ $prestamo->id }}">{{ $prestamo->user->name }} - {{ $prestamo->material->titulo }}</option>
                        @endforeach
                    </select>
                    <p style="margin: 8px 0 0 0; font-size: 12px; color: #94a3b8;">* Busca el préstamo y luego elige la acción a realizar abajo.</p>
                </div>

                <div style="display: flex; gap: 15px; margin-top: auto;">
                    <button type="submit" name="accion" value="devolver" style="flex: 1; padding: 14px; background-color: #e51d38; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 14px; transition: 0.2s;" onmouseover="this.style.backgroundColor='#c8162f'" onmouseout="this.style.backgroundColor='#e51d38'">📥 Devolver</button>
                    
                    <button type="submit" name="accion" value="renovar" style="flex: 1; padding: 14px; background-color: #3b82f6; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 14px; transition: 0.2s;" onmouseover="this.style.backgroundColor='#2563eb'" onmouseout="this.style.backgroundColor='#3b82f6'">⏳ Renovar</button>
                </div>
            </form>
        </div>
    </div>

    <div style="background: white; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; margin-bottom: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
        
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
            <div>
                <h3 style="margin: 0; color: #f59e0b; font-size: 18px; font-weight: 800;">Gestión de Multas Pendientes</h3>
                <span style="font-size: 13px; color: #64748b;">Listado de usuarios con adeudos activos</span>
            </div>
            
            <form method="GET" action="/prestamos" style="display: flex; gap: 10px; margin: 0;">
                <input type="text" name="buscar_multa" value="{{ request('buscar_multa') }}" placeholder="🔍 Buscar usuario..." style="padding: 10px 15px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; outline: none; width: 220px; background-color: #f8fafc; transition: 0.2s;" onfocus="this.style.borderColor='#94a3b8'" onblur="this.style.borderColor='#cbd5e1'">
                <button type="submit" style="background-color: #f59e0b; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 13px; transition: 0.2s;" onmouseover="this.style.backgroundColor='#d97706'" onmouseout="this.style.backgroundColor='#f59e0b'">Buscar</button>
                @if(request('buscar_multa'))
                    <a href="/prestamos" style="background-color: #f1f5f9; color: #475569; text-decoration: none; padding: 10px 15px; border-radius: 8px; font-weight: bold; font-size: 13px; transition: 0.2s;" onmouseover="this.style.backgroundColor='#e2e8f0'">✖</a>
                @endif
            </form>
        </div>
        
        <div style="max-height: 350px; overflow-y: auto; overflow-x: auto;">
            <table style="width: 100%; min-width: 800px; border-collapse: collapse; text-align: left;">
                <thead style="position: sticky; top: 0; background-color: #f8fafc; z-index: 10; border-bottom: 1px solid #e2e8f0;">
                    <tr>
                        <th style="padding: 15px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Matrícula</th>
                        <th style="padding: 15px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Usuario</th>
                        <th style="padding: 15px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Carrera</th>
                        <th style="padding: 15px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Motivo</th>
                        <th style="padding: 15px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Monto</th>
                        <th style="padding: 15px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($multas ?? [] as $multa)
                        <tr style="border-bottom: 1px solid #f8fafc; transition: 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                            
                            <td style="padding: 18px 15px; font-size: 13px; font-weight: bold; color: #0f766e; white-space: nowrap;">
                                {{ $multa->user->matricula ?? 'S/M' }}
                            </td>

                            <td style="padding: 18px 15px; min-width: 200px;">
                                <div style="font-weight: bold; color: #1e293b; font-size: 14px;">{{ $multa->user->name ?? 'Usuario Desconocido' }}</div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">{{ $multa->user->email ?? 'Sin Correo' }}</div>
                            </td>

                            <td style="padding: 18px 15px; white-space: nowrap;">
                                @if(($multa->user->rol ?? '') == 'Profesor' || empty($multa->user->carrera))
                                    <span style="color: #94a3b8; font-style: italic; font-size: 12px;">N/A</span>
                                @else
                                    <span style="background-color: #e0f2fe; color: #0369a1; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: bold;">
                                        {{ $multa->user->carrera }}
                                    </span>
                                @endif
                            </td>

                            <td style="padding: 18px 15px; font-size: 13px; color: #475569; white-space: nowrap;">Retraso en entrega</td>
                            
                            <td style="padding: 18px 15px; font-weight: 900; color: #e51d38; font-size: 15px;">${{ number_format($multa->monto ?? 50, 2) }}</td>
                            
                            <td style="padding: 18px 15px; display: flex; gap: 10px; justify-content: center; align-items: center;">
                                <a href="/multas/{{ $multa->id }}/ficha" target="_blank" style="background-color: #f1f5f9; color: #475569; padding: 8px 16px; border-radius: 6px; font-size: 12px; font-weight: bold; text-decoration: none; border: 1px solid #cbd5e1; transition: 0.2s; white-space: nowrap;" onmouseover="this.style.backgroundColor='#e2e8f0'">📄 PDF</a>
                                
                                <form action="/multas/{{ $multa->id }}/pagar" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" style="background-color: #10b981; color: white; border: none; padding: 9px 16px; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 12px; transition: 0.2s; white-space: nowrap;" onmouseover="this.style.backgroundColor='#059669'">💲 Pagar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 40px; text-align: center; color: #94a3b8; font-size: 14px;">
                                ✨ No hay multas pendientes por cobrar en este momento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="background: white; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
        <h3 style="margin: 0 0 20px 0; color: #311042; font-size: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 20px; font-weight: 800;">
            📅 Últimos Movimientos Registrados
        </h3>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; min-width: 1000px; border-collapse: collapse; text-align: left;">
                <thead style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <tr>
                        <th style="padding: 15px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Material</th>
                        <th style="padding: 15px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Cód. BIBUPEM</th>
                        <th style="padding: 15px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Matrícula</th>
                        <th style="padding: 15px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Usuario</th>
                        <th style="padding: 15px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Carrera</th>
                        <th style="padding: 15px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Fecha Límite</th>
                        <th style="padding: 15px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Atendido por</th>
                        <th style="padding: 15px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase;">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($todosLosPrestamos ?? [] as $historial)
                        <tr style="border-bottom: 1px solid #f8fafc; transition: 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                            
                            <td style="padding: 18px 15px; font-weight: 800; color: #1e293b; font-size: 14px; min-width: 200px;">
                                {{ $historial->material->titulo ?? 'N/A' }}
                            </td>
                            
                            <td style="padding: 18px 15px; font-size: 13px; white-space: nowrap;">
                                <span style="background-color: #fef3c7; color: #b45309; padding: 4px 10px; border-radius: 6px; font-weight: 800;">
                                    {{ $historial->material->codigo_bibupem ?? 'S/C' }}
                                </span>
                            </td>

                            <td style="padding: 18px 15px; font-size: 13px; font-weight: bold; color: #0f766e; white-space: nowrap;">
                                {{ $historial->user->matricula ?? 'S/M' }}
                            </td>

                            <td style="padding: 18px 15px; min-width: 180px;">
                                <div style="font-size: 14px; font-weight: bold; color: #1e293b;">{{ $historial->user->name ?? 'Usuario Desconocido' }}</div>
                            </td>

                            <td style="padding: 18px 15px; white-space: nowrap;">
                                @if(($historial->user->rol ?? '') == 'Profesor' || empty($historial->user->carrera))
                                    <span style="color: #94a3b8; font-style: italic; font-size: 12px;">N/A</span>
                                @else
                                    <span style="background-color: #e0f2fe; color: #0369a1; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: bold;">
                                        {{ $historial->user->carrera }}
                                    </span>
                                @endif
                            </td>

                            <td style="padding: 18px 15px; font-size: 13px; color: #475569; font-weight: bold; white-space: nowrap;">
                                {{ \Carbon\Carbon::parse($historial->fecha_limite)->format('d/m/Y') }}
                            </td>
                            
                            <td style="padding: 18px 15px; font-size: 13px; color: #64748b; white-space: nowrap;">
                                👤 {{ $historial->admin->name ?? 'Sistema' }}
                            </td>
                            
                            <td style="padding: 18px 15px; white-space: nowrap;">
                                @if($historial->estado == 'Activo')
                                    <span style="background-color: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 12px; font-size: 12px; font-weight: bold;">🟢 Activo</span>
                                @else
                                    <span style="background-color: #f1f5f9; color: #475569; padding: 6px 12px; border-radius: 12px; font-size: 12px; font-weight: bold;">⚪ Devuelto</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding: 40px; text-align: center; color: #94a3b8; font-size: 14px;">
                                📭 No hay historial de movimientos aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.buscador-inteligente').select2({
                placeholder: "Selecciona una opción...",
                allowClear: true,
                language: {
                    noResults: function() {
                        return "No se encontró ningún resultado";
                    }
                }
            });
        });
    </script>
@endsection