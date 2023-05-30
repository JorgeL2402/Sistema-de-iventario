<!-- El siguiente código muestra un encabezado de bienvenida en la página de inicio -->

<!-- Contenedor principal con clases de diseño -->
<div class="container is-fluid has-text-centered">
    <!-- Título de la página -->
    <h1 class="title">Home</h1>
    <!-- Subtítulo de bienvenida con el nombre y apellido del usuario -->
    <h2 class="subtitle">¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h2>
</div>
