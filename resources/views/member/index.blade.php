@extends('adminlte::page')

@section('title', "Miembros")

@section('content_header')
    <div class="my-3"></div>
    <h1>Miembros</h1>
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
        <div class="col-md-12">
            <a href="{{ route("members.create") }}" class="btn btn-success float-right">Agregar Miembro</a>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <table id="example" class="table table-striped display nowrap" style="width:100%">
                    <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Iglesia</th>
                        <th>Bautizado</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($Members as $Member)
                        <tr>
                            <td>
                                <div class="rounded-circle"
                                     style="background-image: url('{{ $Member->image() }}'); width: 100px; height: 100px; background-size:cover">
                                </div>
                            </td>
                            <td class="align-middle">{{ $Member->name }}</td>
                            <td class="align-middle">{{$Member->church->name}}</td>
                            <td class="align-middle">
                                @if($Member->is_baptized)
                                    <span class="badge badge-success">
                                    @if($Member->baptized_date != null)
                                            <i class="fas fa-calendar-day mr-2"></i>
                                            {{ $Member->baptized_date }}
                                        @else
                                            Si
                                        @endif
                                    </span>
                                @else
                                    <span class="badge badge-danger">No</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($Member->status == 1)
                                    <span class="badge badge-success">Activo</span>
                                @elseif($Member->status == 0)
                                    <span class="badge badge-warning">Inactivo</span>
                                @else
                                    <span class="badge badge-secondary">Defunción</span>
                                @endif
                            </td>
                            <td class="align-middle">

                                <a href="{{ route('members.show', $Member->id) }}"
                                   class="btn btn-info btn-sm">Ver</a>

                                <a href="{{ route('members.edit', $Member->id) }}"
                                   class="btn btn-primary btn-sm">Editar</a>

                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Iglesia</th>
                        <th>Bautizado</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                    </tfoot>
                </table>
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
            $('#example').DataTable(
                {
                    responsive: true,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
                    }
                }
            );
        });

    </script>
@stop
