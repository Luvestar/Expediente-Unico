{{-- Campos específicos por tipo de trámite --}}

@if($tramite->id == 3) {{-- Cobro ambulante --}}
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_nombre]" class="form-control">
    </div>
    <div class="form-group">
        <label>Dirección</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_direccion]" class="form-control">
    </div>
    <div class="form-group">
        <label>Nombre del producto a vender</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_producto]" class="form-control">
    </div>
@endif

@if($tramite->id == 4) {{-- Mercado Municipal --}}
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_nombre]" class="form-control">
    </div>
    <div class="form-group">
        <label>Dirección</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_direccion]" class="form-control">
    </div>
    <div class="form-group">
        <label>Nombre del producto a vender</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_producto]" class="form-control">
    </div>
@endif

@if($tramite->id == 5 || $tramite->id == 6) {{-- Corral de Consejo / Central de Abastos --}}
    <div class="form-group">
        <label>Monto</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_monto]" class="form-control">
    </div>
    <div class="form-group">
        <label>Fecha</label>
        <input type="date" name="campos_texto[{{ $tramite->id }}_fecha]" class="form-control">
    </div>
@endif

@if($tramite->id == 7 || $tramite->id == 8 || $tramite->id == 9) {{-- Inspecciones / Notificaciones --}}
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_nombre]" class="form-control">
    </div>
    <div class="form-group">
        <label>Fecha</label>
        <input type="date" name="campos_texto[{{ $tramite->id }}_fecha]" class="form-control">
    </div>
    <div class="form-group">
        <label>Ubicación</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_ubicacion]" class="form-control">
    </div>
@endif

@if($tramite->id == 10) {{-- Carga y Descarga --}}
    <div class="form-group">
        <label>Número de placas</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_placas]" class="form-control">
    </div>
    <div class="form-group">
        <label>Fecha</label>
        <input type="date" name="campos_texto[{{ $tramite->id }}_fecha]" class="form-control">
    </div>
    <div class="form-group">
        <label>Nombre de la empresa o persona</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_nombre]" class="form-control">
    </div>
    <div class="form-group">
        <label>Costo por m² (según ley)</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_costo]" class="form-control">
    </div>
@endif

@if($tramite->id == 11) {{-- Anuncios --}}
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_nombre]" class="form-control">
    </div>
    <div class="form-group">
        <label>Dirección</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_direccion]" class="form-control">
    </div>
    <div class="form-group">
        <label>Tipo de actividad y publicidad</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_tipo]" class="form-control">
    </div>
    <div class="form-group">
        <label>Costo por m² (según ley)</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_costo]" class="form-control">
    </div>
@endif

@if($tramite->id == 12) {{-- Temporada --}}
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_nombre]" class="form-control">
    </div>
    <div class="form-group">
        <label>Giro comercial</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_giro]" class="form-control">
    </div>
    <div class="form-group">
        <label>Nombre de la empresa</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_empresa]" class="form-control">
    </div>
    <div class="form-group">
        <label>Dirección</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_direccion]" class="form-control">
    </div>
    <div class="form-group">
        <label>Costo por m²</label>
        <input type="text" name="campos_texto[{{ $tramite->id }}_costo]" class="form-control">
    </div>
@endif