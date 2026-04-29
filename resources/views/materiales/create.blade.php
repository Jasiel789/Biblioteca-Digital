@extends('layouts.admin')

@section('contenido')
    <style>
        .form-section { background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02); margin-bottom: 25px; overflow: hidden; }
        .form-header { padding: 20px 30px; border-bottom: 1px solid #e2e8f0; background-color: #f8fafc; }
        .form-header h3 { margin: 0; font-size: 18px; display: flex; align-items: center; gap: 8px; }
        .form-body { padding: 30px; }
        
        .grid-row { display: grid; grid-template-columns: repeat(12, 1fr); gap: 20px; margin-bottom: 20px; }
        .col-span-12 { grid-column: span 12; }
        .col-span-8 { grid-column: span 8; }
        .col-span-6 { grid-column: span 6; }
        .col-span-4 { grid-column: span 4; }
        .col-span-3 { grid-column: span 3; }

        .input-group { display: flex; flex-direction: column; gap: 6px; }
        .input-group label { font-weight: 600; color: #475569; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-control { padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 14px; transition: all 0.2s; background-color: #fcfcfc; }
        .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); background-color: #ffffff; }
        
        .btn-magico { background-color: #10b981; color: white; border: none; padding: 0 20px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.2s; display: flex; align-items: center; justify-content: center; white-space: nowrap; }
        .btn-magico:hover { background-color: #059669; }
    </style>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2 style="margin-top: 0; color: #311042; font-size: 26px; font-weight: 900; margin-bottom: 5px; letter-spacing: -0.5px;">Catalogar Nuevo Material</h2>
            <p style="color: #64748b; margin: 0; font-size: 14px;">Ingresa los datos del material manual o escaneando el ISBN.</p>
        </div>
        <a href="/materiales" style="background-color: white; color: #475569; padding: 10px 20px; border-radius: 8px; font-weight: bold; text-decoration: none; border: 1px solid #cbd5e1; transition: 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.02);" onmouseover="this.style.backgroundColor='#f8fafc'">
            Cancelar y Volver
        </a>
    </div>

    <form action="/materiales" method="POST">
        @csrf
        
        <div class="form-section">
            <div class="form-header">
                <h3 style="color: #1e293b;">Información Pública</h3>
            </div>
            
            <div class="form-body">
                
                <div class="grid-row" style="background-color: #f0fdf4; padding: 20px; border-radius: 8px; border: 1px solid #bbf7d0;">
                    <div class="input-group col-span-12">
                        <label style="color: #166534; font-size: 14px;">Escanear ISBN</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" name="isbn" id="isbn" class="form-control" placeholder="Apunta con la pistola láser aquí o teclea el ISBN..." style="flex: 1; border-color: #4ade80; border-width: 2px; font-size: 16px; font-weight: bold; color: #166534;">
                            <button type="button" id="btn-escaner" class="btn-magico" onclick="buscarDatosISBN()">
                                Autocompletar Datos
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid-row">
                    <div class="input-group col-span-8">
                        <label>Título del Material <span style="color: #e51d38;">*</span></label>
                        <input type="text" name="titulo" required class="form-control" placeholder="Título completo de la obra">
                    </div>
                    <div class="input-group col-span-4">
                        <label>Autor(es) <span style="color: #e51d38;">*</span></label>
                        <input type="text" name="autor" required class="form-control" placeholder="Nombre del autor o autores">
                    </div>
                </div>

                <div class="grid-row">
                    <div class="input-group col-span-4">
                        <label>Editorial</label>
                        <input type="text" name="editorial" class="form-control" placeholder="Ej. McGraw Hill">
                    </div>
                    <div class="input-group col-span-3">
                        <label>Edición</label>
                        <input type="text" name="edicion" class="form-control" placeholder="Ej. 3ra Edición">
                    </div>
                    <div class="input-group col-span-3">
                        <label>Año de Pub.</label>
                        <input type="text" name="fecha_publicacion" class="form-control" placeholder="Ej. 2023">
                    </div>
                    <div class="input-group col-span-2">
                        <label>Lugar Pub.</label>
                        <input type="text" name="lugar_publicacion" class="form-control" placeholder="Ej. México">
                    </div>
                </div>

                <div class="grid-row">
                    <div class="input-group col-span-4">
                        <label>Código BIBUPEM</label>
                        <input type="text" name="codigo_bibupem" class="form-control" placeholder="Auto-generado si se omite">
                    </div>
                    <div class="input-group col-span-4">
                        <label>Formato<span style="color: #e51d38;">*</span></label>
                        <select name="clasificacion" required class="form-control">
                            <option value="Libro Textual">Libro Textual</option>
                            <option value="Revista Científica">Revista Científica</option>
                            <option value="Tesis">Tesis de Titulación</option>
                            <option value="CD / DVD">CD / DVD / Software</option>
                            <option value="Manual">Manual de Laboratorio</option>
                        </select>
                    </div>
                    <div class="input-group col-span-4">
                        <label>Stock Físico <span style="color: #e51d38;">*</span></label>
                        <input type="number" name="stock_fisico" required value="1" min="0" class="form-control" style="font-weight: bold; color: #311042;">
                    </div>
                </div>

                <div class="grid-row" style="margin-bottom: 0;">
                    
                    <div class="col-span-6" style="display: flex; flex-direction: column; gap: 20px;">
                        
                        <div class="input-group">
                            <label>Categoria<span style="color: #e51d38;">*</span></label>
                            <select name="categoria" required class="form-control">
                                <option value="">Selecciona la temática...</option>
                                <option value="Programación y Software">Programación y Software</option>
                                <option value="Matemáticas y Física">Matemáticas y Física</option>
                                <option value="Redes y Telecomunicaciones">Redes y Telecomunicaciones</option>
                                <option value="Biotecnología">Biotecnología</option>
                                <option value="Negocios y Administración">Negocios y Administración</option>
                                <option value="General / Literatura">General / Literatura</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label>Visibilidad en Catálogo <span style="color: #e51d38;">*</span></label>
                            <select name="visibilidad" required class="form-control" style="background-color: #fef2f2; border-color: #fca5a5; color: #991b1b; font-weight: bold;">
                                <option value="Público">🟢 Público (Visible para todos los alumnos)</option>
                                <option value="Privado">🔴 Privado (Oculto / Solo consulta en biblioteca)</option>
                            </select>
                            <span style="font-size: 11px; color: #64748b;">* Usa "Privado" para publicacion privadas.</span>
                        </div>
                    </div>

                    <div class="col-span-6 input-group">
                        <label>Enlace de la Portada (URL)</label>
                        <div style="display: flex; gap: 15px; align-items: flex-start; background-color: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0; height: 100%;">
                            <input type="text" name="portada_url" id="portada_url" class="form-control" placeholder="https://..." style="flex: 1;">
                            
                            <div style="width: 70px; height: 95px; border: 1px dashed #cbd5e1; border-radius: 6px; display: flex; align-items: center; justify-content: center; overflow: hidden; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <img id="preview_portada" src="" style="max-width: 100%; max-height: 100%; display: none; object-fit: cover;">
                                <span id="preview_texto" style="font-size: 11px; color: #94a3b8; text-align: center;">Sin foto</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="form-section">
            <div class="form-header" style="background-color: #fef2f2; border-bottom-color: #fecaca;">
                <h3 style="color: #b91c1c;">Información Interna</h3>
            </div>
            
            <div class="form-body">
                <div class="grid-row" style="margin-bottom: 0;">
                    <div class="input-group col-span-3">
                        <label>Número de Páginas</label>
                        <input type="number" name="numero_paginas" class="form-control" placeholder="Ej. 350">
                    </div>
                    <div class="input-group col-span-3">
                        <label>Solicitado Por</label>
                        <input type="text" name="solicitado_por" class="form-control" placeholder="Profesor o Academia">
                    </div>
                    <div class="input-group col-span-2">
                        <label>Adquisición</label>
                        <select name="tipo_adquisicion" class="form-control">
                            <option value="">Seleccionar...</option>
                            <option value="Compra">Compra</option>
                            <option value="Donación">Donación</option>
                        </select>
                    </div>
                    <div class="input-group col-span-2">
                        <label>Precio ($)</label>
                        <input type="number" name="precio" step="0.01" class="form-control" placeholder="0.00">
                    </div>
                    <div class="input-group col-span-2">
                        <label>Fecha de Compra</label>
                        <input type="date" name="fecha_compra" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px; margin-bottom: 40px;">
            <button type="reset" style="background-color: white; color: #475569; border: 1px solid #cbd5e1; padding: 12px 30px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'">
                Limpiar Formulario
            </button>
            <button type="submit" style="background-color: #f59e0b; color: white; border: none; padding: 12px 40px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.2s; box-shadow: 0 4px 6px rgba(245, 158, 11, 0.2); font-size: 16px;" onmouseover="this.style.backgroundColor='#d97706'">
                Guardar Material
            </button>
        </div>

    </form>

    <script>
        document.getElementById('isbn').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); 
                buscarDatosISBN();
            }
        });

        async function buscarDatosISBN() {
            const isbnBuscado = document.getElementById('isbn').value.trim();
            const btn = document.getElementById('btn-escaner');

            if(!isbnBuscado) {
                alert('¡Ey! Primero escanea o teclea un número de ISBN.');
                return;
            }

            btn.innerHTML = 'Buscando...';
            btn.style.backgroundColor = '#059669';

            try {
                const respuesta = await fetch(`https://openlibrary.org/api/books?bibkeys=ISBN:${isbnBuscado}&jscmd=data&format=json`);
                const data = await respuesta.json();
                const libroData = data[`ISBN:${isbnBuscado}`];

                if(libroData) {
                    if(libroData.title) document.querySelector('input[name="titulo"]').value = libroData.title;
                    if(libroData.authors) document.querySelector('input[name="autor"]').value = libroData.authors.map(a => a.name).join(', ');
                    if(libroData.publishers) document.querySelector('input[name="editorial"]').value = libroData.publishers[0].name;
                    if(libroData.publish_date) document.querySelector('input[name="fecha_publicacion"]').value = libroData.publish_date;
                    if(libroData.number_of_pages) document.querySelector('input[name="numero_paginas"]').value = libroData.number_of_pages;

                    const urlPortada = `https://covers.openlibrary.org/b/isbn/${isbnBuscado}-L.jpg`;
                    document.getElementById('portada_url').value = urlPortada;
                    document.getElementById('preview_portada').src = urlPortada;
                    document.getElementById('preview_portada').style.display = 'block';
                    document.getElementById('preview_texto').style.display = 'none';

                    btn.innerHTML = '¡Autocompletado!';
                    setTimeout(() => {
                        btn.innerHTML = '🔍 Autocompletar Datos';
                        btn.style.backgroundColor = '#10b981';
                    }, 3000);

                } else {
                    alert('Este libro no está en la base de datos libre. Tendrás que capturar la información a mano.');
                    btn.innerHTML = 'Autocompletar Datos';
                    btn.style.backgroundColor = '#10b981';
                }
            } catch (error) {
                alert('Hubo un error de conexión a internet. Verifica tu red.');
                btn.innerHTML = 'Autocompletar Datos';
                btn.style.backgroundColor = '#10b981';
            }
        }

        document.getElementById('portada_url').addEventListener('input', function(e) {
            const url = e.target.value;
            if(url) {
                document.getElementById('preview_portada').src = url;
                document.getElementById('preview_portada').style.display = 'block';
                document.getElementById('preview_texto').style.display = 'none';
            } else {
                document.getElementById('preview_portada').style.display = 'none';
                document.getElementById('preview_texto').style.display = 'block';
            }
        });
    </script>
@endsection