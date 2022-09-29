@extends('adminlte::page')

@section('title', "Editar Iglesia")

@section('content_header')
    <div class="my-3"></div>
    <h1>Editar Iglesia</h1>
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('churches.updateInfo', $User->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <h3>Datos de la iglesia</h3>
                            <hr/>
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       placeholder="Nombre de la Iglesia" aria-describedby="nameHelp"
                                       value="{{$User->name}}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                       placeholder="Email de la Iglesia" aria-describedby="emailHelp"
                                       value="{{$User->email}}" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Teléfono</label>
                                <input type="text" name="phone" id="phone"
                                       data-inputmask="'mask': ['[+99] 999-999-9999']"
                                       data-mask=""
                                       class="form-control" placeholder="Teléfono de la iglesia"
                                       value="{{$User->phone}}"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="image">Imagen</label>
                                <div class="row my-3">
                                    <div class="rounded-circle" id="image_preview_container"
                                         style="background-image: url('{{ $User->image() }}');
                                         width: 100px; height: 100px; background-size:cover ">
                                    </div>


                                </div>
                                <input type="file" name="image" id="image" class="form-control"
                                       placeholder="Logo de la Iglesia" aria-describedby="logoHelp">

                            </div>

                            <div class="mb-5"></div>


                            <button type="submit" class="btn btn-primary w-100">Guardar Datos</button>

                        </form>

                        <form action="{{ route('churches.updateCredentials', $User->id) }}" method="POST">

                            @csrf
                            @method('patch')


                            <h3 class="mt-5">Inicio de Sesión</h3>
                            <hr/>
                            <div class="form-group">
                                <label for="name">Usuario</label>
                                <input type="text" name="username" id="username" class="form-control"
                                       placeholder="Username" aria-describedby="nameHelp"
                                       value="{{$User->username}}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" name="password" id="password" class="form-control"
                                       placeholder="Contraseña" aria-describedby="passwordHelp">
                            </div>


                            <div class="mb-5"></div>


                            <button type="submit" class="btn btn-primary w-100">Guardar Nuevas Credenciales</button>

                        </form>

                        <form action="{{ route('churches.updateGeo', $User->id) }}" method="POST">

                            @csrf
                            @method('patch')

                            <h3 class="mt-5">Datos Geográficos</h3>
                            <hr/>
                            <div class="form-group">
                                <label for="address">Dirección</label>
                                <input type="text" name="address" id="address" class="form-control"
                                       placeholder="Dirección de la Iglesia" aria-describedby="addressHelp"
                                       value="{{$User->address}}" required>
                            </div>
                            <div class="form-group">
                                <label for="city">Ciudad</label>
                                <input type="text" name="city" id="city" class="form-control"
                                       placeholder="Ciudad de la Iglesia" aria-describedby="cityHelp"
                                       value="{{$User->municipality}}" required>
                            </div>
                            <div class="form-group">
                                <label for="state">Estado</label>
                                <input type="text" name="state" id="state" class="form-control"
                                       placeholder="Estado de la Iglesia" aria-describedby="stateHelp"
                                       value="{{$User->state}}" required>
                            </div>
                            <div class="form-group">
                                <label for="zip">Código Postal</label>
                                <input type="text" name="zip_code" id="zip_code" class="form-control"
                                       placeholder="Código Postal de la Iglesia" aria-describedby="zipHelp"
                                       value="{{$User->zip_code}}" required>
                            </div>

                            <div class="mb-5"></div>


                            <button type="submit" class="btn btn-primary w-100">Guardar Información Geográfica</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script src="{{asset("js/jquery.inputmask.min.js")}}"></script>


    <script>
        $(document).ready(function (e) {
            $('[data-mask]').inputmask();
            $('#image').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').css('background-image', 'url(' + e.target.result + ')');
                    $('#image_preview_container').hide();
                    $('#image_preview_container').fadeIn(650);
                }
                reader.readAsDataURL($(this)[0].files[0]);
            });
        });
    </script>
@stop
