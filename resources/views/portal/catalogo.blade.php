<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo | Biblioteca</title>
    <style>
        :root {
            --primary: #311042;
            --primary-light: #4a1a63;
            --accent: #f59e0b;
            --success: #166534;
            --danger: #b91c1c;
            --bg: #f1f5f9;
        }

        body { 
            margin: 0; 
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; 
            background-color: var(--bg); 
            color: #1e293b; 
        }
        
        /* Barra de Navegación - Idéntica al Portal */
        .navbar { 
            background: var(--primary); 
            padding: 0 40px; 
            height: 70px;
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            color: white; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-logo { 
            font-size: 22px; 
            font-weight: 900; 
            letter-spacing: -0.5px; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .nav-links { display: flex; gap: 25px; align-items: center; }
        .nav-link { 
            color: #cbd5e1; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 600; 
            transition: 0.3s;
            padding: 8px 0;
            border-bottom: 2px solid transparent;
        }
        .nav-link:hover, .nav-link.active { 
            color: white; 
            border-bottom: 2px solid var(--accent);
        }
        .btn-logout { 
            background-color: #e51d38; 
            color: white; 
            padding: 10px 22px; 
            border-radius: 12px; 
            text-decoration: none; 
            font-size: 13px; 
            font-weight: 700; 
            transition: 0.3s; 
        }
        .btn-logout:hover { 
            background-color: #ff2e4d; 
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(229, 29, 56, 0.3);
        }

        /* Contenedor Principal */
        .container { max-width: 1200px; margin: 40px auto; padding: 0 30px; }
        
        /* Sección de Buscador (Estilo Welcome-Section) */
        .search-header { 
            background: white; 
            padding: 35px; 
            border-radius: 20px; 
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); 
            margin-bottom: 35px; 
            border-left: 8px solid var(--primary); 
        }
        .search-header h1 { margin: 0; color: var(--primary); font-size: 32px; font-weight: 800; }
        .search-header p { margin: 8px 0 25px 0; color: #64748b; font-size: 16px; }

        /* Formulario Estilizado */
        .search-form {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .form-input, .form-select {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
            color: #1e293b;
            outline: none;
            transition: 0.3s;
        }
        .form-input { flex: 2; min-width: 200px; }
        .form-select { flex: 1; min-width: 150px; cursor: pointer; }
        .form-input:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(49, 16, 66, 0.05); }

        .btn-submit { 
            background-color: var(--primary); 
            color: white; 
            padding: 12px 25px; 
            border-radius: 12px; 
            border: none;
            font-weight: 700; 
            cursor: pointer;
            transition: 0.3s; 
            box-shadow: 0 4px 12px rgba(49, 16, 66, 0.15);
        }
        .btn-submit:hover { background-color: var(--primary-light); transform: translateY(-1px); }

        .btn-clear {
            background-color: #f1f5f9;
            color: #64748b;
            padding: 12px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            border: 1px solid #e2e8f0;
        }

        /* Grid de Libros (Mismo diseño de Cards) */
        .books-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 25px; 
        }
        
        .book-card { 
            background: white; 
            border-radius: 20px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.02); 
            overflow: hidden; 
            border: 1px solid #e2e8f0; 
            transition: 0.3s;
            display: flex;
            flex-direction: column;
        }
        .book-card:hover { 
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.06);
            border-color: #cbd5e1;
        }

        .book-cover {
            height: 200px;
            background: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
        }
        .book-cover img { width: 100%; height: 100%; object-fit: contain; padding: 15px; }
        .book-cover-icon { font-size: 50px; }

        .book-body { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
        .book-title { font-weight: 800; color: var(--primary); font-size: 16px; margin-bottom: 5px; line-height: 1.3; }
        .book-author { font-size: 13px; color: #64748b; font-weight: 600; margin-bottom: 15px; }
        
        .tags-container { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 15px; }
        .tag { 
            padding: 4px 10px; 
            border-radius: 6px; 
            font-size: 11px; 
            font-weight: 800; 
            text-transform: uppercase;
        }
        .tag-cat { background: #f1f5f9; color: #475569; }
        .tag-format { background: #fffbeb; color: #b45309; }

        .book-footer { 
            padding-top: 15px; 
            border-top: 1px dashed #e2e8f0; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            margin-top: auto;
        }

        /* Status Badges - Usando el mismo estilo del Portal */
        .badge { padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; }
        .badge-available { background-color: #dcfce7; color: var(--success); }
        .badge-unavailable { background-color: #fee2e2; color: var(--danger); }
        
        .book-code { font-family: monospace; font-size: 11px; color: #94a3b8; font-weight: 600; }

        .empty-results {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px;
            background: white;
            border-radius: 20px;
            border: 2px dashed #e2e8f0;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-logo">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="color: var(--accent)"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
            BIBLIOTECA DIGITAL
        </div>
        <div class="nav-links">
            <a href="/mi-portal" class="nav-link">Mi Panel</a>
            <a href="/catalogo-publico" class="nav-link active">Explorar Catálogo</a>
            <a href="/logout" class="btn-logout">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="container">
        
        <div class="search-header">
            <h1>Acervo Bibliográfico</h1>
            <p>Explora y localiza materiales disponibles en la biblioteca central.</p>

            <form method="GET" action="/catalogo-publico" class="search-form">
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por título, autor o código..." class="form-input">
                
                <select name="categoria" class="form-select">
                    <option value="">Todas las Categorías</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <select name="formato" class="form-select">
                    <option value="">Todos los Formatos</option>
                    @foreach($formatos as $formato)
                        <option value="{{ $formato }}" {{ request('formato') == $formato ? 'selected' : '' }}>{{ $formato }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn-submit">
                    Buscar Material
                </button>

                @if(request('buscar') || request('categoria') || request('formato'))
                    <a href="/catalogo-publico" class="btn-clear">✖ Limpiar</a>
                @endif
            </form>
        </div>

        <div class="books-grid">
            @forelse($materiales as $item)
                <div class="book-card">
                    <div class="book-cover">
                        @if(!empty($item->portada_url))
                            <img src="{{ $item->portada_url }}" alt="Portada" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <span class="book-cover-icon" style="display:none;">📘</span>
                        @else
                            <span class="book-cover-icon">
                                @if(($item->clasificacion ?? '') == 'Revista') 📰 @elseif(($item->clasificacion ?? '') == 'Tesis') 🎓 @else 📘 @endif
                            </span>
                        @endif
                    </div>
                    
                    <div class="book-body">
                        <div class="book-title">{{ $item->titulo }}</div>
                        <div class="book-author">✍️ {{ $item->autor ?? 'Autor Desconocido' }}</div>
                        
                        <div class="tags-container">
                            <span class="tag tag-format">{{ $item->clasificacion ?? 'Libro' }}</span>
                            <span class="tag tag-cat">{{ $item->categoria ?? 'General' }}</span>
                        </div>

                        <div class="book-footer">
                            <span class="book-code">#{{ $item->codigo_bibupem ?? 'S/C' }}</span>
                            
                            @if($item->stock_fisico > 0)
                                <span class="badge badge-success">Disponible ({{ $item->stock_fisico }})</span>
                            @else
                                <span class="badge badge-danger">Agotado</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-results">
                    <span style="font-size: 50px; display: block; margin-bottom: 15px;">🔍</span>
                    <h3 style="margin: 0; color: var(--primary);">No se encontraron resultados</h3>
                    <p style="margin: 10px 0 0 0;">Intenta con otros términos o limpia los filtros.</p>
                </div>
            @endforelse
        </div>

        @if($materiales->hasPages())
            <div style="margin-top: 40px; display: flex; justify-content: center;">
                {{ $materiales->links() }}
            </div>
        @endif

    </div>

</body>
</html>