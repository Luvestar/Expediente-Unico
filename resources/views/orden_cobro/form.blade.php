@extends('layouts.' . $layout)

@section('title', 'Orden de cobro')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4><i class="fas fa-file-invoice-dollar"></i> Orden de cobro</h4>
    </div>
    <div class="card-body">
        <h5>Contribuyente: <strong>{{ $contribuyente->nombre }} {{ $contribuyente->apellido_paterno }}</strong></h5>
        <hr>
        
        <form action="{{ route($routeStore) }}" method="POST">
            @csrf
            <input type="hidden" name="contribuyente_id" value="{{ $contribuyente->id }}">
            <input type="hidden" name="orden_id" value="{{ $orden->id ?? '' }}">
            
            <div class="row">
                {{-- COLUMNA 1: Folio y Orden de cobro --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-hashtag"></i> Número de folio</label>
                        <input type="text" name="folio" class="form-control" 
                               value="{{ old('folio', $orden->folio ?? '') }}" 
                               placeholder="Ej: IND-202504-001" required>
                        <small class="text-muted">Ingrese un folio único para esta orden</small>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-file-alt"></i> Orden de cobro</label>
                        <textarea name="orden_cobro" class="form-control" rows="15" 
                                  placeholder="Escriba la orden de cobro...">{{ old('orden_cobro', $orden->orden_cobro ?? '') }}</textarea>
                    </div>
                </div>
                
                {{-- COLUMNA 2: Cotización --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-calculator"></i> Cotización</label>
                        <textarea name="cotizacion" class="form-control" rows="15" 
                                  placeholder="Escriba la cotización...">{{ old('cotizacion', $orden->cotizacion ?? '') }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="text-right mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar orden de cobro
                </button>
                <a href="{{ route($routeBack) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection