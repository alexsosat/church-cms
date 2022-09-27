@extends('adminlte::page')

@section('title', "Iglesias")

@section('content_header')
    <div class="my-3"></div>
    <h1>Iglesias</h1>
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
            <a href="{{ route("churches.create") }}" class="btn btn-success float-right">Agregar Iglesia</a>
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
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($Churches as $Church)
                        <tr>
                            <td>
                                <div class="rounded-circle"
                                     style="background-image: url('{{ $Church->image() }}'); width: 100px; height: 100px; background-size:cover">
                                </div>
                            </td>
                            <td class="align-middle">{{ $Church->name }}</td>
                            <td class="align-middle">{{ $Church->email }}</td>
                            <td class="align-middle">{{$Church->phone}}</td>
                            <td class="align-middle">{{$Church->fullAddress()}}</td>
                            <td class="align-middle">
                                <form action="{{ route('churches.delete') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('churches.edit', $Church->id) }}" class="btn btn-primary btn-sm">Editar</a>

                                    <input type="hidden" name="church_id" id="church_id" value="{{$Church->id}}">
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="deleteChurch()">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
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

        function deleteChurch() {
            event.preventDefault(); // prevent form submit
            var form = event.target.form;
            Swal.fire({
                title: '¿Está seguro de eliminar esta iglesia?',
                text: "Esta acción no se puede deshacer.",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Save',
            }).then((result) => {
                if (result.value === true) {
                    form.submit();
                } else {
                }
            })

        }
    </script>
@stop
