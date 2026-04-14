<div class="card card-primary mb-4">
    <div class="card-header" id="heading2">
        <h5 class="mb-0">
            <button class="btn btn-link text-white d-flex align-items-center justify-content-between w-100 text-decoration-none" type="button" data-toggle="collapse" data-target="#collapse2">
                <span>
                    <i class="fas fa-folder-open mr-2"></i> 
                    2. TRÁMITE DE USO DE SUELO ESPECÍFICO
                </span>
                <i class="fas fa-chevron-down"></i>
            </button>
        </h5>
    </div>
    
    <div id="collapse2" class="collapse" data-parent="#accordionProcesos">
        <div class="card-body p-4">

            {{-- ========================================== --}}
            {{-- FORMULARIO DE REQUISITOS --}}
            {{-- ========================================== --}}
            <form action="{{ route('desarrollo.documentos.guardar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="contribuyente_id" value="{{ $contribuyente->id }}">
                <input type="hidden" name="tramite" value="2. TRÁMITE DE USO DE SUELO ESPECÍFICO">

                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary rounded-circle p-2 mr-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-paperclip text-white fa-sm"></i>
                    </div>
                    <h6 class="text-primary mb-0 font-weight-bold">REQUISITOS DEL TRÁMITE</h6>
                </div>

                {{-- 1. Alineamiento (SIN radio) --}}
                <div class="requisito-card d-flex align-items-center justify-content-between p-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="check_2_alineamiento">
                            <label class="custom-control-label" for="check_2_alineamiento">
                                <i class="fas fa-draw-polygon text-secondary mr-2"></i>
                                Alineamiento y número oficial
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

                {{-- 2. Escritura (SIN radio) --}}
                <div class="requisito-card d-flex align-items-center justify-content-between p-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="check_2_escritura">
                            <label class="custom-control-label" for="check_2_escritura">
                                <i class="fas fa-file-contract text-secondary mr-2"></i>
                                Escritura o título de propiedad (original y copia)
                            </label>
                        </div>
                    </div>
                    <div>
                        <label for="file_2_escritura" class="btn-upload">
                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                        </label>
                        <input type="file" name="archivos[2_escritura]" id="file_2_escritura" accept=".pdf" class="d-none">
                        <span class="file-name small text-muted ml-2" id="file_2_escritura_name"></span>
                    </div>
                </div>

                {{-- 3. Identificación oficial (CON radio) --}}
                <div class="requisito-card d-flex align-items-center justify-content-between p-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="check_2_identificacion">
                            <label class="custom-control-label" for="check_2_identificacion">
                                <i class="fas fa-id-badge text-secondary mr-2"></i>
                                Copia de identificación oficial del propietario
                            </label>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="file_2_identificacion" class="btn-upload mr-3">
                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                        </label>
                        <input type="file" name="archivos[2_identificacion]" id="file_2_identificacion" accept=".pdf" class="d-none">
                        <span class="file-name small text-muted mr-3" id="file_2_identificacion_name"></span>
                        
                        <div class="cotejo-toggle">
                            <span class="small text-muted mr-2">Mostrar en cotejo:</span>
                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                                <label class="btn btn-outline-success btn-sm active">
                                    <input type="radio" name="mostrar_identificacion_2" value="1" checked> Sí
                                </label>
                                <label class="btn btn-outline-secondary btn-sm">
                                    <input type="radio" name="mostrar_identificacion_2" value="0"> No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. Predial (CON radio) --}}
                <div class="requisito-card d-flex align-items-center justify-content-between p-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="check_2_predial">
                            <label class="custom-control-label" for="check_2_predial">
                                <i class="fas fa-receipt text-secondary mr-2"></i>
                                Copia de recibo predial del año en curso
                            </label>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="file_2_predial" class="btn-upload mr-3">
                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                        </label>
                        <input type="file" name="archivos[2_predial]" id="file_2_predial" accept=".pdf" class="d-none">
                        <span class="file-name small text-muted mr-3" id="file_2_predial_name"></span>
                        
                        <div class="cotejo-toggle">
                            <span class="small text-muted mr-2">Mostrar en cotejo:</span>
                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                                <label class="btn btn-outline-success btn-sm active">
                                    <input type="radio" name="mostrar_predial_2" value="1" checked> Sí
                                </label>
                                <label class="btn btn-outline-secondary btn-sm">
                                    <input type="radio" name="mostrar_predial_2" value="0"> No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 5. Agua (CON radio) --}}
                <div class="requisito-card d-flex align-items-center justify-content-between p-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="check_2_agua">
                            <label class="custom-control-label" for="check_2_agua">
                                <i class="fas fa-tint text-secondary mr-2"></i>
                                Copia de recibo de agua potable actualizado (o constancia)
                            </label>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="file_2_agua" class="btn-upload mr-3">
                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                        </label>
                        <input type="file" name="archivos[2_agua]" id="file_2_agua" accept=".pdf" class="d-none">
                        <span class="file-name small text-muted mr-3" id="file_2_agua_name"></span>
                        
                        <div class="cotejo-toggle">
                            <span class="small text-muted mr-2">Mostrar en cotejo:</span>
                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                                <label class="btn btn-outline-success btn-sm active">
                                    <input type="radio" name="mostrar_agua_2" value="1" checked> Sí
                                </label>
                                <label class="btn btn-outline-secondary btn-sm">
                                    <input type="radio" name="mostrar_agua_2" value="0"> No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 6. Croquis (SIN radio) --}}
                <div class="requisito-card d-flex align-items-center justify-content-between p-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="check_2_croquis">
                            <label class="custom-control-label" for="check_2_croquis">
                                <i class="fas fa-draw-polygon text-secondary mr-2"></i>
                                Croquis de medidas y colindancias con coordenadas UTM
                            </label>
                        </div>
                    </div>
                    <div>
                        <label for="file_2_croquis" class="btn-upload">
                            <i class="fas fa-cloud-upload-alt mr-1"></i> Subir PDF
                        </label>
                        <input type="file" name="archivos[2_croquis]" id="file_2_croquis" accept=".pdf" class="d-none">
                        <span class="file-name small text-muted ml-2" id="file_2_croquis_name"></span>
                    </div>
                </div>

                {{-- 7. Fotografías (SIN radio) --}}
                <div class="requisito-card d-flex align-items-center justify-content-between p-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="check_2_fotos">
                            <label class="custom-control-label" for="check_2_fotos">
                                <i class="fas fa-camera text-secondary mr-2"></i>
                                4 fotografías del predio (2 por hoja)
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

                <div class="text-right mt-4">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-save mr-2"></i> Guardar trámite
                    </button>
                </div>
            </form>

            {{-- ========================================== --}}
            {{-- SEPARADOR --}}
            {{-- ========================================== --}}
            <div class="separator my-5">
                <div class="line"></div>
                <div class="icon"><i class="fas fa-certificate"></i></div>
                <div class="line"></div>
            </div>

            {{-- ========================================== --}}
            {{-- DOCUMENTO FINAL (con su propio formulario y botón) --}}
            {{-- ========================================== --}}
            <div class="documento-final-card p-4">
                <form action="{{ route('desarrollo.documentos.guardar.final') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="contribuyente_id" value="{{ $contribuyente->id }}">
                    <input type="hidden" name="tramite" value="2. TRÁMITE DE USO DE SUELO ESPECÍFICO">
                    
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label class="font-weight-bold mb-2">
                                    <i class="fas fa-file-pdf text-danger mr-1"></i> Documento final (PDF)
                                </label>
                                <div class="custom-file">
                                    <input type="file" name="documento_final" class="custom-file-input" id="documentoFinal2" accept=".pdf" required>
                                    <label class="custom-file-label" for="documentoFinal2" id="documentoFinalLabel2">
                                        <i class="fas fa-cloud-upload-alt mr-1"></i> Seleccionar archivo
                                    </label>
                                </div>
                                <small class="text-muted">Licencia, Constancia, Dictamen o resolución emitida</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label class="font-weight-bold mb-2 d-block">Mostrar en cotejo</label>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-success active px-4">
                                        <input type="radio" name="mostrar_en_cotejo" value="1" checked> Sí
                                    </label>
                                    <label class="btn btn-outline-secondary px-4">
                                        <input type="radio" name="mostrar_en_cotejo" value="0"> No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                            <button type="submit" class="btn btn-success btn-lg px-4 w-100">
                                <i class="fas fa-save mr-1"></i> Guardar documento final
                            </button>
                        </div>
                    </div>
                </form>
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
    .separator {
        display: flex;
        align-items: center;
        text-align: center;
    }
    .separator .line {
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, transparent, #7B1B58, #c9a0b9, #7B1B58, transparent);
    }
    .separator .icon {
        padding: 0 20px;
        color: #7B1B58;
        font-size: 1.2rem;
    }
    .documento-final-card {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 1px solid #86efac;
        border-radius: 16px;
    }
    .custom-file-label {
        border-radius: 10px;
        cursor: pointer;
    }
    .custom-file-label::after {
        content: "📂";
        background: transparent;
        border-left: none;
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
            if (this.id === 'documentoFinal2') {
                const docLabel = document.getElementById('documentoFinalLabel2');
                if (docLabel) {
                    docLabel.innerHTML = fileName ? `<i class="fas fa-file-pdf"></i> ${fileName.substring(0, 40)}` : '<i class="fas fa-cloud-upload-alt"></i> Seleccionar archivo';
                }
            }
        });
    });
</script>