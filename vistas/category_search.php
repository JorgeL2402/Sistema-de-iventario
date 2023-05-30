<!-- El siguiente código muestra un formulario para buscar categorías -->

<!-- Contenedor principal con clases de diseño -->
<div class="container is-fluid mb-6 has-text-centered">
    <!-- Título de la página -->
    <h1 class="title">Categorías</h1>
    <!-- Subtítulo de la página -->
    <h2 class="subtitle">Buscar categoría</h2>
</div>

<!-- Contenedor secundario con clases de diseño -->
<div class="container pb-6 pt-6">
    <?php
        // Incluye el archivo main.php
        require_once "./php/main.php";

        // Verifica si se ha enviado el formulario de búsqueda
        if(isset($_POST['modulo_buscador'])){
            require_once "./php/buscador.php";
        }

        // Verifica si no hay una búsqueda en sesión
        if(!isset($_SESSION['busqueda_categoria']) && empty($_SESSION['busqueda_categoria'])){
    ?>
    <!-- Formulario de búsqueda -->
    <div class="columns">
        <div class="column">
            <form action="" method="POST" autocomplete="off">
                <!-- Campo oculto para indicar el módulo de búsqueda -->
                <input type="hidden" name="modulo_buscador" value="categoria">
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_buscador" placeholder="¿Qué estás buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30">
                    </p>
                    <p class="control">
                        <button class="button is-info" type="submit">Buscar</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <?php }else{ ?>
    <!-- Mostrar resultados de búsqueda -->
    <div class="columns">
        <div class="column">
            <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off">
                <!-- Campos ocultos para indicar el módulo y eliminar la búsqueda -->
                <input type="hidden" name="modulo_buscador" value="categoria"> 
                <input type="hidden" name="eliminar_buscador" value="categoria">
                <p>Estás buscando <strong>“<?php echo $_SESSION['busqueda_categoria']; ?>”</strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded">Eliminar búsqueda</button>
            </form>
        </div>
    </div>

    <?php
            // Eliminar categoría
            if(isset($_GET['category_id_del'])){
                require_once "./php/categoria_eliminar.php";
            }

            // Configuración de la página actual
            if(!isset($_GET['page'])){
                $pagina=1;
            }else{
                $pagina=(int) $_GET['page'];
                if($pagina<=1){
                    $pagina=1;
                }
            }

            $pagina=limpiar_cadena($pagina);
            $url="index.php?vista=category_search&page="; /* <== */
            $registros=15;
            $busqueda=$_SESSION['busqueda_categoria']; /* <== */

            // Mostrar el paginador de la lista de categorías
            require_once "./php/categoria_lista.php";
        } 
    ?>
</div>
