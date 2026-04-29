@extends('layouts.admin')

@section('contenido')
    @if(session('success'))
        <div style="background-color: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; border-left: 5px solid #10b981;">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; border-left: 5px solid #e51d38;">
            ⚠️ {{ $errors->first() }}
        </div>
    @endif

    <div style="background-color: white; border-radius: 16px; padding: 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(0,0,0,0.03); border-left: 8px solid #311042; margin-bottom: 25px;">
        <div>
            <h2 style="margin: 0; color: #0f172a; font-size: 24px; font-weight: 800;">Gestión de Catálogo</h2>
            <p style="margin: 8px 0 0 0; color: #64748b; font-size: 14px;">Visualiza y administra tus materiales registrados.</p>
        </div>
        
        <a href="/materiales/crear" style="background-color: #4a148c; color: white; padding: 12px 20px; border-radius: 10px; font-weight: bold; font-size: 14px; text-decoration: none; transition: 0.2s; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.backgroundColor='#311042';" onmouseout="this.style.backgroundColor='#4a148c';">
            ➕ Agregar Material
        </a>
    </div>

    <div style="background-color: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); gap: 20px; flex-wrap: wrap;">
        
        <form method="GET" action="/materiales" style="display: flex; gap: 15px; margin: 0; flex: 1; min-width: 400px; align-items: center;">
            <div style="position: relative; flex: 1;">
                <span style="position: absolute; left: 15px; top: 12px; color: #94a3b8; font-size: 14px;">🔍</span>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por título, autor o código..." style="width: 100%; padding: 10px 15px 10px 40px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none; background-color: #f8fafc; color: #475569; transition: 0.2s; box-sizing: border-box;" onfocus="this.style.borderColor='#cbd5e1'" onblur="this.style.borderColor='#e2e8f0'">
                @if(request('buscar'))
                    <a href="/materiales" style="position: absolute; right: 10px; top: 12px; color: #94a3b8; text-decoration: none; font-weight: bold; font-size: 12px;" title="Limpiar búsqueda">✖</a>
                @endif
            </div>
            
            <select name="orden" onchange="this.form.submit()" style="padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer; outline: none; color: #64748b; min-width: 150px; box-sizing: border-box;">
                <option value="recientes" {{ request('orden') == 'recientes' || !request('orden') ? 'selected' : '' }}>Más recientes</option>
                <option value="antiguos" {{ request('orden') == 'antiguos' ? 'selected' : '' }}>Más antiguos</option>
                <option value="asc" {{ request('orden') == 'asc' ? 'selected' : '' }}>Título (A - Z)</option>
                <option value="desc" {{ request('orden') == 'desc' ? 'selected' : '' }}>Título (Z - A)</option>
            </select>
        </form>

        <form action="/materiales/importar" method="POST" enctype="multipart/form-data" style="display: flex; gap: 10px; align-items: center; margin: 0; white-space: nowrap;">
            @csrf
            <label for="excel-upload" style="background-color: #f3e8ff; color: #7e22ce; padding: 10px 15px; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: bold; display: flex; align-items: center; gap: 8px; transition: 0.2s;" onmouseover="this.style.backgroundColor='#e9d5ff';" onmouseout="this.style.backgroundColor='#f3e8ff';">
                📄 Importar Excel
            </label>
            <input id="excel-upload" type="file" name="documento_excel" required accept=".xlsx, .xls, .csv" style="display: none;" onchange="document.getElementById('btn-subir').style.display='inline-block';">
            
            <button id="btn-subir" type="submit" style="background-color: #311042; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 13px; transition: 0.2s; /* display: none; */" onmouseover="this.style.backgroundColor='#1e0a29'" onmouseout="this.style.backgroundColor='#311042'">Subir</button>
        </form>
    </div>

    <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02); overflow-x: auto;">
        <table style="width: 100%; min-width: 900px; border-collapse: collapse; text-align: left;">
            <thead style="border-bottom: 1px solid #e2e8f0;">
                <tr>
                    <th style="padding: 20px; color: #64748b; font-size: 11px; font-weight: 800; text-transform: uppercase; width: 5%;">ID</th>
                    <th style="padding: 20px; color: #64748b; font-size: 11px; font-weight: 800; text-transform: uppercase; width: 15%;">Código</th>
                    <th style="padding: 20px; color: #64748b; font-size: 11px; font-weight: 800; text-transform: uppercase; width: 30%;">Título</th>
                    <th style="padding: 20px; color: #64748b; font-size: 11px; font-weight: 800; text-transform: uppercase; width: 15%;">Autor</th>
                    <th style="padding: 20px; color: #64748b; font-size: 11px; font-weight: 800; text-transform: uppercase; width: 15%;">Clasificación</th>
                    <th style="padding: 20px; color: #64748b; font-size: 11px; font-weight: 800; text-transform: uppercase; width: 10%;">Stock</th>
                    <th style="padding: 20px; color: #64748b; font-size: 11px; font-weight: 800; text-transform: uppercase; width: 10%;">Acciones</th> 
                </tr>
            </thead>
            <tbody>
                @forelse($materiales as $item)
                    <tr style="border-bottom: 1px solid #f8fafc; transition: 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td style="padding: 18px 20px; font-size: 13px; color: #94a3b8;">#{{ $item->id }}</td>
                        
                        <td style="padding: 18px 20px; white-space: nowrap;">
                            <span style="background-color: #ccfbf1; color: #0f766e; padding: 5px 10px; border-radius: 6px; font-size: 12px; font-weight: 800; display: inline-block;">
                                {{ $item->codigo_bibupem ?? 'S/C' }}
                            </span>
                        </td>
                        
                        <td style="padding: 18px 20px; font-weight: 800; color: #1e293b; font-size: 14px;">{{ $item->titulo }}</td>
                        
                        <td style="padding: 18px 20px; font-size: 13px; color: #64748b;">{{ $item->autor }}</td>
                        
                        <td style="padding: 18px 20px; white-space: nowrap;">
                            <span style="background-color: #f1f5f9; color: #64748b; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 800; display: inline-block;">
                                 {{ $item->clasificacion ?? ($item->categoria ?? 'General') }}
                            </span>
                        </td>
                        
                        <td style="padding: 18px 20px; font-weight: bold;">
                            @if($item->stock_fisico >= 3)
                                <span style="background-color: #dcfce7; color: #166534; display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; font-size: 12px;">
                                    {{ $item->stock_fisico }}
                                </span>
                            @elseif($item->stock_fisico == 2)
                                <span style="background-color: #fef08a; color: #854d0e; display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; font-size: 12px;">
                                    {{ $item->stock_fisico }}
                                </span>
                            @else
                                <span style="background-color: #fee2e2; color: #991b1b; display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; font-size: 12px;">
                                    {{ $item->stock_fisico }}
                                </span>
                            @endif
                        </td>
                        
                        <td style="padding: 18px 20px;">
                            <a href="/materiales/{{ $item->id }}/editar" style="background-color: #f3e8ff; color: #7e22ce; padding: 8px 16px; text-decoration: none; border-radius: 6px; font-size: 12px; font-weight: bold; display: inline-block; transition: 0.2s;" onmouseover="this.style.backgroundColor='#e9d5ff'" onmouseout="this.style.backgroundColor='#f3e8ff'">
                                Editar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 40px; text-align: center; color: #94a3b8; font-size: 14px;">
                            No se encontraron materiales en el catálogo.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection