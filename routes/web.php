<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// ============================================
// RUTAS DE LOGIN CON MULTI-GUARD
// ============================================

Route::get('/', fn() => redirect()->route('login'));

Route::get('/login/{guard?}', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->where('guard', 'admin|industria|desarrollo|proteccion|ingresos|web');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rutas amigables por área
Route::get('/admin/login', fn() => redirect()->route('login', ['guard' => 'admin']))->name('admin.login');
Route::get('/industria/login', fn() => redirect()->route('login', ['guard' => 'industria']))->name('industria.login');
Route::get('/desarrollo/login', fn() => redirect()->route('login', ['guard' => 'desarrollo']))->name('desarrollo.login');
Route::get('/proteccion/login', fn() => redirect()->route('login', ['guard' => 'proteccion']))->name('proteccion.login');
Route::get('/ingresos/login', fn() => redirect()->route('login', ['guard' => 'ingresos']))->name('ingresos.login');

// ============================================
// RUTAS PROTEGIDAS
// ============================================

// Dashboard general (redirige a admin)
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

// ============================================
// ADMINISTRADOR (RUTAS COMPLETAS)
// ============================================

Route::prefix('admin')
    ->middleware(['multi.session:admin', 'auth:admin', 'rol:Administrador general'])
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Usuarios
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios');
        Route::get('/usuarios/crear', [UsuarioController::class, 'create'])->name('usuarios.crear');
        Route::post('/usuarios/guardar', [UsuarioController::class, 'store'])->name('usuarios.guardar');
        Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'edit'])->name('usuarios.editar');
        Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
        Route::put('/usuarios/{id}/toggle-estado', [UsuarioController::class, 'toggleEstado'])->name('usuarios.toggle');
        
        // Permisos y Roles
        Route::get('/permisos', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('permisos');
        Route::get('/permisos/{id}/editar', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('permisos.editar');
        Route::put('/permisos/{id}', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('permisos.update');
        Route::post('/permisos/asignar-usuario', [App\Http\Controllers\Admin\RoleController::class, 'asignarUsuario'])->name('permisos.asignar');
        
        // Configuración
        Route::get('/configuracion', [App\Http\Controllers\Admin\ConfiguracionController::class, 'index'])->name('configuracion');
        Route::post('/configuracion/general', [App\Http\Controllers\Admin\ConfiguracionController::class, 'actualizarConfiguracionGeneral'])->name('configuracion.general');
        Route::post('/configuracion/area/{id}', [App\Http\Controllers\Admin\ConfiguracionController::class, 'actualizarArea'])->name('configuracion.area');
        Route::post('/configuracion/vigencias', [App\Http\Controllers\Admin\ConfiguracionController::class, 'actualizarVigencias'])->name('configuracion.vigencias');
    });

// ============================================
// INDUSTRIA Y COMERCIO
// ============================================

Route::prefix('industria')
    ->middleware(['multi.session:industria', 'auth:industria', 'verified', 'area:1', 'rol:Administrador de área,Jefe de área,Usuario'])
    ->name('industria.')
    ->group(function () {
        // Dashboard
        Route::get('/estadisticas', [App\Http\Controllers\Industria\DashboardController::class, 'index'])->name('estadisticas');
        
        // Contribuyentes
        Route::get('/contribuyente/crear', [App\Http\Controllers\Industria\ContribuyenteController::class, 'create'])->name('contribuyente.crear');
        Route::post('/contribuyente/guardar', [App\Http\Controllers\Industria\ContribuyenteController::class, 'store'])->name('contribuyente.guardar');
        Route::get('/contribuyentes', [App\Http\Controllers\Industria\ContribuyenteController::class, 'index'])->name('contribuyentes');
        Route::get('/contribuyente/{id}/editar', [App\Http\Controllers\Industria\ContribuyenteController::class, 'edit'])->name('contribuyente.editar');
        Route::put('/contribuyente/{id}', [App\Http\Controllers\Industria\ContribuyenteController::class, 'update'])->name('contribuyente.actualizar');
        Route::delete('/contribuyente/{id}', [App\Http\Controllers\Industria\ContribuyenteController::class, 'destroy'])->name('contribuyente.eliminar');
        
        // Documentos
        Route::get('/agregar-datos', [App\Http\Controllers\Industria\DocumentoController::class, 'index'])->name('documentos.index');
        Route::get('/agregar-datos/cargar/{contribuyente_id}', [App\Http\Controllers\Industria\DocumentoController::class, 'create'])->name('documentos.cargar');
        Route::post('/documentos/guardar', [App\Http\Controllers\Industria\DocumentoController::class, 'store'])->name('documentos.guardar');
        
        // Consultas
        Route::get('/consultar', [App\Http\Controllers\Industria\ConsultaController::class, 'index'])->name('consultar');
        Route::get('/consultar/{id}', [App\Http\Controllers\Industria\ConsultaController::class, 'show'])->name('consulta.detalle');
        Route::get('/consultar/cotejar/{id}', [App\Http\Controllers\Industria\ConsultaController::class, 'cotejar'])->name('consultar.cotejar');
        Route::get('/consultar/expediente/{id}', [App\Http\Controllers\Industria\ConsultaController::class, 'expediente'])->name('consultar.expediente');
        Route::get('/ver-pdf/{path}', [App\Http\Controllers\Industria\ConsultaController::class, 'verPDF'])->name('ver.pdf')->where('path', '.*');
        
        // Historial
        Route::get('/historial', [App\Http\Controllers\Industria\HistorialController::class, 'index'])->name('historial');
        Route::get('/historial/ver/{id}', [App\Http\Controllers\Industria\HistorialController::class, 'verTramite'])->name('historial.ver');
        Route::get('/documento/{id}/detalle', [App\Http\Controllers\Industria\HistorialController::class, 'verDetalle'])->name('documento.detalle');
        Route::put('/documento/{id}/actualizar', [App\Http\Controllers\Industria\HistorialController::class, 'actualizarVigencia'])->name('documento.actualizar');
        Route::delete('/documento/{id}/eliminar', [App\Http\Controllers\Industria\HistorialController::class, 'eliminarDocumento'])->name('documento.eliminar');
        
        // Descargas
        Route::get('/descargar-documento', [App\Http\Controllers\Industria\ConsultaController::class, 'descargar'])->name('descargar.documento');
        Route::get('/ver-documento/{path}', [App\Http\Controllers\Industria\ConsultaController::class, 'verDocumento'])->name('ver.documento')->where('path', '.*');
        Route::get('/expediente/pdf/{id}', [App\Http\Controllers\Industria\ConsultaController::class, 'generarPDF'])->name('expediente.pdf');
        Route::get('/expediente/zip/{id}', [App\Http\Controllers\Industria\ConsultaController::class, 'descargarZIP'])->name('expediente.zip');
        
        // Órdenes de cobro
        Route::get('/orden-cobro/{contribuyente_id}', [App\Http\Controllers\OrdenCobroController::class, 'form'])->name('orden.cobro.form');
        Route::post('/orden-cobro/store', [App\Http\Controllers\OrdenCobroController::class, 'store'])->name('orden.cobro.store');
        
        // Exportar
        Route::get('/historial/exportar-csv', [App\Http\Controllers\Industria\HistorialController::class, 'exportarCSV'])->name('historial.exportar.csv');
    });

// ============================================
// DESARROLLO URBANO
// ============================================

Route::prefix('desarrollo')
    ->middleware(['multi.session:desarrollo', 'auth:desarrollo', 'verified', 'area:2', 'rol:Administrador de área,Jefe de área,Usuario'])
    ->name('desarrollo.')
    ->group(function () {
        // Documentos
        Route::get('/agregar-datos', [App\Http\Controllers\Desarrollo\DocumentoController::class, 'index'])->name('documentos.index');
        Route::get('/agregar-datos/cargar/{contribuyente_id}', [App\Http\Controllers\Desarrollo\DocumentoController::class, 'create'])->name('documentos.cargar');
        Route::post('/documentos/guardar', [App\Http\Controllers\Desarrollo\DocumentoController::class, 'store'])->name('documentos.guardar');
        Route::post('/documentos/guardar/final', [App\Http\Controllers\Desarrollo\DocumentoController::class, 'guardarDocumentoFinal'])->name('documentos.guardar.final');
        
        // Consultas
        Route::get('/consultar', [App\Http\Controllers\Desarrollo\ConsultaController::class, 'index'])->name('consultar');
        Route::get('/consultar/expediente/{id}', [App\Http\Controllers\Desarrollo\ConsultaController::class, 'expediente'])->name('consultar.expediente');
        Route::get('/consultar/cotejar/{id}', [App\Http\Controllers\Desarrollo\ConsultaController::class, 'cotejar'])->name('consultar.cotejar');
        Route::get('/ver-pdf/{path}', [App\Http\Controllers\Desarrollo\ConsultaController::class, 'verPDF'])->name('ver.pdf')->where('path', '.*');
        
        // Historial
        Route::get('/historial', [App\Http\Controllers\Desarrollo\HistorialController::class, 'index'])->name('historial');
        Route::get('/historial/ver/{id}', [App\Http\Controllers\Desarrollo\HistorialController::class, 'verTramite'])->name('historial.ver');
        Route::get('/documento/{id}/detalle', [App\Http\Controllers\Desarrollo\HistorialController::class, 'verDetalle'])->name('documento.detalle');
        Route::put('/documento/{id}/actualizar', [App\Http\Controllers\Desarrollo\HistorialController::class, 'actualizarVigencia'])->name('documento.actualizar');
        
        // Vigencia
        Route::get('/vigencia', [App\Http\Controllers\Desarrollo\DocumentoController::class, 'vigencia'])->name('vigencia');
        
        // Descargas
        Route::get('/descargar-documento', [App\Http\Controllers\Desarrollo\ConsultaController::class, 'descargar'])->name('descargar.documento');
        Route::get('/ver-documento/{path}', [App\Http\Controllers\Desarrollo\ConsultaController::class, 'verDocumento'])->name('ver.documento')->where('path', '.*');
        
        // Órdenes de cobro
        Route::get('/orden-cobro/{contribuyente_id}/{orden_id?}', [App\Http\Controllers\OrdenCobroController::class, 'form'])->name('orden.cobro.form')->defaults('area', 'desarrollo');
        Route::post('/orden-cobro/store', [App\Http\Controllers\OrdenCobroController::class, 'store'])->name('orden.cobro.store')->defaults('area', 'desarrollo');
        
        // Exportar
        Route::get('/historial/exportar-csv', [App\Http\Controllers\Desarrollo\HistorialController::class, 'exportarCSV'])->name('historial.exportar.csv');
    });

// ============================================
// PROTECCIÓN CIVIL
// ============================================

Route::prefix('proteccion')
    ->middleware(['multi.session:proteccion', 'auth:proteccion', 'verified', 'area:3', 'rol:Administrador de área,Jefe de área,Usuario'])
    ->name('proteccion.')
    ->group(function () {
        // Documentos
        Route::get('/agregar-datos', [App\Http\Controllers\Proteccion\DocumentoController::class, 'index'])->name('documentos.index');
        Route::get('/agregar-datos/cargar/{contribuyente_id}', [App\Http\Controllers\Proteccion\DocumentoController::class, 'create'])->name('documentos.cargar');
        Route::post('/documentos/guardar', [App\Http\Controllers\Proteccion\DocumentoController::class, 'store'])->name('documentos.guardar');
        Route::post('/documentos/guardar/final', [App\Http\Controllers\Proteccion\DocumentoController::class, 'guardarDocumentoFinal'])->name('documentos.guardar.final');
        
        // Consultas
        Route::get('/consultar', [App\Http\Controllers\Proteccion\ConsultaController::class, 'index'])->name('consultar');
        Route::get('/consultar/expediente/{id}', [App\Http\Controllers\Proteccion\ConsultaController::class, 'expediente'])->name('consultar.expediente');
        Route::get('/consultar/cotejar/{id}', [App\Http\Controllers\Proteccion\ConsultaController::class, 'cotejar'])->name('consultar.cotejar');
        Route::get('/ver-pdf/{path}', [App\Http\Controllers\Proteccion\ConsultaController::class, 'verPDF'])->name('ver.pdf')->where('path', '.*');
        
        // Historial
        Route::get('/historial', [App\Http\Controllers\Proteccion\HistorialController::class, 'index'])->name('historial');
        Route::get('/historial/ver/{id}', [App\Http\Controllers\Proteccion\HistorialController::class, 'verTramite'])->name('historial.ver');
        Route::get('/documento/{id}/detalle', [App\Http\Controllers\Proteccion\HistorialController::class, 'verDetalle'])->name('documento.detalle');
        Route::put('/documento/{id}/actualizar', [App\Http\Controllers\Proteccion\HistorialController::class, 'actualizarVigencia'])->name('documento.actualizar');
        Route::delete('/documento/{id}/eliminar', [App\Http\Controllers\Proteccion\HistorialController::class, 'eliminarDocumento'])->name('documento.eliminar');
        
        // Descargas
        Route::get('/descargar-documento', [App\Http\Controllers\Proteccion\ConsultaController::class, 'descargar'])->name('descargar.documento');
        Route::get('/ver-documento/{path}', [App\Http\Controllers\Proteccion\ConsultaController::class, 'verDocumento'])->name('ver.documento')->where('path', '.*');
        
        // Órdenes de cobro
        Route::get('/orden-cobro/{contribuyente_id}/{orden_id?}', [App\Http\Controllers\OrdenCobroController::class, 'form'])->name('orden.cobro.form')->defaults('area', 'proteccion');
        Route::post('/orden-cobro/store', [App\Http\Controllers\OrdenCobroController::class, 'store'])->name('orden.cobro.store')->defaults('area', 'proteccion');
        
        // Exportar
        Route::get('/historial/exportar-csv', [App\Http\Controllers\Proteccion\HistorialController::class, 'exportarCSV'])->name('historial.exportar.csv');
    });

// ============================================
// INGRESOS
// ============================================

Route::prefix('ingresos')
    ->middleware(['multi.session:ingresos', 'auth:ingresos', 'verified', 'area:4', 'rol:Administrador de área,Jefe de área,Usuario'])
    ->name('ingresos.')
    ->group(function () {
        // Documentos
        Route::get('/agregar-datos', [App\Http\Controllers\Ingresos\DocumentoController::class, 'index'])->name('documentos.index');
        Route::get('/agregar-datos/cargar/{contribuyente_id}', [App\Http\Controllers\Ingresos\DocumentoController::class, 'create'])->name('documentos.cargar');
        Route::post('/documentos/guardar', [App\Http\Controllers\Ingresos\DocumentoController::class, 'store'])->name('documentos.guardar');
        Route::post('/documentos/guardar/final', [App\Http\Controllers\Ingresos\DocumentoController::class, 'guardarDocumentoFinal'])->name('documentos.guardar.final');
        
        // Consultas
        Route::get('/consultar', [App\Http\Controllers\Ingresos\ConsultaController::class, 'index'])->name('consultar');
        Route::get('/consultar/expediente/{id}', [App\Http\Controllers\Ingresos\ConsultaController::class, 'expediente'])->name('consultar.expediente');
        Route::get('/consultar/cotejar/{id}', [App\Http\Controllers\Ingresos\ConsultaController::class, 'cotejar'])->name('consultar.cotejar');
        Route::get('/ver-pdf/{path}', [App\Http\Controllers\Ingresos\ConsultaController::class, 'verPDF'])->name('ver.pdf')->where('path', '.*');
        
        // Historial
        Route::get('/historial', [App\Http\Controllers\Ingresos\HistorialController::class, 'index'])->name('historial');
        Route::get('/documento/{id}/detalle', [App\Http\Controllers\Ingresos\HistorialController::class, 'verDetalle'])->name('documento.detalle');
        Route::put('/documento/{id}/actualizar', [App\Http\Controllers\Ingresos\HistorialController::class, 'actualizarVigencia'])->name('documento.actualizar');
        Route::delete('/documento/{id}/eliminar', [App\Http\Controllers\Ingresos\HistorialController::class, 'eliminarDocumento'])->name('documento.eliminar');
        
        // Descargas
        Route::get('/descargar-documento', [App\Http\Controllers\Ingresos\ConsultaController::class, 'descargar'])->name('descargar.documento');
        Route::get('/ver-documento/{path}', [App\Http\Controllers\Ingresos\ConsultaController::class, 'verDocumento'])->name('ver.documento')->where('path', '.*');
        
        // Órdenes de cobro
        Route::get('/ordenes-cobro', [App\Http\Controllers\OrdenCobroController::class, 'index'])->name('ordenes.cobro');
        Route::get('/orden-cobro/{id}', [App\Http\Controllers\OrdenCobroController::class, 'show'])->name('orden.cobro.show');
        Route::get('/orden-cobro/contribuyente/{contribuyente_id}', [App\Http\Controllers\OrdenCobroController::class, 'porContribuyente'])->name('orden.cobro.por.contribuyente');
        Route::get('/orden-cobro/{id}/descargar/{tipo}', [App\Http\Controllers\OrdenCobroController::class, 'descargarPdf'])->name('orden.cobro.descargar');
        Route::get('/orden-cobro/{id}/ver/{tipo}', [App\Http\Controllers\OrdenCobroController::class, 'verPdf'])->name('orden.cobro.ver');
        
        // Exportar
        Route::get('/historial/exportar-csv', [App\Http\Controllers\Ingresos\HistorialController::class, 'exportarCSV'])->name('historial.exportar.csv');
    });

require __DIR__.'/auth.php';