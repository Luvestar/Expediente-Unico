@extends('layouts.ingresos')

@section('title', 'Historial')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            {{-- HEADER ESTÁTICO --}}
            <div class="sticky-header">
                {{-- TARJETAS DE RESUMEN --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $vigentes ?? 0 }}</h3>
                                <p>Documentos vigentes</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $proximos ?? 0 }}</h3>
                                <p>Próximos a vencer (30 días)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $vencidos ?? 0 }}</h3>
                                <p>Documentos vencidos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- EXPORTAR REPORTE --}}
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h4><i class="fas fa-download"></i> Exportar reporte</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ingresos.historial.exportar.csv') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Filtro</label>
                                <select name="filtro" id="filtro" class="form-control">
                                    <option value="hoy">Hoy</option>
                                    <option value="ayer">Ayer</option>
                                    <option value="rango">Rango personalizado</option>
                                </select>
                            </div>
                            <div class="col-md-3 rango-fecha" style="display: none;">
                                <label class="form-label">Fecha inicio</label>
                                <input type="date" name="fecha_inicio" class="form-control">
                            </div>
                            <div class="col-md-3 rango-fecha" style="display: none;">
                                <label class="form-label">Fecha fin</label>
                                <input type="date" name="fecha_fin" class="form-control">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-file-excel"></i> Exportar CSV
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- TÍTULO REGISTRO DE ACTIVIDAD --}}
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-list-alt"></i> Registro de actividad</h4>
                </div>
            </div>

            {{-- TABLA DE ACTIVIDAD CON SCROLL --}}
            <div class="table-scrollable">
                <div class="card-body p-0">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr class="bg-secondary text-white">
                                <th style="position: sticky; top: 0; background-color: #6c757d; z-index: 10;">Usuario</th>
                                <th style="position: sticky; top: 0; background-color: #6c757d; z-index: 10;">Fecha</th>
                                <th style="position: sticky; top: 0; background-color: #6c757d; z-index: 10;">Hora</th>
                                <th style="position: sticky; top: 0; background-color: #6c757d; z-index: 10;">Trámite</th>
                                <th style="position: sticky; top: 0; background-color: #6c757d; z-index: 10;">Documento</th>
                                <th style="position: sticky; top: 0; background-color: #6c757d; z-index: 10;">Contribuyente</th>
                                <th style="position: sticky; top: 0; background-color: #6c757d; z-index: 10;">Empresa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($actividades ?? [] as $a)
                            <tr>
                                <td>{{ $a->user->email ?? '—' }}</td>
                                <td>{{ $a->created_at->format('d/m/Y') }}</td>
                                <td>{{ $a->created_at->format('h:i A') }}</td>
                                <td><span class="badge badge-info">{{ $a->tramite ?? '—' }}</span></td>
                                <td>{{ $a->documento_nombre ?? '—' }}</td>
                                <td>{{ $a->contribuyente->nombre ?? '—' }} {{ $a->contribuyente->apellido_paterno ?? '' }}</td>
                                <td>{{ $a->contribuyente->nombre_empresa ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No hay registros de actividad</td
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TÍTULO VIGENCIA DE DOCUMENTOS --}}
            <div class="card-header bg-success text-white mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-clock"></i> Vigencia de documentos</h4>
                    <div class="btn-group">
                        <a href="{{ route('ingresos.historial') }}" class="btn btn-sm btn-light {{ !request('estado') ? 'active' : '' }}">Todos</a>
                        <a href="{{ route('ingresos.historial', ['estado' => 'vigente']) }}" class="btn btn-sm btn-light {{ request('estado') == 'vigente' ? 'active' : '' }}">Vigentes</a>
                        <a href="{{ route('ingresos.historial', ['estado' => 'proximo']) }}" class="btn btn-sm btn-light {{ request('estado') == 'proximo' ? 'active' : '' }}">Próximos</a>
                        <a href="{{ route('ingresos.historial', ['estado' => 'vencido']) }}" class="btn btn-sm btn-light {{ request('estado') == 'vencido' ? 'active' : '' }}">Vencidos</a>
                    </div>
                </div>
            </div>

            {{-- ACORDEÓN DE VIGENCIA CON SCROLL --}}
            <div class="accordion-scrollable">
                <div class="card-body p-0">
                    @php
                        $agrupados = $documentos->groupBy(function($doc) {
                            return $doc->contribuyente->id ?? 0;
                        });
                    @endphp
                    
                    @forelse($agrupados as $contribuyenteId => $docsContribuyente)
                        @php
                            $primerDoc = $docsContribuyente->first();
                            $contribuyente = $primerDoc->contribuyente;
                        @endphp
                        <div class="accordion-group border-bottom">
                            <div class="accordion-header p-3 bg-light d-flex justify-content-between align-items-center" style="cursor: pointer;" onclick="toggleAccordion(this)">
                                <div>
                                    <i class="fas fa-chevron-right toggle-icon mr-2"></i>
                                    <strong>{{ $contribuyente->nombre ?? '—' }} {{ $contribuyente->apellido_paterno ?? '' }}</strong>
                                    <span class="text-muted ml-2">| {{ $contribuyente->nombre_empresa ?? '—' }}</span>
                                    <span class="badge badge-secondary ml-2">{{ $docsContribuyente->count() }} documento(s)</span>
                                </div>
                            </div>
                            <div class="accordion-body" style="display: none;">
                                <div class="p-3">
                                    <table class="table table-sm table-borderless">
                                        <tbody>
                                            @foreach($docsContribuyente as $doc)
                                            <tr class="border-bottom">
                                                <td width="5%"><i class="fas fa-file-pdf text-danger"></i></td>
                                                <td width="35%"><strong>{{ $doc->nombre_documento }}</strong></td>
                                                <td width="25%"><i class="far fa-calendar-alt"></i> Vence: {{ $doc->fecha_vencimiento ? $doc->fecha_vencimiento->format('d/m/Y') : '—' }}</td>
                                                <td width="15%">
                                                    @if($doc->estado == 'vigente')
                                                        <span class="badge badge-success">✅ Vigente</span>
                                                    @else
                                                        <span class="badge badge-danger">❌ Vencido</span>
                                                    @endif
                                                </td>
                                                <td width="20%">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('ingresos.documento.detalle', $doc->id) }}" class="btn btn-outline-info"><i class="fas fa-eye"></i> Detalle</a>
                                                        @if($doc->estado == 'vencido')
                                                            <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#renovarModal{{ $doc->id }}"><i class="fas fa-sync-alt"></i></button>
                                                            <form action="{{ route('ingresos.documento.eliminar', $doc->id) }}" method="POST" class="d-inline">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Eliminar este documento vencido?')"><i class="fas fa-trash-alt"></i></button>
                                                            </form>
                                                        @elseif($doc->estado == 'vigente' && $doc->fecha_vencimiento <= now()->addDays(30))
                                                            <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#renovarModal{{ $doc->id }}"><i class="fas fa-sync-alt"></i></button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        @foreach($docsContribuyente as $doc)
                        <div class="modal fade" id="renovarModal{{ $doc->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('ingresos.documento.actualizar', $doc->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Renovar documento: {{ $doc->nombre_documento }}</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nueva fecha de vencimiento</label>
                                                <input type="date" name="fecha_vencimiento" class="form-control" min="{{ now()->addDay()->format('Y-m-d') }}" required>
                                                <small class="text-muted">Fecha actual: {{ $doc->fecha_vencimiento->format('d/m/Y') }}</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Actualizar vigencia</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-3x mb-2"></i>
                        <p>No hay documentos registrados</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function toggleAccordion(element) {
    let body = element.nextElementSibling;
    let icon = element.querySelector('.toggle-icon');
    
    if (body.style.display === 'none' || body.style.display === '') {
        body.style.display = 'block';
        icon.style.transform = 'rotate(90deg)';
    } else {
        body.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
    }
}

document.getElementById('filtro').addEventListener('change', function() {
    var rangoCampos = document.querySelectorAll('.rango-fecha');
    if (this.value === 'rango') {
        rangoCampos.forEach(function(el) {
            el.style.display = 'block';
        });
    } else {
        rangoCampos.forEach(function(el) {
            el.style.display = 'none';
        });
    }
});
</script>

<style>
.sticky-header {
    position: sticky;
    top: 0;
    background-color: white;
    z-index: 100;
    padding-bottom: 10px;
    border-bottom: 2px solid #7B1B58;
}

.table-scrollable {
    max-height: 400px;
    overflow-y: auto;
    overflow-x: hidden;
    margin-bottom: 20px;
}

.table-scrollable table {
    width: 100%;
    margin-bottom: 0;
}

.accordion-scrollable {
    max-height: 500px;
    overflow-y: auto;
    overflow-x: hidden;
}

.accordion-header:hover {
    background-color: #e9ecef !important;
}
.toggle-icon {
    transition: transform 0.2s;
    display: inline-block;
}
</style>
@endsection