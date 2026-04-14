<div class="card card-primary mb-4">
    <div class="card-header" id="heading1">
        <h5 class="mb-0">
            <button class="btn btn-link text-white d-flex align-items-center justify-content-between w-100 text-decoration-none" type="button" data-toggle="collapse" data-target="#collapse1">
                <span>
                    <i class="fas fa-folder-open mr-2"></i> 
                    1. TRÁMITES DE INGRESOS
                </span>
                <i class="fas fa-chevron-down"></i>
            </button>
        </h5>
    </div>
    
    <div id="collapse1" class="collapse" data-parent="#accordionProcesos">
        <div class="card-body p-4">

            {{-- ========================================== --}}
            {{-- SECCIÓN 1: PERSONA FÍSICA --}}
            {{-- ========================================== --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-user"></i> PERSONA FÍSICA</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('ingresos.documentos.guardar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="contribuyente_id" value="{{ $contribuyente->id }}">
                        <input type="hidden" name="tramite" value="PERSONA FÍSICA - INGRESOS">

                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary rounded-circle p-2 mr-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-paperclip text-white fa-sm"></i>
                            </div>
                            <h6 class="text-primary mb-0 font-weight-bold">DOCUMENTOS REQUERIDOS</h6>
                        </div>

                        <div class="row">
                            {{-- INE (CON radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_ine">
                                            <label class="custom-control-label" for="check_ine">
                                                <i class="fas fa-id-card text-secondary mr-2"></i>
                                                INE
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <label for="file_ine" class="btn-upload mr-3">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[ine]" id="file_ine" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted mr-3" id="file_ine_name"></span>
                                        
                                        <div class="cotejo-toggle">
                                            <span class="small text-muted mr-2">Mostrar en cotejo:</span>
                                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                                                <label class="btn btn-outline-success btn-sm active">
                                                    <input type="radio" name="mostrar_ine" value="1" checked> Sí
                                                </label>
                                                <label class="btn btn-outline-secondary btn-sm">
                                                    <input type="radio" name="mostrar_ine" value="0"> No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- CURP (CON radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_curp">
                                            <label class="custom-control-label" for="check_curp">
                                                <i class="fas fa-id-card text-secondary mr-2"></i>
                                                CURP
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <label for="file_curp" class="btn-upload mr-3">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[curp]" id="file_curp" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted mr-3" id="file_curp_name"></span>
                                        
                                        <div class="cotejo-toggle">
                                            <span class="small text-muted mr-2">Mostrar en cotejo:</span>
                                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                                                <label class="btn btn-outline-success btn-sm active">
                                                    <input type="radio" name="mostrar_curp" value="1" checked> Sí
                                                </label>
                                                <label class="btn btn-outline-secondary btn-sm">
                                                    <input type="radio" name="mostrar_curp" value="0"> No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Comprobante de domicilio (CON radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_domicilio">
                                            <label class="custom-control-label" for="check_domicilio">
                                                <i class="fas fa-home text-secondary mr-2"></i>
                                                Comprobante de domicilio
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <label for="file_domicilio" class="btn-upload mr-3">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[domicilio]" id="file_domicilio" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted mr-3" id="file_domicilio_name"></span>
                                        
                                        <div class="cotejo-toggle">
                                            <span class="small text-muted mr-2">Mostrar en cotejo:</span>
                                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                                                <label class="btn btn-outline-success btn-sm active">
                                                    <input type="radio" name="mostrar_domicilio" value="1" checked> Sí
                                                </label>
                                                <label class="btn btn-outline-secondary btn-sm">
                                                    <input type="radio" name="mostrar_domicilio" value="0"> No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-save mr-2"></i> Guardar trámite
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- SECCIÓN 2: PERSONA MORAL --}}
            {{-- ========================================== --}}
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-building"></i> PERSONA MORAL</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('ingresos.documentos.guardar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="contribuyente_id" value="{{ $contribuyente->id }}">
                        <input type="hidden" name="tramite" value="PERSONA MORAL - INGRESOS">

                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary rounded-circle p-2 mr-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-paperclip text-white fa-sm"></i>
                            </div>
                            <h6 class="text-primary mb-0 font-weight-bold">DOCUMENTOS REQUERIDOS</h6>
                        </div>

                        <div class="row">
                            {{-- Oficio de autorización (SIN radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_oficio_aut">
                                            <label class="custom-control-label" for="check_oficio_aut">
                                                <i class="fas fa-file-alt text-secondary mr-2"></i>
                                                Oficio de autorización
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="file_oficio_aut" class="btn-upload">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[oficio_autorizacion]" id="file_oficio_aut" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted ml-2" id="file_oficio_aut_name"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Oficio de solicitud (SIN radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_oficio_sol">
                                            <label class="custom-control-label" for="check_oficio_sol">
                                                <i class="fas fa-file-signature text-secondary mr-2"></i>
                                                Oficio de solicitud
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="file_oficio_sol" class="btn-upload">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[oficio_solicitud]" id="file_oficio_sol" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted ml-2" id="file_oficio_sol_name"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Agradecimiento (SIN radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_agradecimiento">
                                            <label class="custom-control-label" for="check_agradecimiento">
                                                <i class="fas fa-hand-peace text-secondary mr-2"></i>
                                                Agradecimiento
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="file_agradecimiento" class="btn-upload">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[agradecimiento]" id="file_agradecimiento" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted ml-2" id="file_agradecimiento_name"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Acta constitutiva (SIN radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_acta">
                                            <label class="custom-control-label" for="check_acta">
                                                <i class="fas fa-file-contract text-secondary mr-2"></i>
                                                Acta constitutiva
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="file_acta" class="btn-upload">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[acta_constitutiva]" id="file_acta" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted ml-2" id="file_acta_name"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Documento del representante legal (SIN radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_representante">
                                            <label class="custom-control-label" for="check_representante">
                                                <i class="fas fa-user-tie text-secondary mr-2"></i>
                                                Documento del representante legal
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="file_representante" class="btn-upload">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[representante_legal]" id="file_representante" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted ml-2" id="file_representante_name"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Acta notariada (SIN radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_notariada">
                                            <label class="custom-control-label" for="check_notariada">
                                                <i class="fas fa-stamp text-secondary mr-2"></i>
                                                Acta notariada
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="file_notariada" class="btn-upload">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[acta_notariada]" id="file_notariada" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted ml-2" id="file_notariada_name"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-save mr-2"></i> Guardar trámite
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- BOTÓN REGRESAR --}}
            {{-- ========================================== --}}
            <div class="text-center mt-4">
                <a href="{{ route('ingresos.documentos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>

        </div>
    </div>
</div>

<style>
    .requisito-card {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .requisito-card:hover {
        border-color: #c9a0b9;
        box-shadow: 0 4px 12px rgba(123, 27, 88, 0.08);
    }
    .btn-upload {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 6px 16px;
        font-size: 0.85rem;
        color: #495057;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-upload:hover {
        background: #7B1B58;
        border-color: #7B1B58;
        color: white;
    }
    .cotejo-toggle {
        background: #f8f9fa;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
    }
    .btn-group-toggle .btn {
        border-radius: 20px;
        margin: 0 4px;
    }
    .btn-group-toggle .btn.active {
        background: #28a745;
        color: white;
        border-color: #28a745;
    }
    .file-name {
        max-width: 150px;
        display: inline-block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<script>
    document.querySelectorAll('#collapse1 input[type="file"]').forEach(input => {
        input.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || '';
            const labelId = this.id + '_name';
            const label = document.getElementById(labelId);
            if (label) {
                label.textContent = fileName ? fileName.substring(0, 35) + (fileName.length > 35 ? '...' : '') : '';
            }
        });
    });
</script>