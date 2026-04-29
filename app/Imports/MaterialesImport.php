<?php

namespace App\Imports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MaterialesImport implements ToModel, WithHeadingRow
{
    private static $contador = 0; 

    public function model(array $row)
    {
        $codigo = $row['codigo_bibupem'] ?? null;

        if (empty($codigo)) {
            $anioActual = date('Y');
            
            if (self::$contador === 0) {
                self::$contador = Material::whereYear('created_at', $anioActual)->count();
            }
            
            self::$contador++;
            $codigo = 'UPEM-' . $anioActual . '-' . str_pad(self::$contador, 4, '0', STR_PAD_LEFT);
        }

        return new Material([
            'titulo'         => $row['titulo'],
            'autor'          => $row['autor'] ?? 'Desconocido',
            
            // --- NUEVOS CAMPOS OPCIONALES AGREGADOS ---
            'isbn'           => $row['isbn'] ?? null,       // Si viene lo guarda, si no, lo deja en NULL
            'editorial'      => $row['editorial'] ?? null,  // Si viene lo guarda, si no, lo deja en NULL
            'edicion'        => $row['edicion'] ?? null,    // Si viene lo guarda, si no, lo deja en NULL
            // ------------------------------------------

            'codigo_bibupem' => $codigo, 
            'clasificacion'  => $row['clasificacion'] ?? 'Libro',
            'categoria'      => $row['categoria'] ?? 'General',
            'stock_fisico'   => $row['stock_fisico'] ?? 1,
            'visibilidad'    => $row['visibilidad'] ?? 'Público',
        ]);
    }
}