<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de trabajo</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-xs-12">
                <h1 class="text-center"><b>Reporte Mantenimiento</b></h1>
                <hr>
            </div>
            <div class="col-xs-12">
                <h4 class="text-end">
                    <b>Resumen General</b>
                </h4>
            </div>
            <div class="col-xs-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center">
                            <b>Información del Personal</b>
                        </h5>
                    </div>
                    <div class="card-body  p-0">
                        <table class="table m-0">
                            <colgroup>
                                <col class="col-xs-4">
                                <col class="col-xs-8">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td class="table-active"><b>Nombre</b></td>
                                    <td>{{$maintenance['user']['full_name']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Identificación</b></td>
                                    <td>{{$maintenance['user']['identification']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Correo</b></td>
                                    <td>{{$maintenance['user']['email']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center">
                            <b>Información del Vehículo</b>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table m-0">
                            <colgroup>
                                <col class="col-xs-4">
                                <col class="col-xs-8">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td class="table-active"><b>Placa</b></td>
                                    <td> {{$maintenance['vehicle']['plate']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Chasis</b></td>
                                    <td> {{$maintenance['vehicle']['chassis']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Tipo de Vehículo</b></td>
                                    <td> {{$maintenance['vehicle']['vehicle_type']}} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center">
                            <b>Información del Turno</b>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table m-0">
                            <colgroup>
                                <col class="col-xs-4">
                                <col class="col-xs-8">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td class="table-active"><b>Estado del Turno</b></td>
                                    <td> {{$maintenance['status_label']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Horario del Turno</b></td>
                                    <td> {{$maintenance['shift_time_range']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Fecha del Turno</b></td>
                                    <td> {{$maintenance['shift_date']}} </td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Detalles</b></td>
                                    <td> {{$maintenance['description'] ?? 'No existen detalles'}}  </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- RESUMEN ORDEN DE RECEPCION -->
            <div class="col-xs-12 mt-4">
                <h4 class="text-end">
                    <b>Resumen Orden de Recepción</b>
                </h4>
            </div>
            <div class="col-xs-6 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center">
                            <b>Información de Recepción</b>
                        </h5>
                    </div>
                    <div class="card-body  p-0">
                        <table class="table m-0">
                            <colgroup>
                                <col class="col-xs-4">
                                <col class="col-xs-8">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td class="table-active"><b>Nombre Personal Entrega</b></td>
                                    <td>{{$maintenance['order_start']['u_delivery']['full_name']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Identificación Personal Entrega</b></td>
                                    <td>{{$maintenance['order_start']['u_delivery']['identification']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Correo</b></td>
                                    <td>{{$maintenance['order_start']['u_delivery']['email']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Hora de la Recepción</b></td>
                                    <td>{{$maintenance['order_start']['schedule']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Fecha de la Recepción</b></td>
                                    <td>{{$maintenance['order_start']['admission_date_formatted']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Kilometraje Actual</b></td>
                                    <td>{{$maintenance['order_start']['current_mileage']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Detalles</b></td>
                                    <td>{{$maintenance['order_start']['detail'] ?? 'No existen detalles'}}</td>
                                </tr>
                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- RESUMEN ORDEN DE TRABAJO -->
            <div class="col-xs-12 mt-4">
                <h4 class="text-end">
                    <b>Resumen Orden de Entrega</b>
                </h4>
            </div>
            <div class="col-xs-6 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center">
                            <b>Información de Entrega</b>
                        </h5>
                    </div>
                    <div class="card-body  p-0">
                        <table class="table m-0">
                            <colgroup>
                                <col class="col-xs-4">
                                <col class="col-xs-8">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td class="table-active"><b>Nombre Personal Recibe</b></td>
                                    <td>{{$maintenance['order_end']['u_receives']['full_name']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Identificación Personal Recibe</b></td>
                                    <td>{{$maintenance['order_end']['u_receives']['identification']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Correo</b></td>
                                    <td>{{$maintenance['order_end']['u_receives']['email']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Hora de la Recepción</b></td>
                                    <td>{{$maintenance['order_end']['schedule']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Fecha de la Recepción</b></td>
                                    <td>{{$maintenance['order_end']['departure_date_formatted']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Próximo Kilometraje</b></td>
                                    <td>{{$maintenance['order_end']['next_mileage']}}</td>
                                </tr>
                                <tr>
                                    <td class="table-active"><b>Observaciones</b></td>
                                    <td>{{$maintenance['order_end']['detail'] ?? 'No existen observaciones'}}</td>
                                </tr>
                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- RESUMEN MANTENIMIENTOS -->
            <div class="col-xs-12 mt-4">
                <h4 class="text-end">
                    <b>Resumen Mantenimientos</b>
                </h4>
            </div>
            
            <div class="col-xs-12">
                <ul class="list-group mt-3">
                    <!-- Entra al foreach -->
                    @foreach ( $maintenance['maintenance_types'] as $mt )              
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-xs-12 p-3 ml-2">
                                    <h5 class="text-end">
                                        <b>{{$mt['name']}}</b>
                                    </h5>
                                </div>
                                <div class="col-xs-12">
                                    <table class="table m-0">
                                        <colgroup>
                                            <col class="col-xs-4">
                                            <col class="col-xs-8">
                                        </colgroup>
                                        <tbody>
                                            <tr>
                                                <td class="table-active"><b>Nombre</b></td>
                                                <td>{{$mt['name']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-active"><b>Precio</b></td>
                                                <td>{{$mt['price']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-active"><b>Descripción</b></td>
                                                <td>{{$mt['detail']['desciption']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-active"><b>Listado de cambios</b></td>
                                                <td>
                                                    <ul class="list-group">
                                                        <!-- Inicia el foreach -->
                                                        @foreach ($mt['detail']['list'] as $list )
                                                            <li class="list-group-item">
                                                                {{$list}}
                                                            </li>
                                                        @endforeach
                                                        <!-- Termina el foreach -->
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- Finaliza el foreach -->

            <!-- RESUMEN CONTRATOS -->
            <div class="col-xs-12 mt-4">
                <h4 class="text-end">
                    <b>Resumen Contratos</b>
                </h4>
            </div>
            
            <div class="col-xs-12">
                <ul class="list-group mt-3">
                    <!-- Entra al foreach -->
                    @foreach ( $maintenance['contracts'] as $contract )
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-xs-12 p-3 ml-2">
                                    <h5 class="text-end">
                                        <b>{{$contract['name']}}</b>
                                    </h5>
                                </div>
                                <div class="col-xs-12 ">
                                    <table class="table m-0">
                                        <colgroup>
                                            <col class="col-xs-4">
                                            <col class="col-xs-8">
                                        </colgroup>
                                        <tbody>
                                            <tr>
                                                <td class="table-active"><b>Nombre</b></td>
                                                <td>{{$contract['name']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-active"><b>Precio</b></td>
                                                <td>{{$contract['price']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-active"><b>Descripción</b></td>
                                                <td>{{$contract['detail']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="table-active"><b>Listado de Repuestos</b></td>
                                                <td class="p-0">
                                                    <!-- INICIA EL FOREACH -->
                                                    <table class="table table-striped table-borderless">
                                                        <colgroup>
                                                            <col class="col-xs-5">
                                                            <col class="col-xs-5">
                                                            <col class="col-xs-2">
                                                        </colgroup>
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>Marca</th>
                                                                <th  class="text-center">Precio</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($contract['spares'] as  $spare)
                                                                <tr>
                                                                    <td>{{$spare['name']}}</td>
                                                                    <td>{{$spare['brand']}}</td>
                                                                    <td  class="text-center">{{$spare['price']}}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <!-- TERMINA EL FOREACH -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- Finaliza el foreach -->

            <!-- RESUMEN PRECIOS -->
            <div class="col-xs-12 mt-4">
                <h4 class="text-end">
                    <b>Resumen Precios</b>
                </h4>
            </div>
            <div class="col-xs-9 mt-3 mb-5">
                <table class="table table-bordered m-0">
                    <colgroup>
                        <col class="col-xs-6">
                        <col class="col-xs-6">
                    </colgroup>
                    <tbody>
                        <!-- FOREACH MANTENIMIENTO -->
                       @foreach ($maintenance['maintenance_types'] as $mt)
                            <tr>
                                <td class="table-active">{{$mt['name']}}</td>
                                <td  class="text-center">{{$mt['price']}}</td>
                            </tr>
                       @endforeach
                        <!-- FOREACH CONTRATOS -->
                        @foreach ($maintenance['contracts'] as $contract)
                            <tr>
                                <td class="table-active">{{$contract['name']}}</td>
                                <td class="text-center">{{$contract['price']}}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td class="table-active"><b>SUBTOTAL</b></td>
                            <td  class="text-center"><b>{{$prices['subtotal']}}</b></td>
                        </tr>
                        <tr>
                            <td class="table-active"><b>IVA 12%</b></td>
                            <td class="text-center"><b>{{$prices['iva']}}</b></td>
                        </tr>
                        <tr>
                            <td class="table-active"><b>TOTAL</b></td>
                            <td  class="text-center"><b>{{$prices['total']}}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>

</html>