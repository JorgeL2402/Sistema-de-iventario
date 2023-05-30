<!-- El siguiente código muestra una lista de categorías con un paginador -->

<!-- Contenedor principal con clases de diseño -->
<div class="container is-fluid mb-6 has-text-centered">
    <!-- Título de la página -->
    <h1 class="title">Categorías</h1>
    <!-- Subtítulo de la página -->
    <h2 class="subtitle">Lista de categoría</h2>
</div>

<!-- Contenedor secundario con clases de diseño -->
<div class="container pb-6 pt-6">
    <?php
        // Incluye el archivo main.php
        require_once "./php/main.php";

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
        $url="index.php?vista=category_list&page="; /* <== */
        $registros=15;
        $busqueda="";

        // Mostrar el paginador de la lista de categorías
        require_once "./php/categoria_lista.php";
    ?>
</div>
