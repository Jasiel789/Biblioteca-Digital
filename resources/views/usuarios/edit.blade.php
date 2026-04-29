@extends('layouts.admin')

@section('contenido')
    <style>
        .form-section { background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02); margin-bottom: 25px; overflow: hidden; }
        .form-header { padding: 20px 30px; border-bottom: 1px solid #e2e8f0; background-color: #f8fafc; }
        .form-body { padding: 30px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .input-group { display: flex; flex-direction: column; gap: 6px; }
        .input-group label { font-weight: 600; color: #475569; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-control { padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 14px; transition: all 0.2s; background-color: #fcfcfc; }
        .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); background-color: #ffffff; }
        .hidden { display: none !important; }
    </style>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2 style="margin-top: 0; color: #311042; font-size: 26px; font-weight: 900; margin-bottom: 5px; letter-spacing: -0.5px;">Editar Usuario</h2>
            <p style="color: #64748b; margin: 0; font-size: 14px;">Modifica los datos personales o el estatus de la cuenta de este usuario.</p>
        </div>
        <a href="/usuarios" style="background-color: white; color: #475569; padding: 10px 20px; border-radius: 8px; font-weight: bold; text-decoration: none; border: 1px solid #cbd5e1; transition: 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.02);" onmouseover="this.style.backgroundColor='#f8fafc'">
            ⬅ Cancelar y Volver
        </a>
    </div>

    <form action="/usuarios/{{ $usuario->id }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-section">
            <div class="form-header">
                <h3 style="color: #1e293b; margin: 0; font-size: 18px;">👤 Datos Generales</h3>
            </div>
            
            <div class="form-body">
                <div class="input-group" style="grid-column: span 2;">
                    <label>Nombre Completo</label>
                    <input type="text" name="name" value="{{ $usuario->name }}" required class="form-control">
                </div>

                <div class="input-group">
                    <label>Matrícula o Clave</label>
                    <input type="text" name="matricula" value="{{ $usuario->matricula }}" required class="form-control" style="font-weight: bold; color: #0f766e;">
                </div>

                <div class="input-group">
                    <label>Correo Electrónico Institucional</label>
                    <input type="email" name="email" value="{{ $usuario->email }}" required class="form-control">
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-header" style="background-color: #fffbeb; border-bottom-color: #fde68a;">
                <h3 style="color: #b45309; margin: 0; font-size: 18px;">⚙️ Configuración y Estatus</h3>
            </div>
            
            <div class="form-body">
                <div class="input-group">
                    <label>Rol del Usuario</label>
                    <select name="rol" id="rol" class="form-control" onchange="toggleCarrera()">
                        <option value="Estudiante" {{ $usuario->rol == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
                        <option value="Profesor" {{ $usuario->rol == 'Profesor' ? 'selected' : '' }}>Profesor</option>
                        <option value="Administrador" {{ $usuario->rol == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                    </select>
                </div>

                <div class="input-group" id="div-carrera">
                    <label>Programa Educativo (Carrera)</label>
                    <select name="carrera" id="carrera" class="form-control">
                        <option value="">Selecciona una carrera...</option>
                        <option value="IIN" {{ $usuario->carrera == 'IIN' ? 'selected' : '' }}>Ingeniería Industrial (IIN)</option>
                        <option value="IFI" {{ $usuario->carrera == 'IFI' ? 'selected' : '' }}>Ingeniería Financiera (IFI)</option>
                        <option value="LAD" {{ $usuario->carrera == 'LAD' ? 'selected' : '' }}>Licenciatura en Administración (LAD)</option>
                        <option value="IID" {{ $usuario->carrera == 'IID' ? 'selected' : '' }}>Ingeniería en Tecnologías de la Info. (IID)</option>
                        <option value="ISE" {{ $usuario->carrera == 'ISE' ? 'selected' : '' }}>Ingeniería en Sistemas Electrónicos (ISE)</option>
                        <option value="IBT" {{ $usuario->carrera == 'IBT' ? 'selected' : '' }}>Ingeniería en Biotecnología (IBT)</option>
                        <option value="IAS" {{ $usuario->carrera == 'IAS' ? 'selected' : '' }}>Ing. Ambiental y Sustentabilidad (IAS)</option>
                    </select>
                </div>

                <div class="input-group" style="grid-column: span 2;">
                    <label>Estatus de la Cuenta</label>
                    <select name="estado" class="form-control" style="font-weight: bold; border-width: 2px;">
                        <option value="Activo" {{ $usuario->estado == 'Activo' ? 'selected' : '' }}>🟢 Cuenta Activa</option>
                        <option value="Baja Temporal" {{ $usuario->estado == 'Baja Temporal' ? 'selected' : '' }}>🟡 Baja Temporal</option>
                        <option value="Suspendido" {{ $usuario->estado == 'Suspendido' ? 'selected' : '' }}>🟠 Suspendido (No puede sacar libros)</option>
                        <option value="Baja Definitiva" {{ $usuario->estado == 'Baja Definitiva' ? 'selected' : '' }}>🔴 Baja Definitiva / Egresado</option>
                    </select>
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; margin-bottom: 40px;">
            <button type="submit" style="background-color: #f59e0b; color: white; border: none; padding: 12px 40px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.2s; box-shadow: 0 4px 6px rgba(245, 158, 11, 0.2); font-size: 16px;" onmouseover="this.style.backgroundColor='#d97706'">
                💾 Guardar Cambios
            </button>
        </div>
    </form>

    <script>
        function toggleCarrera() {
            var rol = document.getElementById("rol").value;
            var divCarrera = document.getElementById("div-carrera");
            
            if (rol === "Profesor" || rol === "Administrador") {
                divCarrera.classList.add("hidden");
            } else {
                divCarrera.classList.remove("hidden");
            }
        }

        // Ejecutar al cargar la página para revisar el rol actual del usuario
        window.onload = toggleCarrera;
    </script>
@endsection