@extends('layouts.industria')

@section('title', 'Contribuyentes')

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

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <i class="icon fas fa-exclamation-triangle"></i> {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Contribuyentes</h3>
                    <div class="card-tools">
                        <a href="{{ route('industria.contribuyente.crear') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Nuevo Contribuyente
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- BUSCADOR -->
                    <form method="GET" action="{{ route('industria.contribuyentes') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, RFC, empresa..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('industria.contribuyentes') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Limpiar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <!-- TABLA DE CONTRIBUYENTES CON PAGINACIÓN -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
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
                                        <a href="{{ route('industria.contribuyente.editar', $c->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('industria.contribuyente.eliminar', $c->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar este contribuyente?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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