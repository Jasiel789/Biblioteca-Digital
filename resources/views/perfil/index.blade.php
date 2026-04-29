@extends('layouts.admin')

@section('contenido')
    <style>
        .form-section { 
            background: white; 
            border-radius: 16px; 
            border: 1px solid #e2e8f0; 
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); 
            overflow: hidden; 
            max-width: 650px; 
            margin: 0 auto; 
        }
        .form-header { 
            padding: 25px 35px; 
            border-bottom: 1px solid #f1f5f9; 
            background-color: #ffffff; 
        }
        .form-body { 
            padding: 35px; 
            display: flex; 
            flex-direction: column; 
            gap: 25px; 
        }
        .input-group { 
            display: flex; 
            flex-direction: column; 
            gap: 8px; 
        }
        .input-group label { 
            font-weight: 700; 
            color: #1e293b; 
            font-size: 13px; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
        }
        .form-control { 
            padding: 14px 16px; 
            border: 1px solid #cbd5e1; 
            border-radius: 10px; 
            outline: none; 
            font-size: 15px; 
            transition: all 0.2s ease; 
            background-color: #f8fafc; 
            color: #334155;
        }
        .form-control:focus { 
            border-color: #311042; 
            box-shadow: 0 0 0 4px rgba(49, 16, 66, 0.08); 
            background-color: #ffffff; 
        }
        .form-control:disabled {
            background-color: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
        }
        .alert-success {
            max-width: 650px; 
            margin: 0 auto 25px auto; 
            background-color: #f0fdf4; 
            color: #166534; 
            padding: 16px 20px; 
            border-radius: 12px; 
            font-weight: 600; 
            border: 1px solid #bbf7d0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-save {
            background-color: #311042; 
            color: white; 
            border: none; 
            padding: 14px 35px; 
            border-radius: 10px; 
            font-weight: 700; 
            cursor: pointer; 
            transition: all 0.3s; 
            box-shadow: 0 4px 12px rgba(49, 16, 66, 0.2); 
            font-size: 15px;
        }
        .btn-save:hover {
            background-color: #4a1a63;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(49, 16, 66, 0.3);
        }
        .btn-back {
            background-color: white; 
            color: #64748b; 
            padding: 10px 20px; 
            border-radius: 10px; 
            font-weight: 700; 
            text-decoration: none; 
            border: 1px solid #e2e8f0; 
            transition: all 0.2s; 
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-back:hover {
            background-color: #f8fafc;
            color: #1e293b;
        }
    </style>

    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; max-width: 650px; margin-left: auto; margin-right: auto;">
        <div>
            <h2 style="margin: 0; color: #1e293b; font-size: 28px; font-weight: 900; letter-spacing: -0.5px;">Mi Perfil</h2>
            <p style="color: #64748b; margin: 5px 0 0 0; font-size: 15px;">Gestiona tu información de acceso al sistema.</p>
        </div>
        
        <a href="/dashboard" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Volver al Panel
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- El action coincide con tu ruta Route::put('/mi-perfil', ...) --}}
    <form action="{{ url('/mi-perfil') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-section">
            <div class="form-header">
                <h3 style="color: #311042; margin: 0; font-size: 16px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">
                    Configuración de Usuario
                </h3>
            </div>
            
            <div class="form-body">
                <div class="input-group">
                    <label>Nombre Completo</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" required class="form-control">
                </div>

                <div class="input-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" required class="form-control">
                    <span style="font-size: 12px; color: #94a3b8;">Este es tu identificador de acceso al sistema.</span>
                </div>

                <div class="input-group" style="margin-top: 10px; padding-top: 25px; border-top: 1px solid #f1f5f9;">
                    <label style="color: #e51d38;">Seguridad</label>
                    <input type="password" name="password" placeholder="Nueva contraseña (opcional)" class="form-control">
                    <p style="font-size: 12px; color: #64748b; margin-top: 8px; line-height: 1.4;">
                        Si deseas cambiar tu contraseña, escríbela arriba. <br>
                        <strong>Importante:</strong> Si lo dejas vacío, se conservará la contraseña actual.
                    </p>
                </div>
            </div>
            
            <div style="padding: 25px 35px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn-save">
                    Guardar Cambios
                </button>
            </div>
        </div>
    </form>
@endsection