<div class="card card-primary mb-4">
    <div class="card-header" id="heading2">
        <h5 class="mb-0">
            <button class="btn btn-link text-white d-flex align-items-center justify-content-between w-100 text-decoration-none" type="button" data-toggle="collapse" data-target="#collapse2">
                <span>
                    <i class="fas fa-folder-open mr-2"></i> 
                    2. COBRO Y EXPEDICIÓN DE LICENCIAS DE FUNCIONAMIENTO
                </span>
                <i class="fas fa-chevron-down"></i>
            </button>
        </h5>
    </div>
    
    <div id="collapse2" class="collapse" data-parent="#accordionProcesos">
        <div class="card-body p-4">

            {{-- ========================================== --}}
            {{-- FORMULARIO 2.1 --}}
            {{-- ========================================== --}}
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">2.1 REFRENDO</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('industria.documentos.guardar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="contribuyente_id" value="{{ $contribuyenteSeleccionado->id }}">
                        <input type="hidden" name="tramite" value="2.1">

                        <div class="row">
                            {{-- FACTURA (SIN radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_2_factura">
                                            <label class="custom-control-label" for="check_2_factura">
                                                <i class="fas fa-receipt text-secondary mr-2"></i>
                                                COPIA DE FACTURA DE PAGO INMEDIATO ANTERIOR
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="file_2_factura" class="btn-upload">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[2_factura]" id="file_2_factura" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted ml-2" id="file_2_factura_name"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- RFC (CON radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_2_rfc">
                                            <label class="custom-control-label" for="check_2_rfc">
                                                <i class="fas fa-id-card text-secondary mr-2"></i>
                                                CONSTANCIA DE SITUACIÓN FISCAL - RFC ACTUALIZADA
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <label for="file_2_rfc" class="btn-upload mr-3">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[2_rfc]" id="file_2_rfc" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted mr-3" id="file_2_rfc_name"></span>
                                        
                                        <div class="cotejo-toggle">
                                            <span class="small text-muted mr-2">Mostrar en cotejo:</span>
                                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                                                <label class="btn btn-outline-success btn-sm active">
                                                    <input type="radio" name="mostrar_rfc_2" value="1" checked> Sí
                                                </label>
                                                <label class="btn btn-outline-secondary btn-sm">
                                                    <input type="radio" name="mostrar_rfc_2" value="0"> No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- DOMICILIO - LUZ (CON radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_2_domicilio">
                                            <label class="custom-control-label" for="check_2_domicilio">
                                                <i class="fas fa-home text-secondary mr-2"></i>
                                                COMPROBANTE DE DOMICILIO - RECIBO DE LUZ
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <label for="file_2_domicilio" class="btn-upload mr-3">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[2_domicilio]" id="file_2_domicilio" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted mr-3" id="file_2_domicilio_name"></span>
                                        
                                        <div class="cotejo-toggle">
                                            <span class="small text-muted mr-2">Mostrar en cotejo:</span>
                                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                                                <label class="btn btn-outline-success btn-sm active">
                                                    <input type="radio" name="mostrar_domicilio_2" value="1" checked> Sí
                                                </label>
                                                <label class="btn btn-outline-secondary btn-sm">
                                                    <input type="radio" name="mostrar_domicilio_2" value="0"> No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- PROTECCIÓN CIVIL (SIN radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_2_pc">
                                            <label class="custom-control-label" for="check_2_pc">
                                                <i class="fas fa-shield-alt text-secondary mr-2"></i>
                                                COPIA DE CONSTANCIA DE PROTECCIÓN CIVIL ACTUALIZADA
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="file_2_pc" class="btn-upload">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[2_pc]" id="file_2_pc" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted ml-2" id="file_2_pc_name"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- USO DE SUELO (SIN radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_2_suelo">
                                            <label class="custom-control-label" for="check_2_suelo">
                                                <i class="fas fa-draw-polygon text-secondary mr-2"></i>
                                                LICENCIA DE USO ESPECÍFICO DE SUELO ACTUALIZADO
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="file_2_suelo" class="btn-upload">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[2_suelo]" id="file_2_suelo" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted ml-2" id="file_2_suelo_name"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- ALINEAMIENTO (SIN radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_2_alineamiento">
                                            <label class="custom-control-label" for="check_2_alineamiento">
                                                <i class="fas fa-road text-secondary mr-2"></i>
                                                LICENCIA DE ALINEAMIENTO Y NÚMERO OFICIAL
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="file_2_alineamiento" class="btn-upload">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[2_alineamiento]" id="file_2_alineamiento" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted ml-2" id="file_2_alineamiento_name"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- FOTOGRAFÍAS (SIN radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_2_fotos">
                                            <label class="custom-control-label" for="check_2_fotos">
                                                <i class="fas fa-camera text-secondary mr-2"></i>
                                                4 FOTOGRAFÍAS (2 INTERIOR Y 2 EXTERIOR)
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="file_2_fotos" class="btn-upload">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[2_fotos]" id="file_2_fotos" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted ml-2" id="file_2_fotos_name"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- CONTRATO ARRENDAMIENTO (SIN radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_2_contrato">
                                            <label class="custom-control-label" for="check_2_contrato">
                                                <i class="fas fa-file-signature text-secondary mr-2"></i>
                                                COPIA DE CONTRATO DE ARRENDAMIENTO
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="file_2_contrato" class="btn-upload">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[2_contrato]" id="file_2_contrato" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted ml-2" id="file_2_contrato_name"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- INE (CON radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_2_ine">
                                            <label class="custom-control-label" for="check_2_ine">
                                                <i class="fas fa-id-badge text-secondary mr-2"></i>
                                                COPIA DE INE DEL PROPIETARIO
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <label for="file_2_ine" class="btn-upload mr-3">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[2_ine]" id="file_2_ine" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted mr-3" id="file_2_ine_name"></span>
                                        
                                        <div class="cotejo-toggle">
                                            <span class="small text-muted mr-2">Mostrar en cotejo:</span>
                                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                                                <label class="btn btn-outline-success btn-sm active">
                                                    <input type="radio" name="mostrar_ine_2" value="1" checked> Sí
                                                </label>
                                                <label class="btn btn-outline-secondary btn-sm">
                                                    <input type="radio" name="mostrar_ine_2" value="0"> No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- CÉDULA SANITARIA (SIN radio) --}}
                            <div class="col-md-12 mb-3">
                                <div class="requisito-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_2_sanitaria">
                                            <label class="custom-control-label" for="check_2_sanitaria">
                                                <i class="fas fa-hospital-user text-secondary mr-2"></i>
                                                CÉDULA SANITARIA PARA VENTA DE BEBIDAS ALCOHÓLICAS
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="file_2_sanitaria" class="btn-upload">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                                        </label>
                                        <input type="file" name="archivos[2_sanitaria]" id="file_2_sanitaria" accept=".pdf" class="d-none">
                                        <span class="file-name small text-muted ml-2" id="file_2_sanitaria_name"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-save mr-2"></i> Guardar trámite 2.1
                            </button>
                        </div>
                    </form>
                </div>
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
    document.querySelectorAll('#collapse2 input[type="file"]').forEach(input => {
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