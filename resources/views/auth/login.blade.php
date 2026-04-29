<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Biblioteca Digital UPEMOR</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            height: 100vh;
            overflow: hidden;
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
            padding: 50px 40px;
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
            font-size: 3rem;
            margin: 0 0 15px 0;
            line-height: 1.1;
            font-weight: 800;
        }

        .brand-subtitle {
            color: #d1d5db;
            margin: 0;
            font-size: 1rem;
            line-height: 1.5;
        }

        /* Panel Derecho (Formulario blanco) */
        .right-panel {
            width: 55%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 40px;
        }

        .login-container {
            width: 100%;
            max-width: 420px; /* Un poco más angosto que el registro, ideal para login */
        }

        .title { 
            color: #020617; 
            font-size: 36px; 
            margin: 0 0 8px 0; 
            font-weight: 800; 
        }
        
        .subtitle { 
            color: #64748b; 
            font-size: 12px; 
            margin: 0 0 40px 0; 
            font-weight: 600; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 25px;
        }

        .form-group label { 
            display: block; 
            font-size: 11px; 
            color: #64748b; 
            margin-bottom: 8px; 
            font-weight: 700; 
            text-transform: uppercase;
        }
        
        .form-group input {
            width: 100%; 
            padding: 14px 16px; 
            border: 2px solid transparent; 
            border-radius: 8px; 
            font-size: 14px; 
            box-sizing: border-box; 
            transition: all 0.3s ease; 
            background-color: #eef2f9; 
            color: #0f172a;
            font-family: inherit;
        }
        
        .form-group input:focus { 
            outline: none; 
            border-color: #cbd5e1; 
            background-color: #ffffff;
        }

        /* Contenedor del input con ojito */
        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-wrapper input {
            padding-right: 45px; /* Espacio para que el texto no toque el icono */
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 5px;
            color: #64748b; /* Gris acorde al nuevo diseño */
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color: #4a156b;
        }

        .toggle-password:focus {
            outline: none;
        }

        .btn-submit {
            width: 100%; 
            background-color: #4a156b; 
            color: white; 
            padding: 16px; 
            border: none; 
            border-radius: 8px; 
            font-size: 16px; 
            font-weight: 700; 
            cursor: pointer; 
            transition: 0.3s; 
            margin-top: 10px;
        }
        
        .btn-submit:hover { 
            background-color: #3b1156; 
        }

        .links { 
            margin-top: 30px; 
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .links a.link-registro { 
            color: #64748b; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 600; 
        }
        
        .links a.link-registro span {
            color: #4a156b;
            font-weight: 800;
        }
        
        .links a.link-registro:hover span { 
            text-decoration: underline; 
        }

        .links a.link-olvido {
            color: #94a3b8;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: color 0.3s;
        }

        .links a.link-olvido:hover {
            color: #4a156b;
            text-decoration: underline;
        }

        .alert-error { 
            background-color: #fee2e2; 
            color: #991b1b; 
            padding: 12px 16px; 
            border-radius: 8px; 
            margin-bottom: 25px; 
            font-size: 13px; 
            border-left: 4px solid #ef4444; 
            font-weight: 600; 
        }

        /* Responsivo para móviles */
        @media (max-width: 850px) {
            body { height: auto; overflow: auto; }
            .left-panel { display: none; }
            .right-panel { width: 100%; padding: 30px 20px; min-height: 100vh; }
        }
    </style>
</head>
<body>

    <div class="left-panel">
        <div class="brand-card">
            <h1 class="brand-title">Biblioteca<br>Digital</h1>
            <p class="brand-subtitle">Accede a tu plataforma de gestión avanzada.<br>Control total de tu acervo en un solo lugar.</p>
        </div>
    </div>

    <div class="right-panel">
        <div class="login-container">
            
            <h2 class="title">Bienvenido</h2>
            <p class="subtitle">Inicia sesión en tu cuenta</p>

            @if ($errors->any())
                <div class="alert-error">
                    ⚠️ {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf

                <div class="form-group">
                    <label for="email">Correo Institucional</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@upemor.edu.mx">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" required placeholder="••••••••">
                        <button type="button" id="toggleBtn" class="toggle-password" title="Mostrar/Ocultar contraseña">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Ingresar al sistema</button>
            </form>

            <div class="links">
                <a href="/register" class="link-registro">¿No tienes una cuenta? <span>Regístrate aquí</span></a>
                <a href="/forgot-password" class="link-olvido">¿Olvidaste tu contraseña?</a>
            </div>

        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.getElementById('toggleBtn');
        const eyeIcon = document.getElementById('eyeIcon');

        toggleBtn.addEventListener('click', function() {
            // Cambiamos el tipo de input de 'password' a 'text' y viceversa
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Cambiamos el ícono del ojito dependiendo del estado
            if (type === 'text') {
                // Ícono de ojo tachado (ocultar)
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                // Ícono de ojo normal (mostrar)
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        });
    </script>

</body>
</html>