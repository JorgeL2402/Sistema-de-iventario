<div class="container is-fluid mb-6 has-text-centered">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Lista de usuarios</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        // Incluir el archivo main.php que contiene la configuración y funciones principales
        require_once "./php/main.php";

        # Eliminar usuario #
        // Verificar si se ha proporcionado el parámetro 'user_id_del' en la URL
        if(isset($_GET['user_id_del'])){
            // Incluir el archivo usuario_eliminar.php para manejar la eliminación del usuario
            require_once "./php/usuario_eliminar.php";
        }

        // Verificar si no se ha proporcionado el parámetro 'page' en la URL
        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            // Obtener el valor del parámetro 'page' de la URL y convertirlo a entero
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        // Limpiar la cadena de la variable 'pagina'
        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=user_list&page=";
        $registros=15;
        $busqueda="";

        # Paginador usuario #
        // Incluir el archivo usuario_lista.php que contiene la lógica para mostrar la lista de usuarios con paginación
        require_once "./php/usuario_lista.php";
    ?>
</div>
