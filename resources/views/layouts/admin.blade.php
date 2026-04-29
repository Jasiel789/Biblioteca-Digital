<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión Bibliotecaria</title>
    <style>
        /* Estilos Base */
        body { 
            margin: 0; 
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            display: flex; 
            height: 100vh; 
            background-color: #f8fafc; /* Fondo gris muy claro para resaltar las tarjetas blancas */
            overflow: hidden;
        }

        .main-content { 
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            overflow-y: auto; 
            position: relative;
        }

        .content-area { 
            padding: 35px 40px; 
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
        }

        /* Estilos del Menú Lateral (Sidebar) */
        .sidebar-main {
            width: 280px;
            background: linear-gradient(180deg, #311042 0%, #170720 100%);
            color: #ffffff;
            min-height: 100vh;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            display: flex;
            flex-direction: column;
            z-index: 10;
        }

        .sidebar-header {
            padding: 40px 25px 30px;
            text-align: center;
            position: relative;
        }

        .sidebar-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 10%;
            width: 80%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        }

        .sidebar-title {
            font-size: 28px;
            font-weight: 900;
            margin: 0;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .sidebar-subtitle {
            font-size: 12px;
            color: #f59e0b; /* Acento ámbar para contrastar elegante con el morado */
            margin-top: 8px;
            font-weight: 700;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        .nav-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 25px 15px;
        }

        .nav-item {
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            transform: translateX(5px);
        }

        .nav-item.active {
            background-color: rgba(245, 158, 11, 0.15); /* Fondo suave ámbar */
            color: #ffffff;
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: #f59e0b;
            border-radius: 0 4px 4px 0;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .nav-item:hover .nav-icon, .nav-item.active .nav-icon {
            opacity: 1;
            color: #f59e0b;
        }

        /* Topbar / Barra Superior */
        .topbar {
            display: flex; 
            justify-content: flex-end; 
            align-items: center; 
            gap: 20px; 
            padding: 15px 40px; 
            background-color: rgba(255, 255, 255, 0.9); 
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0; 
            position: sticky;
            top: 0;
            z-index: 5;
        }

        .profile-btn {
            display: inline-flex; 
            align-items: center; 
            gap: 10px; 
            background-color: #ffffff; 
            color: #1e293b; 
            padding: 8px 16px; 
            border-radius: 50px; 
            font-weight: 700; 
            font-size: 14px; 
            text-decoration: none; 
            border: 1px solid #cbd5e1; 
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .profile-btn:hover {
            background-color: #f8fafc; 
            border-color: #94a3b8;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.04);
        }

        .profile-btn .avatar-circle {
            background-color: #eff6ff;
            color: #3b82f6;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logout-btn {
            background-color: white; 
            color: #e51d38; 
            padding: 8px 20px; 
            border-radius: 50px; 
            font-weight: 700; 
            font-size: 14px; 
            text-decoration: none; 
            border: 1px solid #fecaca;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background-color: #fef2f2; 
            border-color: #fca5a5;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <aside class="sidebar-main">
        <div class="sidebar-header">
            <h1 class="sidebar-title">Biblioteca</h1>
            <div class="sidebar-subtitle">Portal Administrativo</div>
        </div>

        <nav class="nav-container">
            <a href="/dashboard" class="nav-item {{ Request::is('/') || Request::is('dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Inicio
            </a>

            <a href="/materiales" class="nav-item {{ Request::is('materiales*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Gestión de Catálogo
            </a>

            <a href="/prestamos" class="nav-item {{ Request::is('prestamos*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                Préstamos / Devoluciones
            </a>

            <a href="/usuarios" class="nav-item {{ Request::is('usuarios*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Usuarios
            </a>

            <a href="/reportes" class="nav-item {{ Request::is('reportes*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Reportes
            </a>
        </nav>
    </aside>

    <div class="main-content">
        
        <header class="topbar">
            <a href="/mi-perfil" class="profile-btn">
                <div class="avatar-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </div>
                {{ Auth::user()->name ?? 'Administrador' }}
            </a>

            <a href="/logout" class="logout-btn">
                Cerrar Sesión
            </a>
        </header>

        <main class="content-area">
            @yield('contenido')
        </main>

    </div>

</body>
</html>