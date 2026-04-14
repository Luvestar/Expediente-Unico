<div class="card card-primary mb-4">
    <div class="card-header" id="heading10">
        <h5 class="mb-0">
            <button class="btn btn-link text-white d-flex align-items-center justify-content-between w-100 text-decoration-none" type="button" data-toggle="collapse" data-target="#collapse10">
                <span><i class="fas fa-folder-open mr-2"></i> 10. COBRO DE CARGA Y DESCARGA</span>
                <i class="fas fa-chevron-down"></i>
            </button>
        </h5>
    </div>
    <div id="collapse10" class="collapse" data-parent="#accordionProcesos">
        <div class="card-body p-4">
            <form action="{{ route('industria.documentos.guardar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="contribuyente_id" value="{{ $contribuyenteSeleccionado->id }}">
                <input type="hidden" name="tramite" value="10">

                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-truck mr-2"></i> DATOS DEL TRÁMITE</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3"><label class="font-weight-bold">NÚMERO DE PLACAS</label><input type="text" name="campos_texto[10_placas]" class="form-control"></div>
                            <div class="col-md-6 mb-3"><label class="font-weight-bold">FECHA</label><input type="date" name="campos_texto[10_fecha]" class="form-control"></div>
                            <div class="col-md-6 mb-3"><label class="font-weight-bold">NOMBRE DE LA EMPRESA O PERSONA</label><input type="text" name="campos_texto[10_nombre]" class="form-control"></div>
                            <div class="col-md-6 mb-3"><label class="font-weight-bold">COSTO POR M²</label><input type="text" name="campos_texto[10_costo]" class="form-control"></div>
                        </div>
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary px-4 py-2"><i class="fas fa-save mr-2"></i> Guardar trámite 10</button>
                </div>
            </form>
        </div>
    </div>
</div>