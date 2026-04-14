@extends('layouts.desarrollo')

@section('title', 'Agregar datos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>📋 Lista de contribuyentes</h4>
                </div>
                <div class="card-body">

                    {{-- BUSCADOR --}}
                    <form method="GET" action="{{ route('desarrollo.documentos.index') }}" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, RFC, empresa o giro..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('desarrollo.documentos.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Limpiar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    {{-- TABLA DE CONTRIBUYENTES CON PAGINACIÓN --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Empresa</th>
                                    <th>RFC</th>
                                    <th>Giro</th>
                                    <th>Teléfono</th>
                                    <th>Tipo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contribuyentes as $c)
                                <tr>
                                    <td>{{ $c->nombre }} {{ $c->apellido_paterno }} {{ $c->apellido_materno }}</td>
                                    <td>{{ $c->nombre_empresa ?? '—' }}</td>
                                    <td>{{ $c->rfc }}</td>
                                    <td>{{ $c->giro_comercial }}</td>
                                    <td>{{ $c->telefono ?? '—' }}</td>
                                    <td>
                                        @if($c->tipo_persona == 'fisica')
                                            <span class="badge badge-info">Física</span>
                                        @else
                                            <span class="badge badge-warning">Moral</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('desarrollo.documentos.cargar', $c->id) }}" class="btn btn-sm btn-success" title="Cargar datos">
                                            <i class="fas fa-upload"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay contribuyentes registrados</td
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- PAGINACIÓN --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $contribuyentes->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection