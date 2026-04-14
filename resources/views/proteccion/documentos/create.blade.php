@extends('layouts.proteccion')

@section('title', 'Cargar Documentos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>📄 CARGA DE DOCUMENTOS - PROTECCIÓN CIVIL</h4>
                </div>
                <div class="card-body">

                    <h5>Contribuyente: <strong>{{ $contribuyente->nombre_empresa ?? $contribuyente->nombre }}</strong></h5>
                    <hr>

                    <div class="accordion" id="accordionProcesos">
                        
                        {{-- PROCESO 1 --}}
                        @include('proteccion.documentos.procesos.proceso1')

                        {{-- PROCESO 2 --}}
                        @include('proteccion.documentos.procesos.proceso2')

                    </div>

                    <div class="mt-4">
                        <a href="{{ route('proteccion.documentos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection