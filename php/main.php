<?php

# Conexion a la base de datos #
function conexion(){
    $pdo = new PDO('mysql:host=localhost;dbname=inventario', 'root', 'Doraditas22*');
    return $pdo;
}

# Verificar datos #
function verificar_datos($filtro,$cadena){
    // Verificar si la cadena coincide con el filtro
    if(preg_match("/^".$filtro."$/", $cadena)){
        return false; // Los datos coinciden con el formato solicitado
    }else{
        return true; // Los datos no coinciden con el formato solicitado
    }
}


# Limpiar cadenas de texto #
function limpiar_cadena($cadena){
    // Eliminar espacios y barras invertidas al inicio y al final de la cadena
    $cadena=trim($cadena);
    $cadena=stripslashes($cadena);
    
    // Remover etiquetas y palabras clave potencialmente peligrosas
    $cadena=str_ireplace("<script>", "", $cadena);
    $cadena=str_ireplace("</script>", "", $cadena);
    $cadena=str_ireplace("<script src", "", $cadena);
    $cadena=str_ireplace("<script type=", "", $cadena);
    $cadena=str_ireplace("SELECT * FROM", "", $cadena);
    $cadena=str_ireplace("DELETE FROM", "", $cadena);
    $cadena=str_ireplace("INSERT INTO", "", $cadena);
    $cadena=str_ireplace("DROP TABLE", "", $cadena);
    $cadena=str_ireplace("DROP DATABASE", "", $cadena);
    $cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
    $cadena=str_ireplace("SHOW TABLES;", "", $cadena);
    $cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
    $cadena=str_ireplace("<?php", "", $cadena);
    $cadena=str_ireplace("?>", "", $cadena);
    $cadena=str_ireplace("--", "", $cadena);
    $cadena=str_ireplace("^", "", $cadena);
    $cadena=str_ireplace("<", "", $cadena);
    $cadena=str_ireplace("[", "", $cadena);
    $cadena=str_ireplace("]", "", $cadena);
    $cadena=str_ireplace("==", "", $cadena);
    $cadena=str_ireplace(";", "", $cadena);
    $cadena=str_ireplace("::", "", $cadena);

    // Eliminar espacios y barras invertidas al inicio y al final de la cadena nuevamente
    $cadena=trim($cadena);
    $cadena=stripslashes($cadena);

    return $cadena; // Devolver la cadena limpiada
}


# Funcion renombrar fotos #
function renombrar_fotos($nombre){
    // Reemplazar caracteres especiales y espacios en el nombre de la foto
    $nombre=str_ireplace(" ", "_", $nombre);
    $nombre=str_ireplace("/", "_", $nombre);
    $nombre=str_ireplace("#", "_", $nombre);
    $nombre=str_ireplace("-", "_", $nombre);
    $nombre=str_ireplace("$", "_", $nombre);
    $nombre=str_ireplace(".", "_", $nombre);
    $nombre=str_ireplace(",", "_", $nombre);
    $nombre=$nombre."_".rand(0,100); // Agregar un número aleatorio al final del nombre
    return $nombre; // Devolver el nuevo nombre de la foto
}


# Funcion subir foto #
function subir_foto($nombre,$directorio,$input_nombre){
    $temp=explode(".", $_FILES[$input_nombre]['name']); // Obtener la extension del archivo
    $extension=end($temp); // Obtener la ultima parte del array (la extension)
    
    if($_FILES[$input_nombre]['name']){
        move_uploaded_file($_FILES[$input_nombre]['tmp_name'],$directorio.$nombre.".".$extension); // Mover la foto al directorio especificado
    }
}


# Funcion verificar login #
function verificar_login($conexion, $usuario, $clave){
    // Verificar si el usuario y la contraseña son válidos en la base de datos
    $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE usuario=:usuario AND clave=:clave");
    $consulta->bindParam(':usuario', $usuario);
    $consulta->bindParam(':clave', $clave);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    
    if($resultado){
        return true; // Las credenciales son válidas
    }else{
        return false; // Las credenciales no son válidas
    }
}


