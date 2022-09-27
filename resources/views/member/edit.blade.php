@extends('adminlte::page')

@section('title', "Editar Miembro")

@section('content_header')
    <div class="my-3"></div>
    <h1>Editar Miembro</h1>
    <hr/>
    <div class="mb-3"></div>
@stop

@section('content')

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
                        <form action="{{ route('members.update',$Member->id ) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <h3>Datos del miembro</h3>
                            <hr/>
                            <div class="form-group">
                                <label for="user_id">Status</label>
                                <select class="form-control js-example-basic-single" name="status"
                                        id="status" required>
                                    <option value="1" @if($Member->status == 1) selected @endif>Activo</option>
                                    <option value="0" @if($Member->status == 0) selected @endif>Inactivo</option>
                                    <option value="2" @if($Member->status == 2) selected @endif>Defunción</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       placeholder="Nombre del miembro" aria-describedby="nameHelp"
                                       value="{{$Member->name}}"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="user_id">Iglesia</label>
                                <select class="form-control js-example-basic-single" name="user_id"
                                        id="user_id" required>
                                    @foreach ($Churches as $Church)
                                        <option value="{{ $Church->id }}"
                                                @if($Member->church->id == $Church->id) selected @endif>{{ $Church->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Imagen</label>
                                <div class="row my-3">
                                    <div class="rounded-circle" id="image_preview_container"
                                         style="background-image: url('{{ $Member->image() }}');
                                         width: 100px; height: 100px; background-size:cover ">
                                    </div>

                                </div>
                                <input type="file" name="image" id="image" class="form-control"
                                       placeholder="Imagen del miembro" aria-describedby="imageHelp">

                            </div>

                            <div class="form-check my-3">

                                <input type="checkbox" name="is_baptized" id="is_baptized" value="on"
                                       class="form-check-input" @if($Member->is_baptized) checked @endif>
                                <label class="form-check-label" for="is_baptized">Es Bautizado</label>
                            </div>

                            <div class="form-group" id="date_input"
                                 style=" @if(!$Member->is_baptized) display: none; @endif">
                                <label for="baptized_date">Fecha Bautizo</label>
                                <input type="date" name="baptized_date" id="baptized_date" class="form-control"
                                       placeholder="Fecha de bautizo" aria-describedby="baptizedHelp"
                                       value="{{$Member->baptized_date}}">
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

@section('js')

    // round image previewer
    <script>
        $(document).ready(function (e) {

            $('.js-example-basic-single').select2();

            const checkbox = document.getElementById('is_baptized')
            let dateInput = document.getElementById('date_input');

            checkbox.addEventListener('change', (event) => {
                if (event.currentTarget.checked) {
                    dateInput.style.display = "block";
                } else {
                    dateInput.style.display = "none";
                }
            })

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
