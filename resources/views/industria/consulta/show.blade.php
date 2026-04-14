@extends('layouts.industria')

@section('title', 'Detalle de trámite')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5>📄 Detalle del trámite</h5>
        </div>
        <div class="card-body">
            <p><strong>Contribuyente:</strong> {{ $contribuyente->nombre }} {{ $contribuyente->apellido_paterno }}</p>
            <p><strong>RFC:</strong> {{ $contribuyente->rfc }}</p>
            <p><strong>Empresa:</strong> {{ $contribuyente->nombre_empresa ?? '—' }}</p>
            <p><strong>Fecha:</strong> {{ $tramites->first()->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Documentos subidos:</strong></p>
            <ul>
                @foreach(json_decode($tramites->first()->archivos) as $nombre => $ruta)
                    <li>
                        {{ $nombre }}
                        <a href="{{ asset('storage/' . $ruta) }}" target="_blank" class="btn btn-sm btn-secondary">
                            <i class="fas fa-download"></i> Ver PDF
                        </a>
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('industria.consultar') }}" class="btn btn-secondary">Regresar</a>
        </div>
    </div>
</div>
@endsection