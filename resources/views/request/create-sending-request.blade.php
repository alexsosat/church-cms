@extends('adminlte::page')

@section('title', "Crear Solicitud")

@section('content_header')
    <div class="my-3"></div>
    <h1>Crear Solicitud</h1>
    <hr/>
    <div class="mb-3"></div>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('requests.store-sending-request') }}" method="POST">
                            @csrf
                            @method('Post')
                            <h3>Formulario de Envío de Miembros</h3>
                            <hr/>
                            <div class="form-group">
                                <label for="member">Miembros</label>
                                <select class="form-control" name="members[]" id="members" multiple>
                                    @foreach ($Members as $Member)
                                        <option value="{{ $Member->id }}">
                                            {{ $Member->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="member">A</label>
                                <select class="form-control js-example-basic-single" name="authorizing_user"
                                        id="authorizing_user" required>
                                    @foreach ($Churches as $Church)
                                        <option value="{{ $Church->id }}">{{ $Church->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-5"></div>


                            <button type="submit" class="btn btn-primary w-100">Guardar</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href={{ asset("css/bootstrap-duallistbox.css") }}>
@stop

@section('js')
    <script src={{ asset("js/jquery.bootstrap-duallistbox.min.js") }}></script>
    <script>
        $(document).ready(function (e) {

            $('select[name="members[]"]').bootstrapDualListbox({
                // see next for specifications
            });

            $('.js-example-basic-single').select2();


        });
    </script>
@stop
