<!-- El siguiente código muestra un formulario para crear una nueva categoría -->

<!-- Contenedor principal con clases de diseño -->
<div class="container is-fluid mb-6 has-text-centered">
    <!-- Título de la página -->
    <h1 class="title">Categorías</h1>
    <!-- Subtítulo de la página -->
    <h2 class="subtitle">Nueva categoría</h2>
</div>

<!-- Contenedor secundario con clases de diseño -->
<div class="container pb-6 pt-6">

    <!-- División para mostrar mensajes de respuesta -->
    <div class="form-rest mb-6 mt-6"></div>

    <!-- Formulario para guardar una nueva categoría -->
    <form action="./php/categoria_guardar.php" method="POST" class="FormularioAjax" autocomplete="off">
        <!-- Columnas para organizar los campos del formulario -->
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="categoria_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Ubicación</label>
                    <input class="input" type="text" name="categoria_ubicacion" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}" maxlength="150" required>
                </div>
            </div>
        </div>
        <!-- Botón para guardar la categoría -->
        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>

<script>
    // Validar el formulario antes de enviarlo
    const form = document.querySelector('.FormularioAjax');
    form.addEventListener('submit', function (event) {
        const nombreInput = form.querySelector('input[name="categoria_nombre"]');
        const ubicacionInput = form.querySelector('input[name="categoria_ubicacion"]');
        const nombre = nombreInput.value.trim(); // Eliminar espacios en blanco al inicio y al final
        const ubicacion = ubicacionInput.value.trim(); // Eliminar espacios en blanco al inicio y al final

        if (nombre === '' || ubicacion === '') {
            event.preventDefault(); // Detener el envío del formulario
            alert('Ambos campos deben estar completos para guardar la categoría.');
        }
    });
</script>
