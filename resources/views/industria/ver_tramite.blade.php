@extends('layouts.industria')

@section('title', 'Ver trámite')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Trámite: {{ $actividad->tramite }}</h4>
        </div>
        <div class="card-body">
            <p><strong>Usuario:</strong> {{ $actividad->user->email }}</p>
            <p><strong>Contribuyente:</strong> {{ $actividad->contribuyente->nombre }} {{ $actividad->contribuyente->apellido_paterno }}</p>
            <p><strong>Empresa:</strong> {{ $actividad->contribuyente->nombre_empresa ?? '—' }}</p>
            <p><strong>RFC:</strong> {{ $actividad->contribuyente->rfc }}</p>
            <p><strong>Documentos subidos:</strong></p>
            <ul>
                @foreach(json_decode($actividad->documentos_subidos) as $doc)
                    <li>{{ $doc }}</li>
                @endforeach
            </ul>
            <a href="{{ route('industria.historial') }}" class="btn btn-secondary">Regresar</a>
        </div>
    </div>
</div>
@endsection