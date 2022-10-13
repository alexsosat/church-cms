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
                        <form action="{{ route('requests.store-receiving-request') }}" method="POST">
                            @csrf
                            @method('Post')
                            <h3>Formulario de Recepción de Miembros</h3>
                            <hr/>


                            <div class="form-group">
                                <label for="member">De</label>
                                <select class="form-control js-example-basic-single" name="church_id"
                                        id="church_id" onchange="onChurchSelect()" required>
                                    <option value="0">Todas</option>
                                    @foreach ($Churches as $Church)
                                        <option value="{{ $Church->id }}">{{ $Church->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="member">Miembros</label>
                                <select class="form-control" name="members[]" id="members" multiple>
                                    @foreach ($Members as $Member)
                                        <option value="{{ $Member->id }}">
                                            {{ $Member->name }} - {{ $Member->church->name }}
                                        </option>
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

            var membersSelect = $('select[name="members[]"]').bootstrapDualListbox({
                // see next for specifications
            });

            $('.js-example-basic-single').select2();

            membersSelect.bootstrapDualListbox('refresh', true);
        });

        function onChurchSelect() {
            var box = $('select[name="members[]"]').bootstrapDualListbox({
                // see next for specifications
            });
            const churchSelect = document.getElementById("church_id");
            const membersSelect = document.getElementById('members');
            const members = [
                    @foreach ($Members as $Member)
                {
                    id: {{ $Member->id }},
                    name: "{{ $Member->name }}",
                    church_id: {{ $Member->user_id }},
                    church_name: "{{ $Member->church->name }}",
                },
                @endforeach
            ];

            let options = members;

            if (churchSelect.value != 0) {
                options = members.filter(member => member.church_id == churchSelect.value);
            }


            let str = "";
            for (const item of options) {
                str += `<option value="${item.id}">` + `${item.name} - ${item.church_name}` + "</option>"
            }

            membersSelect.innerHTML = str;

            box.bootstrapDualListbox('refresh', true);

        }


    </script>
@stop