# Funcion obtener lista de categorias #
function obtener_lista_categorias($conexion, $pagina, $registros, $busqueda){
    $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
    $tabla = "";

    if (isset($busqueda) && $busqueda != "") {
        // Consulta para buscar por nombre o ubicación si se proporciona una cadena de búsqueda
        $consulta_datos = "SELECT * FROM categoria WHERE categoria_nombre LIKE '%$busqueda%' OR categoria_ubicacion LIKE '%$busqueda%' ORDER BY categoria_nombre ASC LIMIT $inicio,$registros";
        $consulta_total = "SELECT COUNT(categoria_id) FROM categoria WHERE categoria_nombre LIKE '%$busqueda%' OR categoria_ubicacion LIKE '%$busqueda%'";
    } else {
        // Consulta para obtener todos los datos de la tabla si no se proporciona una cadena de búsqueda
        $consulta_datos = "SELECT * FROM categoria ORDER BY categoria_nombre ASC LIMIT $inicio,$registros";
        $consulta_total = "SELECT COUNT(categoria_id) FROM categoria";
    }

    // Obtener los datos de la consulta de datos
    $datos = $conexion->query($consulta_datos);
    $datos = $datos->fetchAll();

    // Obtener el total de registros en la tabla
    $total = $conexion->query($consulta_total);
    $total = (int) $total->fetchColumn();

    $Npaginas = ceil($total / $registros);

    if ($total >= 1 && $pagina <= $Npaginas) {
        $contador = $inicio + 1;
        $pag_inicio = $inicio + 1;
        foreach ($datos as $rows) {
            // Generar filas de la tabla con los datos de cada categoría
            if (is_mobile_or_tablet()) {
                // Mostrar tarjetas en dispositivos móviles y tabletas
                $tabla .= '
                        <div class="card mb-3">
                            <div class="card-content">
                                <div class="content">
                                    <p><strong>#' . $contador . '</strong></p>
                                    <p><strong>Nombre:</strong> ' . $rows['categoria_nombre'] . '</p>
                                    <p><strong>Ubicación:</strong> ' . substr($rows['categoria_ubicacion'], 0, 25) . '</p>
                                    <p>
                                        <a href="index.php?vista=product_category&category_id=' . $rows['categoria_id'] . '" class="button is-link is-rounded is-small">Ver productos</a>
                                        <a href="index.php?vista=category_update&category_id_up=' . $rows['categoria_id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
                                        <a href="' . $_SERVER['PHP_SELF'] . '?vista=category_delete&category_id_del=' . $rows['categoria_id'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
                                    </p>
                                </div>
                            </div>
                        </div>';
            } else {
                // Mostrar tabla en pantallas de escritorio
                $tabla .= '
                        <tr class="has-text-centered">
                            <td>' . $contador . '</td>
                            <td>' . $rows['categoria_nombre'] . '</td>
                            <td>' . $rows['categoria_ubicacion'] . '</td>
                            <td>
                                <a href="index.php?vista=product_category&category_id=' . $rows['categoria_id'] . '" class="button is-link is-rounded is-small">Ver productos</a>
                                <a href="index.php?vista=category_update&category_id_up=' . $rows['categoria_id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
                                <a href="' . $_SERVER['PHP_SELF'] . '?vista=category_delete&category_id_del=' . $rows['categoria_id'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
                            </td>
                        </tr>';
            }
            $contador++;
        }

        // Generar paginador
        $paginador = '<nav class="pagination is-centered" role="navigation" aria-label="pagination">
                        <ul class="pagination-list">';

        if ($pagina != 1) {
            $paginador .= '<li><a class="pagination-link" href="' . $_SERVER['PHP_SELF'] . '?pagina=1">&laquo;</a></li>';
        }

        for ($i = 1; $i <= $Npaginas; $i++) {
            if ($i == $pagina) {
                $paginador .= '<li><a class="pagination-link is-current">' . $i . '</a></li>';
            } else {
                $paginador .= '<li><a class="pagination-link" href="' . $_SERVER['PHP_SELF'] . '?pagina=' . $i . '">' . $i . '</a></li>';
            }
        }

        if ($pagina != $Npaginas) {
            $paginador .= '<li><a class="pagination-link" href="' . $_SERVER['PHP_SELF'] . '?pagina=' . $Npaginas . '">&raquo;</a></li>';
        }

        $paginador .= '</ul></nav>';

        return array($tabla, $paginador);
    } else {
        return array("No se encontraron categorías.", "");
    }
}


# Funcion verificar si la pantalla es móvil o tablet #
function is_mobile_or_tablet(){
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $mobileAgents = array("Android", "iPhone", "iPad", "BlackBerry", "Windows Phone");
    foreach ($mobileAgents as $agent) {
        if (strpos($userAgent, $agent) !== false) {
            return true;
        }
    }
    return false;
}

?>
