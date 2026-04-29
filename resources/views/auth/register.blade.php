<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Biblioteca Digital UPEMOR</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            height: 100vh; /* Fuerza a que ocupe el alto exacto de la pantalla */
            overflow: hidden; /* Evita el scroll vertical */
            background-color: #ffffff;
        }
        
        /* Panel Izquierdo (Diseño oscuro) */
        .left-panel {
            background-color: #24143e; 
            width: 45%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .brand-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 40px 30px; /* Reducido para compactar */
            border-radius: 16px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.08);
            max-width: 400px;
        }

        .brand-title {
            color: transparent;
            background-image: linear-gradient(90deg, #fbd06b, #f59e0b);
            -webkit-background-clip: text;
            background-clip: text;
            font-size: 2.5rem; /* Ligeramente más pequeño */
            margin: 0 0 10px 0;
            line-height: 1.1;
            font-weight: 800;
        }

        .brand-subtitle {
            color: #d1d5db;
            margin: 0;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        /* Panel Derecho (Formulario blanco) */
        .right-panel {
            width: 55%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
            overflow-y: auto; /* Solo permite scroll en pantallas ultra pequeñas */
        }

        .login-container {
            width: 100%;
            max-width: 480px;
        }

        .title { 
            color: #020617; 
            font-size: 26px; /* Reducido */
            margin: 0 0 4px 0; 
            font-weight: 800; 
        }
        
        .subtitle { 
            color: #64748b; 
            font-size: 11px; 
            margin: 0 0 20px 0; /* Margen inferior reducido */
            font-weight: 600; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
        }

        .form-row {
            display: flex;
            gap: 12px;
            margin-bottom: 12px; /* Margen reducido */
        }

        .form-group { text-align: left; flex: 1; }
        .form-group.full { width: 100%; margin-bottom: 12px; }

        .form-group label { 
            display: block; 
            font-size: 10px; /* Tamaño de etiqueta más sutil */
            color: #64748b; 
            margin-bottom: 4px; /* Separación reducida */
            font-weight: 700; 
            text-transform: uppercase;
        }
        
        .form-group input, .form-group select {
            width: 100%; 
            padding: 10px 12px; /* Inputs menos altos */
            border: 2px solid transparent; 
            border-radius: 8px; 
            font-size: 13px; 
            box-sizing: border-box; 
            transition: all 0.3s ease; 
            background-color: #eef2f9; 
            color: #0f172a;
            font-family: inherit;
        }
        
        .form-group input:focus, .form-group select:focus { 
            outline: none; 
            border-color: #cbd5e1; 
            background-color: #ffffff;
        }

        .btn-submit {
            width: 100%; 
            background-color: #4a156b; 
            color: white; 
            padding: 12px; /* Botón menos alto */
            border: none; 
            border-radius: 8px; 
            font-size: 15px; 
            font-weight: 700; 
            cursor: pointer; 
            transition: 0.3s; 
            margin-top: 5px;
        }
        
        .btn-submit:hover { 
            background-color: #3b1156; 
        }

        .links { 
            margin-top: 15px; /* Separación final reducida */
            text-align: center;
        }
        
        .links a { 
            color: #0f172a; 
            text-decoration: none; 
            font-size: 13px; 
            font-weight: 600; 
        }
        
        .links a span {
            color: #4a156b;
            font-weight: 800;
        }
        
        .links a:hover span { 
            text-decoration: underline; 
        }

        .alert-error { 
            background-color: #fee2e2; 
            color: #991b1b; 
            padding: 10px 14px; 
            border-radius: 8px; 
            margin-bottom: 15px; 
            font-size: 12px; 
            border-left: 4px solid #ef4444; 
            font-weight: 600; 
        }
        
        /* Ocultar elementos por defecto */
        .hidden { display: none !important; }

        /* Responsivo para móviles */
        @media (max-width: 850px) {
            body { height: auto; overflow: auto; } /* En celular sí permitimos scroll */
            .left-panel { display: none; }
            .right-panel { width: 100%; padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="left-panel">
        <div class="brand-card">
            <h1 class="brand-title">Biblioteca<br>Digital</h1>
            <p class="brand-subtitle">Únete a la plataforma de gestión avanzada.<br>Control total de tu acervo en un solo lugar.</p>
        </div>
    </div>

    <div class="right-panel">
        <div class="login-container">
            <h2 class="title">Nuevo Registro</h2>
            <p class="subtitle">CREA TU CUENTA EN EL SISTEMA</p>

            @if ($errors->any())
                <div class="alert-error">
                    ⚠️ Revisa los datos: {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="/register">
                @csrf
                
                <div class="form-group full">
                    <label for="name">Nombre Completo</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Ej. Juan Pérez">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="matricula">Matrícula o Clave</label>
                        <input type="text" id="matricula" name="matricula" value="{{ old('matricula') }}" required placeholder="Ej. 1803001">
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Institucional</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="@upemor.edu.mx">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="rol">¿Cuál es tu rol?</label>
                        <select id="rol" name="rol" required onchange="toggleCarrera()">
                            <option value="Estudiante" {{ old('rol') == 'Estudiante' ? 'selected' : '' }}>🎓 Estudiante</option>
                            <option value="Profesor" {{ old('rol') == 'Profesor' ? 'selected' : '' }}>👨‍🏫 Profesor</option>
                        </select>
                    </div>

                    <div class="form-group" id="div-carrera">
                        <label for="carrera">Programa Educativo</label>
                        <select id="carrera" name="carrera">
                            <option value="">Selecciona tu carrera...</option>
                            <option value="IIN" {{ old('carrera') == 'IIN' ? 'selected' : '' }}>Ingeniería Industrial (IIN)</option>
                            <option value="IFI" {{ old('carrera') == 'IFI' ? 'selected' : '' }}>Ingeniería Financiera (IFI)</option>
                            <option value="LAD" {{ old('carrera') == 'LAD' ? 'selected' : '' }}>Licenciatura en Admón. (LAD)</option>
                            <option value="IID" {{ old('carrera') == 'IID' ? 'selected' : '' }}>Ing. en TI e Innovación (IID)</option>
                            <option value="ISE" {{ old('carrera') == 'ISE' ? 'selected' : '' }}>Ing. en Sistemas Electrónicos (ISE)</option>
                            <option value="IBT" {{ old('carrera') == 'IBT' ? 'selected' : '' }}>Ingeniería en Biotecnología (IBT)</option>
                            <option value="IAS" {{ old('carrera') == 'IAS' ? 'selected' : '' }}>Ing. Ambiental y Sustentabilidad (IAS)</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" required placeholder="Mín. 6 caracteres">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Repite tu contraseña">
                    </div>
                </div>

                <button type="submit" class="btn-submit">Crear Cuenta</button>
            </form>

            <div class="links">
                <a href="/">¿Ya tienes una cuenta? <span>Inicia sesión aquí</span></a>
            </div>
        </div>
    </div>

    <script>
        function toggleCarrera() {
            var rol = document.getElementById("rol").value;
            var divCarrera = document.getElementById("div-carrera");
            var inputCarrera = document.getElementById("carrera");

            if (rol === "Profesor") {
                divCarrera.classList.add("hidden");
                inputCarrera.value = ""; 
                inputCarrera.required = false; 
            } else {
                divCarrera.classList.remove("hidden");
                inputCarrera.required = true; 
            }
        }

        window.onload = toggleCarrera;
    </script>

</body>
</html>