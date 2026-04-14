@extends('layouts.desarrollo')

@section('title', 'Cargar Documentos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>📄 CARGA DE DOCUMENTOS - DESARROLLO URBANO</h4>
                </div>
                <div class="card-body">

                    <h5>Contribuyente: <strong>{{ $contribuyente->nombre_empresa ?? $contribuyente->nombre }}</strong></h5>
                    <hr>

                    <div class="accordion" id="accordionProcesos">
                        
                        {{-- PROCESO 1 --}}
                        @include('desarrollo.documentos.procesos.proceso1')

                        {{-- PROCESO 2 --}}
                        @include('desarrollo.documentos.procesos.proceso2')

                    </div>

                    {{-- BOTÓN REGRESAR --}}
                    <div class="mt-4">
                        <a href="{{ route('desarrollo.documentos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection