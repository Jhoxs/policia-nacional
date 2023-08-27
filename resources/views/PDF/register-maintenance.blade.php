<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Mantenimiento</title>
    <style>
        /* Estilos para el documento PDF */
        body {
            font-family: Arial, sans-serif;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
        }
        .data {
            font-size: 16px;
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <div class="section">
        <div class="section-title">Registro de Mantenimiento</div>
    </div>

    <div class="section">
        <div class="section-title">Información de la Persona</div>
        <div class="data">
            <p>Nombre del usuario: {{ $infoMaintenance->user->name }}</p>
            <p>Identificación: {{ $infoMaintenance->user->identification }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Información del Vehículo</div>
        <div class="data">
            <p>Placa: {{ $infoMaintenance->vehicle->plate }}</p>
            <p>Chasis: {{ $infoMaintenance->vehicle->chassis }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Información de la Dependencia</div>
        <div class="data">
            <p>Subcircuito: {{ $infoMaintenance->dependence->display_name }}</p>
            <!-- Agrega más información sobre la dependencia si es necesario -->
        </div>
    </div>

    <div class="section">
        <div class="section-title">Información del Turno</div>
        <div class="data">
            <p>Fecha del turno: {{ $infoMaintenance->maintenance['shift_date'] }}</p>
            <p>Horario del turno: {{ $infoMaintenance->maintenance['shift_range'] }}</p>
            <p>Kilometraje actual: {{ $infoMaintenance->maintenance['mileage'] }}</p>
            <p>Observaciones: {{ $infoMaintenance->maintenance['details']  }}</p>
        </div>
    </div>
</body>
</html>
