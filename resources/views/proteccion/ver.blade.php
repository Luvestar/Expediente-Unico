@extends('layouts.proteccion')

@section('title', 'Ver trámite')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4>📄 Detalle del trámite</h4>
        </div>
        <div class="card-body">
            <p><strong>Usuario:</strong> {{ $actividad->user->email }}</p>
            <p><strong>Fecha:</strong> {{ $actividad->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Trámite:</strong> {{ $actividad->tramite }}</p>
            <p><strong>Contribuyente:</strong> {{ $actividad->contribuyente->nombre }} {{ $actividad->contribuyente->apellido_paterno }}</p>
            <p><strong>Empresa:</strong> {{ $actividad->contribuyente->nombre_empresa ?? '—' }}</p>
            <p><strong>RFC:</strong> {{ $actividad->contribuyente->rfc }}</p>
            <p><strong>Documentos subidos:</strong></p>
            <ul>
                @foreach(json_decode($actividad->documentos_subidos) as $doc)
                    <li>{{ $doc }}</li>
                @endforeach
            </ul>
            <a href="{{ route('proteccion.historial') }}" class="btn btn-secondary">Regresar</a>
        </div>
    </div>
</div>
@endsection