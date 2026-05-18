@extends('layouts.' . $layout)

@section('title', 'Orden de cobro')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-file-invoice-dollar mr-2"></i> Orden de cobro</h4>
                        <span class="badge badge-light">{{ $contribuyente->nombre }} {{ $contribuyente->apellido_paterno }}</span>
                    </div>
                </div>
                
                <div class="card-body">
                    <form action="{{ route($routeStore) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pestania_token" id="pestania_token" value="">
                        <input type="hidden" name="contribuyente_id" value="{{ $contribuyente->id }}">
                        <input type="hidden" name="orden_id" value="{{ $orden->id ?? '' }}">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-secondary text-white">
                                        <h5 class="mb-0"><i class="fas fa-file-pdf mr-2"></i> Orden de cobro</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Documento PDF</label>
                                            <div class="custom-file">
                                                <input type="file" name="orden_cobro_pdf" class="custom-file-input @error('orden_cobro_pdf') is-invalid @enderror" id="ordenPdf" accept=".pdf">
                                                <label class="custom-file-label" for="ordenPdf" id="ordenPdfLabel">Seleccionar archivo PDF...</label>
                                                @error('orden_cobro_pdf')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <small class="form-text text-muted">Formatos permitidos: PDF. Tamaño máximo: 5MB</small>
                                        </div>
                                        
                                        @if(isset($orden) && $orden->orden_cobro_exists)
                                            <div class="mt-3 p-2 bg-light rounded">
                                                <i class="fas fa-check-circle text-success"></i>
                                                <strong>Archivo actual:</strong>
                                                <a href="{{ route('ingresos.orden.cobro.ver', ['id' => $orden->id, 'tipo' => 'orden']) }}" target="_blank" class="ml-2">
                                                    <i class="fas fa-eye"></i> Ver PDF actual
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-secondary text-white">
                                        <h5 class="mb-0"><i class="fas fa-calculator mr-2"></i> Cotización</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Documento PDF</label>
                                            <div class="custom-file">
                                                <input type="file" name="cotizacion_pdf" class="custom-file-input @error('cotizacion_pdf') is-invalid @enderror" id="cotizacionPdf" accept=".pdf">
                                                <label class="custom-file-label" for="cotizacionPdf" id="cotizacionPdfLabel">Seleccionar archivo PDF...</label>
                                                @error('cotizacion_pdf')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <small class="form-text text-muted">Formatos permitidos: PDF. Tamaño máximo: 5MB</small>
                                        </div>
                                        
                                        @if(isset($orden) && $orden->cotizacion_exists)
                                            <div class="mt-3 p-2 bg-light rounded">
                                                <i class="fas fa-check-circle text-success"></i>
                                                <strong>Archivo actual:</strong>
                                                <a href="{{ route('ingresos.orden.cobro.ver', ['id' => $orden->id, 'tipo' => 'cotizacion']) }}" target="_blank" class="ml-2">
                                                    <i class="fas fa-eye"></i> Ver PDF actual
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12 text-right">
                                <a href="{{ route($routeBack) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Regresar
                                </a>
                                <button type="submit" class="btn btn-success ml-2">
                                    <i class="fas fa-save"></i> Guardar orden de cobro
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('ordenPdf').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Seleccionar archivo PDF...';
        document.getElementById('ordenPdfLabel').innerText = fileName;
    });
    
    document.getElementById('cotizacionPdf').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Seleccionar archivo PDF...';
        document.getElementById('cotizacionPdfLabel').innerText = fileName;
    });
</script>
@endpush
@endsection