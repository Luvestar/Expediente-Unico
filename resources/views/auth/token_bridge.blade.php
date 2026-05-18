<!DOCTYPE html>
<html>
<head><title>Cargando sesión...</title></head>
<body>
    <script>
        // Guardar el token en el almacenamiento de la pestaña
        const token = "{{ $token }}";
        const destination = "{{ $redirect }}";
        
        sessionStorage.setItem('sanctum_token', token);
        
        // Redirigir mediante JS para que la pestaña mantenga el estado
        window.location.href = destination;
    </script>
</body>
</html>