@extends('layouts.admin')

@section('contenido')
    <div style="background-color: white; border-radius: 16px; padding: 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(0,0,0,0.03); border-left: 8px solid #311042; margin-bottom: 25px;">
        <div>
            <h2 style="margin: 0; color: #0f172a; font-size: 24px; font-weight: 800;">Gestión de Padrón de Usuarios</h2>
            <p style="margin: 8px 0 0 0; color: #64748b; font-size: 14px;">Administra el registro de estudiantes, profesores y personal de la biblioteca.</p>
        </div>
    </div>

    @if(session('success'))
        <div style="background-color: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; border-left: 5px solid #10b981;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: white; padding: 25px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
        
        <div style="background-color: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 25px;">
            <form method="GET" action="/usuarios" style="display: flex; gap: 15px; margin: 0; align-items: center; width: 100%; flex-wrap: wrap;">
                
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar nombre o matrícula (Enter)..." style="flex: 1; min-width: 200px; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; outline: none; transition: 0.3s; background-color: white;" onfocus="this.style.borderColor='#311042'" onblur="this.style.borderColor='#cbd5e1'">
                
                <select name="carrera" onchange="this.form.submit()" style="padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: white; cursor: pointer; outline: none; color: #475569;">
                    <option value="">Todas las Carreras</option>
                    <option value="IIN" {{ request('carrera') == 'IIN' ? 'selected' : '' }}>Ing. Industrial (IIN)</option>
                    <option value="IFI" {{ request('carrera') == 'IFI' ? 'selected' : '' }}>Ing. Financiera (IFI)</option>
                    <option value="LAD" {{ request('carrera') == 'LAD' ? 'selected' : '' }}>Lic. Administración (LAD)</option>
                    <option value="IID" {{ request('carrera') == 'IID' ? 'selected' : '' }}>Ing. Tecnologías (IID)</option>
                    <option value="ISE" {{ request('carrera') == 'ISE' ? 'selected' : '' }}>Ing. Sistemas (ISE)</option>
                    <option value="IBT" {{ request('carrera') == 'IBT' ? 'selected' : '' }}>Ing. Biotecnología (IBT)</option>
                    <option value="IAS" {{ request('carrera') == 'IAS' ? 'selected' : '' }}>Ing. Ambiental (IAS)</option>
                </select>

                <select name="rol" onchange="this.form.submit()" style="padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: white; cursor: pointer; outline: none; color: #475569;">
                    <option value="">Todos los Roles</option>
                    <option value="Estudiante" {{ request('rol') == 'Estudiante' ? 'selected' : '' }}>Estudiantes</option>
                    <option value="Profesor" {{ request('rol') == 'Profesor' ? 'selected' : '' }}>Profesores</option>
                    <option value="Administrador" {{ request('rol') == 'Administrador' ? 'selected' : '' }}>Administradores</option>
                </select>

                <select name="orden" onchange="this.form.submit()" style="padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: white; cursor: pointer; outline: none; color: #475569;">
                    <option value="asc" {{ request('orden') == 'asc' ? 'selected' : '' }}>Orden A - Z</option>
                    <option value="desc" {{ request('orden') == 'desc' ? 'selected' : '' }}>Orden Z - A</option>
                </select>

                @if(request('buscar') || request('rol') || request('carrera') || request('orden') == 'desc')
                    <a href="/usuarios" style="background-color: #e2e8f0; color: #475569; text-decoration: none; padding: 12px 18px; border-radius: 8px; font-weight: bold; font-size: 13px; display: flex; align-items: center; transition: 0.2s;" onmouseover="this.style.backgroundColor='#cbd5e1'">Limpiar</a>
                @endif
            </form>
        </div>

        <div style="width: 100%; overflow-x: hidden;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase; width: 10%;">Matrícula</th>
                        <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase; width: 22%;">Usuario y Correo</th>
                        <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase; width: 10%;">Carrera</th>
                        <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase; width: 10%;">Rol</th>
                        <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase; width: 20%;">Préstamos Activos</th>
                        <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase; width: 13%;">Estado de Cta.</th>
                        <th style="padding: 15px 10px; color: #64748b; font-size: 12px; font-weight: 800; text-transform: uppercase; width: 15%; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $user)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                            
                            <td style="padding: 15px 10px; font-weight: 800; color: #0f766e; font-size: 13px;">
                                {{ $user->matricula ?? 'N/A' }}
                            </td>
                            
                            <td style="padding: 15px 10px;">
                                <div style="font-weight: 800; color: #1e293b; font-size: 13px;">{{ $user->name }}</div>
                                <div style="color: #64748b; font-size: 12px; margin-top: 4px; word-break: break-all;">{{ $user->email }}</div>
                            </td>

                            <td style="padding: 15px 10px;">
                                @if($user->rol == 'Profesor' || $user->rol == 'Administrador' || empty($user->carrera))
                                    <span style="color: #94a3b8; font-style: italic; font-size: 12px;">N/A</span>
                                @else
                                    <span style="background-color: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: bold; border: 1px solid #bae6fd; display: inline-block;">
                                        {{ $user->carrera }}
                                    </span>
                                @endif
                            </td>
                            
                            <td style="padding: 15px 10px;">
                                @if($user->rol == 'Administrador')
                                    <span style="background-color: #311042; color: white; padding: 4px 10px; border-radius: 50px; font-size: 11px; font-weight: bold; display: inline-block;">Admin</span>
                                @elseif($user->rol == 'Profesor')
                                    <span style="background-color: #eff6ff; color: #1d4ed8; padding: 4px 10px; border-radius: 50px; font-size: 11px; font-weight: bold; border: 1px solid #bfdbfe; display: inline-block;">Profesor</span>
                                @else
                                    <span style="background-color: #f0fdf4; color: #15803d; padding: 4px 10px; border-radius: 50px; font-size: 11px; font-weight: bold; border: 1px solid #bbf7d0; display: inline-block;">Estudiante</span>
                                @endif
                            </td>
                            
                            <td style="padding: 15px 10px;">
                                @if(isset($user->prestamos) && $user->prestamos->count() > 0)
                                    <ul style="margin: 0; padding-left: 15px; font-size: 12px; color: #475569;">
                                        @foreach($user->prestamos as $prestamo)
                                            <li style="margin-bottom: 8px;">
                                                <span style="color: #1e293b; font-weight: bold;">{{ $prestamo->material->titulo ?? 'Material' }}</span> 
                                                <span style="color: #10b981; font-weight: 800; font-size: 10px; background: #dcfce7; padding: 2px 4px; border-radius: 4px; margin-left: 4px;">A tiempo</span>
                                                <div style="font-size: 11px; color: #d97706; font-weight: 800; margin-top: 4px;">
                                                    Cód: {{ $prestamo->material->codigo_bibupem ?? 'S/C' }}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span style="color: #94a3b8; font-size: 12px; font-style: italic;">Sin préstamos activos</span>
                                @endif
                            </td>

                            <td style="padding: 15px 10px;">
                                @php
                                    $totalMultas = isset($user->multas) ? $user->multas->sum('monto') : 0;
                                @endphp

                                @if($totalMultas > 0)
                                    <span style="background-color: #fef2f2; color: #b91c1c; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 800; border: 1px solid #fecaca; display: inline-block;">
                                        Adeudo: ${{ number_format($totalMultas, 2) }}
                                    </span>
                                @else
                                    <span style="color: #10b981; font-size: 12px; font-weight: 800; display: inline-block;">
                                        Sin adeudos
                                    </span>
                                @endif
                            </td>
                            
                            <td style="padding: 15px 10px; text-align: center;">
                                @if($user->rol == 'Administrador')
                                    <span style="color: #94a3b8; font-size: 11px; font-style: italic;">Gestionado en menú principal</span>
                                @else
                                    <div style="display: flex; flex-direction: column; gap: 8px; align-items: center;">
                                        
                                        @php
                                            $estadoActual = $user->estado ?? 'Activo'; 
                                            $bg = '#dcfce7'; $text = '#166534'; $border = '#bbf7d0'; 
                                            
                                            if($estadoActual == 'Baja Temporal') { $bg = '#fef08a'; $text = '#854d0e'; $border = '#fde047'; }
                                            elseif($estadoActual == 'Suspendido') { $bg = '#ffedd5'; $text = '#c2410c'; $border = '#fed7aa'; }
                                            elseif($estadoActual == 'Baja Definitiva') { $bg = '#fee2e2'; $text = '#b91c1c'; $border = '#fecaca'; }
                                        @endphp
                                        <span style="background-color: {{ $bg }}; color: {{ $text }}; padding: 4px 10px; border-radius: 50px; font-size: 11px; font-weight: bold; border: 1px solid {{ $border }}; width: 100%; box-sizing: border-box; text-align: center;">
                                            {{ $estadoActual }}
                                        </span>

                                        <a href="/usuarios/{{ $user->id }}/editar" style="background-color: #f8fafc; color: #3b82f6; border: 1px solid #bfdbfe; padding: 6px 10px; border-radius: 6px; font-size: 11px; font-weight: bold; text-decoration: none; transition: 0.2s; width: 100%; box-sizing: border-box; text-align: center;" onmouseover="this.style.backgroundColor='#eff6ff'" onmouseout="this.style.backgroundColor='#f8fafc'">Editar Datos</a>

                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 40px; text-align: center; color: #94a3b8; font-size: 14px;">
                                No se encontraron usuarios con esos filtros.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 25px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
            {{ $usuarios->links() }}
        </div>
    </div>
@endsection