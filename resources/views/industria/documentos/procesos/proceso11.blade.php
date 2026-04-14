<div class="card card-primary mb-4">
    <div class="card-header" id="heading11">
        <h5 class="mb-0">
            <button class="btn btn-link text-white d-flex align-items-center justify-content-between w-100 text-decoration-none" type="button" data-toggle="collapse" data-target="#collapse11">
                <span><i class="fas fa-folder-open mr-2"></i> 11. COBRO DE ANUNCIOS O DE REPARTICIÓN DE VOLANTES</span>
                <i class="fas fa-chevron-down"></i>
            </button>
        </h5>
    </div>
    <div id="collapse11" class="collapse" data-parent="#accordionProcesos">
        <div class="card-body p-4">
            <form action="{{ route('industria.documentos.guardar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="contribuyente_id" value="{{ $contribuyenteSeleccionado->id }}">
                <input type="hidden" name="tramite" value="11">

                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-chart-line mr-2"></i> DATOS DEL TRÁMITE</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3"><label class="font-weight-bold">NOMBRE</label><input type="text" name="campos_texto[11_nombre]" class="form-control"></div>
                            <div class="col-md-6 mb-3"><label class="font-weight-bold">GIRO COMERCIAL</label><input type="text" name="campos_texto[11_giro]" class="form-control"></div>
                            <div class="col-md-6 mb-3"><label class="font-weight-bold">NOMBRE DE LA EMPRESA</label><input type="text" name="campos_texto[11_empresa]" class="form-control"></div>
                            <div class="col-md-6 mb-3"><label class="font-weight-bold">DIRECCIÓN</label><input type="text" name="campos_texto[11_direccion]" class="form-control"></div>
                            <div class="col-md-12 mb-3"><label class="font-weight-bold">COSTO POR M²</label><input type="text" name="campos_texto[11_costo]" class="form-control"></div>
                        </div>
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary px-4 py-2"><i class="fas fa-save mr-2"></i> Guardar trámite 11</button>
                </div>
            </form>
        </div>
    </div>
</div>