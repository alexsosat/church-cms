@extends('adminlte::page')

@section('title', "Solicitudes")

@section('content_header')
    <div class="my-3"></div>
    <h1>Solicitudes</h1>
    <hr/>
    <div class="mb-3"></div>
@stop

@section('content')

    @if (session('success'))
        <div class="col-sm-12">
            <div class="alert  alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="col-sm-12">
            <div class="alert  alert-warning alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <span><p>{{ $error }}</p></span>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-end">
            <a href="{{ route("requests.create-sending-request") }}" class="btn btn-success mr-5">Solicitud de envío</a>
            <a href="{{ route("requests.create-receiving-request") }}" class="btn btn-success mr-3">Solicitud de
                recibir</a>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills w-100 d-flex justify-content-around">
                    <li class="nav-item">
                        <a class="nav-link active" href="#AuthorizeRequest" data-toggle="tab">Por aceptar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#StatusRequest" data-toggle="tab">Status de solictudes</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="AuthorizeRequest">
                        <form action="{{ route('requests.single-request-action') }}" method="POST" id="statusForm">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="request_id" id="request_id">

                            <input type="hidden" name="status" id="status">


                        </form>
                        <table id="authorizeTable" class="table table-striped display nowrap" style="width:100%">
                            <thead>
                            <tr>

                                <th>Miembro</th>
                                <th>Tipo</th>
                                <th>De</th>
                                <th>A</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($AuthorizingRequests as $Request)
                                <tr>

                                    <td class="align-middle">{{ $Request->member->name }}</td>
                                    <td class="align-middle">
                                        @if($Request->type == 1)
                                            Solicitud
                                        @else
                                            Envio
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if($Request->type == 1)
                                            {{ $Request->requester->name }}
                                        @else
                                            {{ $Request->authorizer->name }}
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if($Request->type == 1)
                                            {{ $Request->authorizer->name }}
                                        @else
                                            {{ $Request->requester->name }}
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @switch($Request->status)
                                            @case(1)
                                                <span class="badge badge-success">Aceptada</span>
                                                @break
                                            @case(0)
                                                <span class="badge badge-danger">Denegada</span>
                                                @break
                                            @case(2)
                                                <span class="badge badge-warning">Pendiente</span>
                                                @break
                                            @case(3)
                                                <span class="badge badge-secondary">Cancelada</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="align-middle">

                                        @if($Request->status == 2)
                                            <button class="btn btn-success btn-sm" type="submit"
                                                    onclick="requestStatus(1, {{$Request->id}})">
                                                Aceptar
                                            </button>
                                            <button class="btn btn-danger btn-sm" type="submit"
                                                    onclick="requestStatus(0, {{$Request->id}})">
                                                Rechazar
                                            </button>

                                        @endif


                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>

                                <th>Miembro</th>
                                <th>Tipo</th>
                                <th>De</th>
                                <th>A</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="tab-pane" id="StatusRequest">

                        <form action="{{ route('requests.single-request-cancel') }}" method="POST" id="cancelRequest">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="request_id" id="request_id">
                        </form>

                        <table id="statusTable" class="table table-striped display nowrap" style="width:100%">
                            <thead>
                            <tr>

                                <th>Miembro</th>
                                <th>Tipo</th>
                                <th>De</th>
                                <th>A</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($StatusRequest as $Request)
                                <tr>

                                    <td class="align-middle">{{ $Request->member->name }}</td>
                                    <td class="align-middle">
                                        @if($Request->type == 1)
                                            Enviar
                                        @else
                                            Solicitar
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if($Request->type == 1)
                                            {{ $Request->requester->name }}
                                        @else
                                            {{ $Request->authorizer->name }}
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if($Request->type == 1)
                                            {{ $Request->authorizer->name }}
                                        @else
                                            {{ $Request->requester->name }}
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @switch($Request->status)
                                            @case(1)
                                                <span class="badge badge-success">Aceptada</span>
                                                @break
                                            @case(0)
                                                <span class="badge badge-danger">Denegada</span>
                                                @break
                                            @case(2)
                                                <span class="badge badge-warning">Pendiente</span>
                                                @break
                                            @case(3)
                                                <span class="badge badge-secondary">Cancelada</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="align-middle">
                                        @if($Request->status == 2)
                                            <button class="btn btn-secondary btn-sm" type="submit"
                                                    onclick="requestStatus(1, {{$Request->id}})">
                                                Cancelar
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Miembro</th>
                                <th>Tipo</th>
                                <th>De</th>
                                <th>A</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop


@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
@stop



@section('js')
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#authorizeTable').DataTable(
                {
                    responsive: true,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
                    }
                }
            );


            $('#statusTable').DataTable(
                {
                    responsive: true,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
                    }
                }
            );
        });


        function requestStatus(status, request_id) {
            event.preventDefault(); // prevent form submit

            if (status === 0) {
                Swal.fire({
                    title: '¿Está seguro de denegar esta solicitud?',
                    text: "Esta acción no se puede deshacer.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                }).then((result) => {
                    if (result.value === true) {
                        var form = document.getElementById("statusForm");
                        form.elements["request_id"].value = request_id;
                        form.elements["status"].value = status;

                        form.submit();
                    } else {
                    }
                })
            } else if (status === 1) {
                Swal.fire({
                    title: '¿Está seguro de aceptar esta solicitud?',
                    text: "Esta acción no se puede deshacer.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                }).then((result) => {
                    if (result.value === true) {
                        var form = document.getElementById("statusForm");
                        form.elements["request_id"].value = request_id;
                        form.elements["status"].value = status;

                        form.submit();
                    } else {
                    }
                })
            } else if (status === 3) {
                Swal.fire({
                    title: '¿Está seguro de cancelar esta solicitud?',
                    text: "Esta acción no se puede deshacer.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                }).then((result) => {
                    if (result.value === true) {
                        var form = document.getElementById("cancelRequest");
                        form.elements["request_id"].value = request_id;

                        form.submit();
                    } else {
                    }
                })
            }


        }


    </script>
@stop
