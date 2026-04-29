<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Pago - UPEMOR</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; margin: 20px; }
        .header { text-align: center; border-bottom: 4px solid #e51d38; padding-bottom: 15px; margin-bottom: 30px; }
        .title { color: #311042; margin: 0; font-size: 28px; font-weight: bold; }
        .subtitle { color: #f59e0b; margin: 5px 0 0 0; font-size: 14px; text-transform: uppercase; letter-spacing: 2px; }
        
        .info-box { background-color: #f8fafc; border: 1px solid #cbd5e1; padding: 15px; border-radius: 8px; margin-bottom: 30px; }
        .info-table { width: 100%; font-size: 14px; }
        .info-table th { text-align: left; color: #475569; padding: 5px; width: 20%; }
        .info-table td { font-weight: bold; color: #311042; padding: 5px; width: 30%; }

        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table th { background-color: #311042; color: white; padding: 12px; text-align: left; font-size: 14px; }
        .items-table td { border-bottom: 1px solid #cbd5e1; padding: 12px; font-size: 14px; }
        
        .total-box { text-align: right; font-size: 22px; color: #e51d38; font-weight: bold; margin-top: 20px; }
        
        .footer { position: fixed; bottom: 30px; width: 100%; text-align: center; font-size: 11px; color: #64748b; border-top: 1px solid #e2e8f0; padding-top: 15px; }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="title">Biblioteca Digital UPEMOR</h1>
        <p class="subtitle">Ficha Referenciada de Pago</p>
    </div>

    <div class="info-box">
        <table class="info-table">
            <tr>
                <th>Folio de Multa:</th>
                <td>#000{{ $multa->id }}</td>
                <th>Fecha de Emisión:</th>
                <td>{{ date('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Alumno:</th>
                <td>{{ $multa->user->name ?? 'N/A' }}</td>
                <th>Matrícula:</th>
                <td>{{ $multa->user->matricula ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <h3 style="color: #311042; font-size: 16px;">Detalles del Cargo Adicional</h3>
    <table class="items-table">
        <tr>
            <th>Concepto</th>
            <th>Material Relacionado</th>
            <th style="text-align: right;">Importe</th>
        </tr>
        <tr>
            <td>{{ $multa->motivo }}</td>
            <td>{{ $multa->prestamo->material->titulo ?? 'Material General' }}</td>
            <td style="text-align: right;">${{ number_format($multa->monto, 2) }}</td>
        </tr>
    </table>

    <div class="total-box">
        Total a Pagar: ${{ number_format($multa->monto, 2) }} MXN
    </div>

    <div class="footer">
        Este documento es un comprobante interno generado por el Sistema de Biblioteca Digital de la Universidad Politécnica del Estado de Morelos.<br>
        <strong>Imprima este documento y pase a caja administrativa para regularizar su estatus.</strong>
    </div>

</body>
</html>