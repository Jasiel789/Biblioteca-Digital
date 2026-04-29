@extends('layouts.admin')

@section('contenido')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2 style="margin: 0; color: #311042; font-size: 24px; font-weight: 800;">Editar Material #{{ $material->id }}</h2>
            <p style="color: #64748b; margin: 5px 0 0 0; font-size: 14px;">Corrige cualquier error en el catálogo o actualiza el stock.</p>
        </div>
        <a href="/materiales" style="background-color: white; color: #475569; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: bold; border: 1px solid #cbd5e1; font-size: 13px; transition: 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'">⬅ Cancelar</a>
    </div>

    @if ($errors->any())
        <div style="background-color: #fef2f2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; border-left: 5px solid #991b1b;">
            ⚠️ Por favor corrige los siguientes errores:
            <ul style="margin: 5px 0 0 0; padding-left: 20px; font-weight: normal; font-size: 14px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/materiales/{{ $material->id }}" method="POST">
        @csrf
        @method('PUT')

        <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02); margin-bottom: 25px; overflow: hidden;">
            <div style="background-color: #f8fafc; padding: 15px 25px; border-bottom: 1px solid #e2e8f0;">
                <h3 style="margin: 0; color: #0369a1; font-size: 16px; display: flex; align-items: center; gap: 8px;">📘 Información Pública</h3>
            </div>
            <div style="padding: 25px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                
                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Código BIBUPEM (Editable)</label>
                    <input type="text" name="codigo_bibupem" value="{{ $material->codigo_bibupem }}" style="width: 100%; padding: 10px; border: 1px solid #f59e0b; border-radius: 6px; box-sizing: border-box; background-color: #fffbeb; outline: none; font-weight: bold; color: #b45309;">
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Título del Material *</label>
                    <input type="text" name="titulo" value="{{ $material->titulo }}" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none;">
                </div>
                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Autor(es) *</label>
                    <input type="text" name="autor" value="{{ $material->autor }}" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none;">
                </div>

                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Editorial</label>
                    <input type="text" name="editorial" value="{{ $material->editorial }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none;">
                </div>
                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Lugar de Publicación</label>
                    <input type="text" name="lugar_publicacion" value="{{ $material->lugar_publicacion ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none;">
                </div>
                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Año de Pub.</label>
                    <input type="text" name="anio_publicacion" value="{{ $material->anio_publicacion ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none;">
                </div>
                
                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">ISBN</label>
                    <div style="display: flex; gap: 5px;">
                        <input type="text" id="isbn_input" name="isbn" value="{{ $material->isbn }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none;">
                        <button type="button" onclick="buscarISBN()" style="background-color: #10b981; color: white; border: none; border-radius: 6px; padding: 0 10px; cursor: pointer; font-weight: bold; transition: 0.2s;" onmouseover="this.style.backgroundColor='#059669'" title="Autocompletar con Google Books">
                            🔍
                        </button>
                    </div>
                </div>

                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Clasificación / Formato *</label>
                    <select name="clasificacion" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none; background: white;">
                        <option value="Libro" {{ $material->clasificacion == 'Libro' || $material->clasificacion == 'Libro Textual' ? 'selected' : '' }}>Libro Físico</option>
                        <option value="Revista" {{ $material->clasificacion == 'Revista' ? 'selected' : '' }}>Revista</option>
                        <option value="Tesis" {{ $material->clasificacion == 'Tesis' ? 'selected' : '' }}>Tesis</option>
                        <option value="Manual" {{ $material->clasificacion == 'Manual' ? 'selected' : '' }}>Manual</option>
                    </select>
                </div>
                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Categoría *</label>
                    <select name="categoria" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none; background: white;">
                        <option value="General" {{ $material->categoria == 'General' ? 'selected' : '' }}>General</option>
                        <option value="Programación y Desarrollo" {{ $material->categoria == 'Programación y Desarrollo' ? 'selected' : '' }}>Programación y Desarrollo</option>
                        <option value="Matemáticas y Cálculo" {{ $material->categoria == 'Matemáticas y Cálculo' ? 'selected' : '' }}>Matemáticas y Cálculo</option>
                        <option value="Ingeniería y Sistemas" {{ $material->categoria == 'Ingeniería y Sistemas' ? 'selected' : '' }}>Ingeniería y Sistemas</option>
                        <option value="Bases de Datos" {{ $material->categoria == 'Bases de Datos' ? 'selected' : '' }}>Bases de Datos</option>
                        <option value="Diseño UI/UX" {{ $material->categoria == 'Diseño UI/UX' ? 'selected' : '' }}>Diseño UI/UX</option>
                    </select>
                </div>
                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Edición</label>
                    <input type="text" name="edicion" value="{{ $material->edicion }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none;">
                </div>
                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Stock Físico *</label>
                    <input type="number" name="stock_fisico" value="{{ $material->stock_fisico }}" required min="0" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none; font-weight: bold;">
                </div>

                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Visibilidad en Catálogo *</label>
                    <select name="visibilidad" required style="width: 100%; padding: 10px; border: 1px solid #fecaca; border-radius: 6px; box-sizing: border-box; outline: none; background: #fef2f2; color: #b91c1c; font-weight: bold;">
                        <option value="Público" {{ $material->visibilidad == 'Público' ? 'selected' : '' }}>🟢 Público (Visible para todos los alumnos)</option>
                        <option value="Oculto" {{ $material->visibilidad == 'Oculto' ? 'selected' : '' }}>🔴 Privado (Solo uso administrativo)</option>
                    </select>
                </div>
                
                <div style="grid-column: span 2; display: flex; gap: 15px; align-items: flex-end;">
                    <div style="flex-grow: 1;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Enlace de la Portada (URL)</label>
                        <input type="url" name="portada_url" value="{{ $material->portada_url ?? '' }}" placeholder="https://..." id="url_imagen" oninput="actualizarImagen()" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none;">
                    </div>
                    <div style="width: 50px; height: 65px; border: 1px dashed #cbd5e1; border-radius: 4px; display: flex; justify-content: center; align-items: center; overflow: hidden; background-color: #f8fafc; padding: 2px;">
                        <img id="preview_imagen" src="{{ $material->portada_url ?? '' }}" style="max-width: 100%; max-height: 100%; display: {{ empty($material->portada_url) ? 'none' : 'block' }}; border-radius: 2px;" onerror="this.style.display='none'; document.getElementById('texto_imagen').style.display='block';">
                        <span id="texto_imagen" style="font-size: 9px; color: #94a3b8; text-align: center; display: {{ empty($material->portada_url) ? 'block' : 'none' }};">Sin foto</span>
                    </div>
                </div>

            </div>
        </div>

        <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02); margin-bottom: 25px; overflow: hidden;">
            <div style="background-color: #fef2f2; padding: 15px 25px; border-bottom: 1px solid #fecaca;">
                <h3 style="margin: 0; color: #b91c1c; font-size: 16px; display: flex; align-items: center; gap: 8px;">🔒 Información Interna</h3>
            </div>
            <div style="padding: 25px; display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px;">
                
                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Número de Páginas</label>
                    <input type="number" name="paginas" value="{{ $material->paginas ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none;">
                </div>
                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Solicitado Por</label>
                    <input type="text" name="solicitado_por" value="{{ $material->solicitado_por ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none;">
                </div>
                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Tipo de Adquisición</label>
                    <select name="adquisicion" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none; background: white;">
                        <option value="">Seleccionar...</option>
                        <option value="Compra" {{ ($material->adquisicion ?? '') == 'Compra' ? 'selected' : '' }}>Compra</option>
                        <option value="Donación" {{ ($material->adquisicion ?? '') == 'Donación' ? 'selected' : '' }}>Donación</option>
                    </select>
                </div>
                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Precio ($)</label>
                    <input type="number" step="0.01" name="precio" value="{{ $material->precio ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none;">
                </div>
                <div style="grid-column: span 1;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #475569; margin-bottom: 5px;">Fecha de Compra</label>
                    <input type="date" name="fecha_compra" value="{{ $material->fecha_compra ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none;">
                </div>

            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px;">
            <button type="button" onclick="if(confirm('¿Estás seguro de eliminar este material del catálogo?')) document.getElementById('form-delete').submit();" style="background-color: white; color: #e51d38; border: 1px solid #fecaca; padding: 12px 25px; border-radius: 6px; font-weight: bold; cursor: pointer; transition: 0.2s;" onmouseover="this.style.backgroundColor='#fef2f2'">🗑 Eliminar Material</button>
            
            <button type="submit" style="background-color: #10b981; color: white; border: none; padding: 12px 25px; border-radius: 6px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2); transition: 0.2s;" onmouseover="this.style.backgroundColor='#059669'">💾 Actualizar Material</button>
        </div>
    </form>

    <form id="form-delete" action="/materiales/{{ $material->id }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        // Función para actualizar la imagen al escribir la URL manualmente
        function actualizarImagen() {
            let url = document.getElementById('url_imagen').value;
            let preview = document.getElementById('preview_imagen');
            let texto = document.getElementById('texto_imagen');
            
            if(url) {
                preview.src = url;
                preview.style.display = 'block';
                texto.style.display = 'none';
            } else {
                preview.style.display = 'none';
                texto.style.display = 'block';
            }
        }

        // Función Mágica (Doble Motor TOTAL: Google Books + OpenLibrary)
        async function buscarISBN() {
            // Quitamos los guiones por si el usuario los pone (Ej. 978-607-...)
            const isbn = document.getElementById('isbn_input').value.trim().replace(/-/g, '');
            
            if (!isbn) {
                alert('⚠️ Por favor, ingresa un ISBN primero.');
                return;
            }

            document.body.style.cursor = 'wait';

            try {
                // ==========================================
                // MOTOR 1: BÚSQUEDA EN GOOGLE BOOKS
                // ==========================================
                const resGoogle = await fetch(`https://www.googleapis.com/books/v1/volumes?q=isbn:${isbn}`);
                const dataGoogle = await resGoogle.json();

                if (dataGoogle.totalItems > 0) {
                    const libro = dataGoogle.items[0].volumeInfo;

                    if(libro.title) document.querySelector('input[name="titulo"]').value = libro.title;
                    if(libro.authors) document.querySelector('input[name="autor"]').value = libro.authors.join(', ');
                    if(libro.publisher) document.querySelector('input[name="editorial"]').value = libro.publisher;
                    if(libro.publishedDate) document.querySelector('input[name="anio_publicacion"]').value = libro.publishedDate.substring(0, 4);
                    if(libro.pageCount) document.querySelector('input[name="paginas"]').value = libro.pageCount;

                    // Foto desde Google o OpenLibrary de respaldo
                    if(libro.imageLinks && libro.imageLinks.thumbnail) {
                        document.getElementById('url_imagen').value = libro.imageLinks.thumbnail.replace('http:', 'https:');
                    } else {
                        document.getElementById('url_imagen').value = `https://covers.openlibrary.org/b/isbn/${isbn}-L.jpg?default=false`;
                    }
                    
                    actualizarImagen(); 
                    alert('✅ ¡Datos obtenidos de Google Books!');
                    document.body.style.cursor = 'default';
                    return; // Terminamos aquí si Google funcionó
                }

                // ==========================================
                // MOTOR 2: BÚSQUEDA EN OPENLIBRARY (Si Google falla)
                // ==========================================
                const resOL = await fetch(`https://openlibrary.org/api/books?bibkeys=ISBN:${isbn}&format=json&jscmd=data`);
                const dataOL = await resOL.json();
                const key = `ISBN:${isbn}`;

                if (dataOL[key]) {
                    const libroOL = dataOL[key];

                    if(libroOL.title) document.querySelector('input[name="titulo"]').value = libroOL.title;
                    if(libroOL.authors) document.querySelector('input[name="autor"]').value = libroOL.authors.map(a => a.name).join(', ');
                    if(libroOL.publishers) document.querySelector('input[name="editorial"]').value = libroOL.publishers.map(p => p.name).join(', ');
                    
                    // Extraemos solo el año si viene la fecha completa
                    if(libroOL.publish_date) {
                        const anio = libroOL.publish_date.match(/\d{4}/);
                        document.querySelector('input[name="anio_publicacion"]').value = anio ? anio[0] : libroOL.publish_date;
                    }
                    if(libroOL.number_of_pages) document.querySelector('input[name="paginas"]').value = libroOL.number_of_pages;

                    // Foto desde OpenLibrary
                    if(libroOL.cover && libroOL.cover.large) {
                        document.getElementById('url_imagen').value = libroOL.cover.large;
                    } else {
                        document.getElementById('url_imagen').value = `https://covers.openlibrary.org/b/isbn/${isbn}-L.jpg?default=false`;
                    }
                    
                    actualizarImagen();
                    alert('✅ ¡Datos obtenidos del servidor de respaldo OpenLibrary!');
                } else {
                    // Si ya de plano ningún servidor lo tiene...
                    alert('❌ Este libro no existe en Google ni en OpenLibrary. Tendrás que capturar los datos manualmente.');
                }

            } catch (error) {
                console.error("Error buscando el ISBN:", error);
                alert('⚠️ Hubo un error de red al intentar conectar con los servidores.');
            } finally {
                document.body.style.cursor = 'default';
            }
        }
    </script>
@endsection