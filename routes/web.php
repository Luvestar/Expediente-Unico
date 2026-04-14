<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\ContribuyenteController;
use App\Http\Controllers\Admin\DocumentoController;
use App\Http\Controllers\Area\IndustriaController;
use App\Http\Controllers\Area\DesarrolloController;
use App\Http\Controllers\Area\ProteccionController;

Route::get('/', function () {
    return view('auth.login');
});

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ADMINISTRACIÓN
    Route::prefix('admin')->middleware(['rol:administrador'])->group(function () {
        
        // USUARIOS
        Route::get('/usuarios/crear', [UsuarioController::class, 'create'])->name('admin.usuarios.crear');
        Route::post('/usuarios/guardar', [UsuarioController::class, 'store'])->name('admin.usuarios.guardar');
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios');
        Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'edit'])->name('admin.usuarios.editar');
        Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('admin.usuarios.update');
        Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy');
        Route::put('/usuarios/{id}/toggle-estado', [UsuarioController::class, 'toggleEstado'])->name('admin.usuarios.toggle');
        
        // PERMISOS Y ROLES
Route::get('/permisos', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('admin.permisos');
Route::get('/permisos/{id}/editar', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('admin.permisos.editar');
Route::put('/permisos/{id}', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('admin.permisos.update');
Route::post('/permisos/asignar-usuario', [App\Http\Controllers\Admin\RoleController::class, 'asignarUsuario'])->name('admin.permisos.asignar');
        // Configuración
        Route::get('/configuracion', [App\Http\Controllers\Admin\ConfiguracionController::class, 'index'])->name('admin.configuracion');
        Route::post('/configuracion/general', [App\Http\Controllers\Admin\ConfiguracionController::class, 'actualizarConfiguracionGeneral'])->name('admin.configuracion.general');
        Route::post('/configuracion/area/{id}', [App\Http\Controllers\Admin\ConfiguracionController::class, 'actualizarArea'])->name('admin.configuracion.area');
        Route::post('/configuracion/vigencias', [App\Http\Controllers\Admin\ConfiguracionController::class, 'actualizarVigencias'])->name('admin.configuracion.vigencias');
    });
    
    // ============================================
// MÓDULO DE INDUSTRIA Y COMERCIO 
// ============================================
Route::prefix('industria')->middleware(['auth', 'verified', 'area:1'])->group(function () {
    
    // Dashboard del área
    Route::get('/estadisticas', [App\Http\Controllers\Industria\DashboardController::class, 'index'])->name('industria.estadisticas');
    
    // Registrar Contribuyente
    Route::get('/contribuyente/crear', [App\Http\Controllers\Industria\ContribuyenteController::class, 'create'])->name('industria.contribuyente.crear');
    Route::post('/contribuyente/guardar', [App\Http\Controllers\Industria\ContribuyenteController::class, 'store'])->name('industria.contribuyente.guardar');
    
    // Lista de contribuyentes
    Route::get('/contribuyentes', [App\Http\Controllers\Industria\ContribuyenteController::class, 'index'])->name('industria.contribuyentes');
    Route::get('/contribuyente/{id}/editar', [App\Http\Controllers\Industria\ContribuyenteController::class, 'edit'])->name('industria.contribuyente.editar');
    Route::put('/contribuyente/{id}', [App\Http\Controllers\Industria\ContribuyenteController::class, 'update'])->name('industria.contribuyente.actualizar');
    Route::delete('/contribuyente/{id}', [App\Http\Controllers\Industria\ContribuyenteController::class, 'destroy'])->name('industria.contribuyente.eliminar');
    
    // Subir Documentos
    Route::get('/agregar-datos', [App\Http\Controllers\Industria\DocumentoController::class, 'index'])->name('industria.documentos.index');
    Route::get('/agregar-datos/cargar/{contribuyente_id}', [App\Http\Controllers\Industria\DocumentoController::class, 'create'])->name('industria.documentos.cargar');
    Route::post('/documentos/guardar', [App\Http\Controllers\Industria\DocumentoController::class, 'store'])->name('industria.documentos.guardar');
    
    // Consultar información
    Route::get('/consultar', [App\Http\Controllers\Industria\ConsultaController::class, 'index'])->name('industria.consultar');
    Route::get('/consultar/{id}', [App\Http\Controllers\Industria\ConsultaController::class, 'show'])->name('industria.consulta.detalle');
    Route::get('/consultar/cotejar/{id}', [App\Http\Controllers\Industria\ConsultaController::class, 'cotejar'])->name('industria.consultar.cotejar');
    Route::get('/consultar/expediente/{id}', [App\Http\Controllers\Industria\ConsultaController::class, 'expediente'])->name('industria.consultar.expediente');
    Route::get('/ver-pdf/{path}', [App\Http\Controllers\Industria\ConsultaController::class, 'verPDF'])->name('industria.ver.pdf')->where('path', '.*');
    
    // Historial
    Route::get('/historial', [App\Http\Controllers\Industria\HistorialController::class, 'index'])->name('industria.historial');
    Route::get('/historial/ver/{id}', [App\Http\Controllers\Industria\HistorialController::class, 'verTramite'])->name('industria.historial.ver');
    Route::get('/documento/{id}/detalle', [App\Http\Controllers\Industria\HistorialController::class, 'verDetalle'])->name('industria.documento.detalle');
    Route::put('/documento/{id}/actualizar', [App\Http\Controllers\Industria\HistorialController::class, 'actualizarVigencia'])->name('industria.documento.actualizar');
    Route::delete('/documento/{id}/eliminar', [App\Http\Controllers\Industria\HistorialController::class, 'eliminarDocumento'])->name('industria.documento.eliminar');
    
    // Descargar y ver documento
    Route::get('/descargar-documento', [App\Http\Controllers\Industria\ConsultaController::class, 'descargar'])->name('industria.descargar.documento');
    Route::get('/ver-documento/{path}', [App\Http\Controllers\Industria\ConsultaController::class, 'verDocumento'])->name('industria.ver.documento')->where('path', '.*');

    // Dentro del grupo de Industria
    Route::get('/expediente/pdf/{id}', [App\Http\Controllers\Industria\ConsultaController::class, 'generarPDF'])->name('industria.expediente.pdf');
    Route::get('/expediente/zip/{id}', [App\Http\Controllers\Industria\ConsultaController::class, 'descargarZIP'])->name('industria.expediente.zip');
    
    // Orden de cobro
    Route::get('/orden-cobro/{contribuyente_id}', [App\Http\Controllers\OrdenCobroController::class, 'form'])->name('industria.orden.cobro.form');
    Route::post('/orden-cobro/store', [App\Http\Controllers\OrdenCobroController::class, 'store'])->name('industria.orden.cobro.store');
    // Exportar CSV desde el historial
    Route::get('/historial/exportar-csv', [App\Http\Controllers\Industria\HistorialController::class, 'exportarCSV'])->name('industria.historial.exportar.csv');
    });
    
    // ============================================
    // MÓDULO DE DESARROLLO URBANO 
    // ============================================
    Route::prefix('desarrollo')->middleware(['auth', 'verified', 'area:2'])->group(function () {
        
        // Agregar Datos / Subir Documentos
        Route::get('/agregar-datos', [App\Http\Controllers\Desarrollo\DocumentoController::class, 'index'])->name('desarrollo.documentos.index');
        Route::get('/agregar-datos/cargar/{contribuyente_id}', [App\Http\Controllers\Desarrollo\DocumentoController::class, 'create'])->name('desarrollo.documentos.cargar');
        Route::post('/documentos/guardar', [App\Http\Controllers\Desarrollo\DocumentoController::class, 'store'])->name('desarrollo.documentos.guardar');
        Route::post('/documentos/guardar/final', [App\Http\Controllers\Desarrollo\DocumentoController::class, 'guardarDocumentoFinal'])->name('desarrollo.documentos.guardar.final');
        
        // Consultar información
        Route::get('/consultar', [App\Http\Controllers\Desarrollo\ConsultaController::class, 'index'])->name('desarrollo.consultar');
        Route::get('/consultar/expediente/{id}', [App\Http\Controllers\Desarrollo\ConsultaController::class, 'expediente'])->name('desarrollo.consultar.expediente');
        Route::get('/consultar/cotejar/{id}', [App\Http\Controllers\Desarrollo\ConsultaController::class, 'cotejar'])->name('desarrollo.consultar.cotejar');
        Route::get('/ver-pdf/{path}', [App\Http\Controllers\Desarrollo\ConsultaController::class, 'verPDF'])->name('desarrollo.ver.pdf')->where('path', '.*');
        
        // Historial
        Route::get('/historial', [App\Http\Controllers\Desarrollo\HistorialController::class, 'index'])->name('desarrollo.historial');
        Route::get('/historial/ver/{id}', [App\Http\Controllers\Desarrollo\HistorialController::class, 'verTramite'])->name('desarrollo.historial.ver');
        Route::get('/documento/{id}/detalle', [App\Http\Controllers\Desarrollo\HistorialController::class, 'verDetalle'])->name('desarrollo.documento.detalle');
        Route::put('/documento/{id}/actualizar', [App\Http\Controllers\Desarrollo\HistorialController::class, 'actualizarVigencia'])->name('desarrollo.documento.actualizar');
        
        // Vigencia de documentos
        Route::get('/vigencia', [App\Http\Controllers\Desarrollo\DocumentoController::class, 'vigencia'])->name('desarrollo.vigencia');
        
        // Descargar y ver documento
        Route::get('/descargar-documento', [App\Http\Controllers\Desarrollo\ConsultaController::class, 'descargar'])->name('desarrollo.descargar.documento');
        Route::get('/ver-documento/{path}', [App\Http\Controllers\Desarrollo\ConsultaController::class, 'verDocumento'])->name('desarrollo.ver.documento')->where('path', '.*');
        
        // Orden de cobro
        Route::get('/orden-cobro/{contribuyente_id}/{orden_id?}', [App\Http\Controllers\OrdenCobroController::class, 'form'])->name('desarrollo.orden.cobro.form')->defaults('area', 'desarrollo');
        Route::post('/orden-cobro/store', [App\Http\Controllers\OrdenCobroController::class, 'store'])->name('desarrollo.orden.cobro.store')->defaults('area', 'desarrollo');
        //Exportar CSV desde el historial
        Route::get('/historial/exportar-csv', [App\Http\Controllers\Desarrollo\HistorialController::class, 'exportarCSV'])->name('desarrollo.historial.exportar.csv');
});
    
    // ============================================
    // MÓDULO DE PROTECCIÓN CIVIL
    // ============================================
    Route::prefix('proteccion')->middleware(['auth', 'verified', 'area:3'])->group(function () {
        
        // Agregar Datos / Subir Documentos
        Route::get('/agregar-datos', [App\Http\Controllers\Proteccion\DocumentoController::class, 'index'])->name('proteccion.documentos.index');
        Route::get('/agregar-datos/cargar/{contribuyente_id}', [App\Http\Controllers\Proteccion\DocumentoController::class, 'create'])->name('proteccion.documentos.cargar');
        Route::post('/documentos/guardar', [App\Http\Controllers\Proteccion\DocumentoController::class, 'store'])->name('proteccion.documentos.guardar');
        Route::post('/documentos/guardar/final', [App\Http\Controllers\Proteccion\DocumentoController::class, 'guardarDocumentoFinal'])->name('proteccion.documentos.guardar.final');
        
        // Consultar información
        Route::get('/consultar', [App\Http\Controllers\Proteccion\ConsultaController::class, 'index'])->name('proteccion.consultar');
        Route::get('/consultar/expediente/{id}', [App\Http\Controllers\Proteccion\ConsultaController::class, 'expediente'])->name('proteccion.consultar.expediente');
        Route::get('/consultar/cotejar/{id}', [App\Http\Controllers\Proteccion\ConsultaController::class, 'cotejar'])->name('proteccion.consultar.cotejar');
        Route::get('/ver-pdf/{path}', [App\Http\Controllers\Proteccion\ConsultaController::class, 'verPDF'])->name('proteccion.ver.pdf')->where('path', '.*');
        
        // Historial
        Route::get('/historial', [App\Http\Controllers\Proteccion\HistorialController::class, 'index'])->name('proteccion.historial');
        Route::get('/historial/ver/{id}', [App\Http\Controllers\Proteccion\HistorialController::class, 'verTramite'])->name('proteccion.historial.ver');
        Route::get('/documento/{id}/detalle', [App\Http\Controllers\Proteccion\HistorialController::class, 'verDetalle'])->name('proteccion.documento.detalle');
        Route::put('/documento/{id}/actualizar', [App\Http\Controllers\Proteccion\HistorialController::class, 'actualizarVigencia'])->name('proteccion.documento.actualizar');
        Route::delete('/documento/{id}/eliminar', [App\Http\Controllers\Proteccion\HistorialController::class, 'eliminarDocumento'])->name('proteccion.documento.eliminar');
        
        // Descargar y ver documento
        Route::get('/descargar-documento', [App\Http\Controllers\Proteccion\ConsultaController::class, 'descargar'])->name('proteccion.descargar.documento');
        Route::get('/ver-documento/{path}', [App\Http\Controllers\Proteccion\ConsultaController::class, 'verDocumento'])->name('proteccion.ver.documento')->where('path', '.*');
        
        // Orden de cobro
        Route::get('/orden-cobro/{contribuyente_id}/{orden_id?}', [App\Http\Controllers\OrdenCobroController::class, 'form'])->name('proteccion.orden.cobro.form')->defaults('area', 'proteccion');
        Route::post('/orden-cobro/store', [App\Http\Controllers\OrdenCobroController::class, 'store'])->name('proteccion.orden.cobro.store')->defaults('area', 'proteccion');
        // Exportar CSV desde el historial
        Route::get('/historial/exportar-csv', [App\Http\Controllers\Proteccion\HistorialController::class, 'exportarCSV'])->name('proteccion.historial.exportar.csv');
    });

    // ============================================
    // MÓDULO DE INGRESOS
    // ============================================
    Route::prefix('ingresos')->middleware(['auth', 'verified', 'area:4'])->group(function () {    
        // Agregar Datos / Subir Documentos
        Route::get('/agregar-datos', [App\Http\Controllers\Ingresos\DocumentoController::class, 'index'])->name('ingresos.documentos.index');
        Route::get('/agregar-datos/cargar/{contribuyente_id}', [App\Http\Controllers\Ingresos\DocumentoController::class, 'create'])->name('ingresos.documentos.cargar');
        Route::post('/documentos/guardar', [App\Http\Controllers\Ingresos\DocumentoController::class, 'store'])->name('ingresos.documentos.guardar');
        Route::post('/documentos/guardar/final', [App\Http\Controllers\Ingresos\DocumentoController::class, 'guardarDocumentoFinal'])->name('ingresos.documentos.guardar.final');
    
        // Consultar información
        Route::get('/consultar', [App\Http\Controllers\Ingresos\ConsultaController::class, 'index'])->name('ingresos.consultar');
        Route::get('/consultar/expediente/{id}', [App\Http\Controllers\Ingresos\ConsultaController::class, 'expediente'])->name('ingresos.consultar.expediente');
        Route::get('/consultar/cotejar/{id}', [App\Http\Controllers\Ingresos\ConsultaController::class, 'cotejar'])->name('ingresos.consultar.cotejar');
        Route::get('/ver-pdf/{path}', [App\Http\Controllers\Ingresos\ConsultaController::class, 'verPDF'])->name('ingresos.ver.pdf')->where('path', '.*');
    
        // Historial
        Route::get('/historial', [App\Http\Controllers\Ingresos\HistorialController::class, 'index'])->name('ingresos.historial');
        Route::get('/documento/{id}/detalle', [App\Http\Controllers\Ingresos\HistorialController::class, 'verDetalle'])->name('ingresos.documento.detalle');
        Route::put('/documento/{id}/actualizar', [App\Http\Controllers\Ingresos\HistorialController::class, 'actualizarVigencia'])->name('ingresos.documento.actualizar');
        Route::delete('/documento/{id}/eliminar', [App\Http\Controllers\Ingresos\HistorialController::class, 'eliminarDocumento'])->name('ingresos.documento.eliminar');
    
        // Descargar y ver documentos
        Route::get('/descargar-documento', [App\Http\Controllers\Ingresos\ConsultaController::class, 'descargar'])->name('ingresos.descargar.documento');
        Route::get('/ver-documento/{path}', [App\Http\Controllers\Ingresos\ConsultaController::class, 'verDocumento'])->name('ingresos.ver.documento')->where('path', '.*');
        
        // Órdenes de cobro (solo visualización)
        Route::get('/ordenes-cobro', [App\Http\Controllers\OrdenCobroController::class, 'index'])->name('ingresos.ordenes.cobro');
        Route::get('/orden-cobro/{id}', [App\Http\Controllers\OrdenCobroController::class, 'show'])->name('ingresos.orden.cobro.ver');
        Route::get('/orden-cobro/contribuyente/{contribuyente_id}', [App\Http\Controllers\OrdenCobroController::class, 'porContribuyente'])->name('ingresos.orden.cobro.por.contribuyente');
        // Exportar CSV desde el historial
        Route::get('/historial/exportar-csv', [App\Http\Controllers\Ingresos\HistorialController::class, 'exportarCSV'])->name('ingresos.historial.exportar.csv');
    });
});

require __DIR__.'/auth.php';