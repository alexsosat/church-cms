@extends('adminlte::page')

@section('title', "Ver miembro")

@section('content_header')
    <div class="my-3"></div>
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
            <div class="col-md-3">

                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <div class="rounded-circle mx-auto"
                                 style="background-image: url('{{ $User->image() }}'); width: 100px; height: 100px; background-size:cover">
                            </div>
                        </div>
                        <h3 class="profile-username text-center">{{ $User->name }}</h3>
                        <p class="text-muted text-center">{{$User->role->title}}</p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Usuario</b>
                                <a class="float-right">
                                    @if($User->email != null)
                                        {{$User->username}}
                                    @else
                                        -
                                    @endif
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>Email de contacto</b>
                                <a class="float-right">
                                    @if($User->email != null)
                                        {{$User->email}}
                                    @else
                                        -
                                    @endif
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>Teléfono</b>
                                <a class="float-right">
                                    @if($User->phone != null)
                                        {{$User->phone}}
                                    @else
                                        -
                                    @endif
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>Dirección</b>
                                <a class="float-right">
                                    {{$User->fullAddress()}}
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>


            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#infoForm"
                                                    data-toggle="tab">Cambiar Datos</a></li>
                            <li class="nav-item"><a class="nav-link" href="#passwordForm"
                                                    data-toggle="tab">Cambiar Contraseña</a></li>
                            <li class="nav-item"><a class="nav-link" href="#loginForm"
                                                    data-toggle="tab">Cambiar Credenciales</a></li>
                            <li class="nav-item"><a class="nav-link" href="#geoForm"
                                                    data-toggle="tab">Cambiar Ubicación</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">

                            <div class="tab-pane active" id="infoForm">
                                <form action="{{ route('profile.update_info') }}" method="POST"
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

                            </div>

                            <div class="tab-pane" id="passwordForm">
                                <h3>Cambiar Contraseña</h3>
                                <hr/>
                                <form action="{{ route('profile.update_password') }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <div class="form-group">
                                        <label for="prevPsswd" class="col-form-label">Contraseña actual</label>
                                        <div>
                                            <input type="password" class="form-control" name="prevPsswd" id="prevPsswd"
                                                   placeholder="Contraseña actual">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="newPsswd" class="col-form-label">Nueva Contraseña</label>
                                        <div>
                                            <input type="password" class="form-control" name="newPsswd" id="newPsswd"
                                                   placeholder="Nueva Contraseña">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmPsswd" class="col-form-label">Confirmar
                                            Contraseña</label>
                                        <div>
                                            <input type="password" class="form-control" name="confirmPsswd"
                                                   id="confirmPsswd"
                                                   placeholder="Confirmar Contraseña">
                                        </div>
                                    </div>
                                    <div class="my-5"></div>
                                    <button type="submit" class="btn btn-primary w-100">Guardar Nueva Contraseña
                                    </button>
                                </form>
                            </div>

                            <div class="tab-pane" id="loginForm">
                                <form action="{{ route('profile.update_credentials') }}" method="POST">

                                    @csrf
                                    @method('patch')


                                    <h3>Credenciales</h3>
                                    <hr/>
                                    <div class="form-group">
                                        <label for="name">Nombre de usuario</label>
                                        <input type="text" name="username" id="username" class="form-control"
                                               placeholder="Nombre de la Iglesia" aria-describedby="nameHelp"
                                               value="{{$User->username}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Correo de contacto</label>
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

                                    <div class="mb-5"></div>


                                    <button type="submit" class="btn btn-primary w-100">Guardar Nuevas Credenciales
                                    </button>

                                </form>
                            </div>

                            <div class="tab-pane" id="geoForm">
                                <form action="{{ route('profile.update_geo') }}" method="POST">

                                    @csrf
                                    @method('patch')

                                    <h3>Datos Geográficos</h3>
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


                                    <button type="submit" class="btn btn-primary w-100">Guardar Información Geográfica
                                    </button>

                                </form>

                            </div>

                        </div>


                    </div>
                </div>

            </div>

        </div>

    </div>
@stop

@section('js')
    <script src="{{asset("js/jquery.inputmask.min.js")}}"></script>

    // round image previewer
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
