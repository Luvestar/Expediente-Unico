@extends('layouts.industria')

@section('title', 'Cargar Documentos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <i class="icon fas fa-check"></i> {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>📄 CARGA DE DOCUMENTOS - INDUSTRIA Y COMERCIO</h4>
                </div>
                <div class="card-body">

                    @if($contribuyenteSeleccionado)
                        <h5>Contribuyente: <strong>{{ $contribuyenteSeleccionado->nombre_empresa ?? $contribuyenteSeleccionado->nombre }}</strong></h5>
                        <hr>

                        <form action="{{ route('industria.documentos.guardar') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="contribuyente_id" value="{{ $contribuyenteSeleccionado->id }}">

                            <div class="accordion" id="accordionProcesos">
                                @include('industria.documentos.procesos.proceso1')
                                @include('industria.documentos.procesos.proceso2')
                                @include('industria.documentos.procesos.proceso3')
                                @include('industria.documentos.procesos.proceso4')
                                @include('industria.documentos.procesos.proceso5')
                                @include('industria.documentos.procesos.proceso6')
                                @include('industria.documentos.procesos.proceso7')
                                @include('industria.documentos.procesos.proceso8')
                                @include('industria.documentos.procesos.proceso9')
                                @include('industria.documentos.procesos.proceso10')
                                @include('industria.documentos.procesos.proceso11')
                                @include('industria.documentos.procesos.proceso12')
                            </div>

                            <div class="mt-4 d-flex justify-content-between">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-upload"></i> Subir documentos
                                </button>
                                <a href="{{ route('industria.documentos.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-arrow-left"></i> Regresar
                                </a>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            No se ha seleccionado ningún contribuyente. Por favor, regresa al listado y selecciona uno.
                        </div>
                        <a href="{{ route('industria.documentos.index') }}" class="btn btn-primary">Volver al listado</a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function marcarCargado(checkbox, id) {
        const fileInput = document.getElementById('file_' + id);
        const btnSubir = document.querySelector(`label[for="file_${id}"]`);
        
        if (checkbox.checked) {
            btnSubir.style.display = 'inline-block';
            fileInput.required = true;
        } else {
            btnSubir.style.display = 'none';
            fileInput.required = false;
            fileInput.value = '';
        }
    }
</script>
@endsection

@section('css')
<style>
    label[for^="file_"] {
        display: none;
        margin-left: 10px;
        cursor: pointer;
    }
    .requisito-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding: 5px 10px;
        border-radius: 5px;
        background-color: #f8f9fa;
    }
    .requisito-item:hover {
        background-color: #e9ecef;
    }
    .custom-control-label {
        font-weight: normal;
    }
</style>
@endsection