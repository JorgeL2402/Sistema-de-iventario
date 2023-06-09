<div class="container is-fluid mb-6 has-text-centered">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Nuevo producto</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        // Incluir el archivo main.php que contiene la configuración y funciones principales
        require_once "./php/main.php";
    ?>

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/producto_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" onsubmit="return validarFormulario()">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Código de barra</label>
                    <input class="input" type="text" name="producto_codigo" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="producto_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Precio</label>
                    <input class="input" type="number" name="producto_precio" min="5" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Stock</label>
                    <input class="input" type="number" name="producto_stock" min="1" required>
                </div>
            </div>
            <div class="column">
                <label>Categoría</label><br>
                <div class="select is-rounded">
                    <select name="producto_categoria" required>
                        <option value="" selected="">Seleccione una opción</option>
                        <?php
                            // Obtener las categorías de la base de datos
                            $categorias = conexion();
                            $categorias = $categorias->query("SELECT * FROM categoria");
                            if ($categorias->rowCount() > 0) {
                                $categorias = $categorias->fetchAll();
                                foreach ($categorias as $row) {
                                    echo '<option value="' . $row['categoria_id'] . '">' . $row['categoria_nombre'] . '</option>';
                                }
                            }
                            $categorias = null;
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <label>Foto o imagen del producto</label><br>
                <div class="file is-small has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="producto_foto" accept=".jpg, .png, .jpeg">
                        <span class="file-cta">
                            <span class="file-label">Imagen</span>
                        </span>
                        <span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
                    </label>
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>

<script>
    function validarFormulario() {
        const precioInput = document.querySelector('input[name="producto_precio"]');
        const stockInput = document.querySelector('input[name="producto_stock"]');
        const precio = parseFloat(precioInput.value);
        const stock = parseInt(stockInput.value);

        if (precio <= 0) {
            alert('El precio debe ser mayor a cero.');
            return false;
        }

        if (stock <= 0) {
            alert('El stock debe ser mayor a cero.');
            return false;
        }

        return true;
    }
</script>
