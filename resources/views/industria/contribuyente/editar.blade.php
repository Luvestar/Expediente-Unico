@extends('layouts.industria')

@section('title', 'Editar Contribuyente')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3>Editar Contribuyente</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('industria.contribuyente.actualizar', $contribuyente->id) }}" method="POST">
                @csrf
                <input type="hidden" name="pestania_token" id="pestania_token" value="">
                @method('PUT')

                <div class="row">
                    <div class="col-md-4">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $contribuyente->nombre }}" required>
                    </div>
                    <div class="col-md-4">
                        <label>Apellido Paterno</label>
                        <input type="text" name="apellido_paterno" class="form-control" value="{{ $contribuyente->apellido_paterno }}" required>
                    </div>
                    <div class="col-md-4">
                        <label>Apellido Materno</label>
                        <input type="text" name="apellido_materno" class="form-control" value="{{ $contribuyente->apellido_materno }}">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4">
                        <label>RFC</label>
                        <input type="text" name="rfc" class="form-control" value="{{ $contribuyente->rfc }}" required>
                    </div>
                    <div class="col-md-4">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ $contribuyente->telefono }}">
                    </div>
                    <div class="col-md-4">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $contribuyente->email }}">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Empresa</label>
                        <input type="text" name="nombre_empresa" class="form-control" value="{{ $contribuyente->nombre_empresa }}">
                    </div>
                    <div class="col-md-6">
                        <label>Giro Comercial</label>
                        <input type="text" name="giro_comercial" class="form-control" value="{{ $contribuyente->giro_comercial }}" required>
                    </div>
                </div>

                <div class="form-group mt-2">
                    <label>Dirección</label>
                    <textarea name="direccion" class="form-control" required>{{ $contribuyente->direccion }}</textarea>
                </div>

                <div class="form-group mt-2">
                    <label>Tipo de Persona</label>
                    <select name="tipo_persona" class="form-control" required>
                        <option value="fisica" {{ $contribuyente->tipo_persona == 'fisica' ? 'selected' : '' }}>Física</option>
                        <option value="moral" {{ $contribuyente->tipo_persona == 'moral' ? 'selected' : '' }}>Moral</option>
                    </select>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('industria.documentos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection