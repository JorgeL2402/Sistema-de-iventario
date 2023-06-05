<?php
function isTabletOrMobile()
{
    $tablet_browser = 0;
    $mobile_browser = 0;
 
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $tablet_browser++;
    }
 
    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $mobile_browser++;
    }
 
    if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) || ((isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE'])))) {
        $mobile_browser++;
    }
 
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
        'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
        'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
        'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
        'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
        'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
        'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
        'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
        'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
        'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-'
    );
 
    if (in_array($mobile_ua, $mobile_agents)) {
        $mobile_browser++;
    }
 
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera mini') > 0) {
        $mobile_browser++;
        $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
            $tablet_browser++;
        }
    }
 
    return ($tablet_browser > 0 || $mobile_browser > 0);
}

$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
$tabla = '';

if (isset($busqueda) && $busqueda != '') {
    // Consulta para buscar por nombre o ubicación si se proporciona una cadena de búsqueda
    $consulta_datos = "SELECT * FROM categoria WHERE categoria_nombre LIKE '%$busqueda%' OR categoria_ubicacion LIKE '%$busqueda%' ORDER BY categoria_nombre ASC LIMIT $inicio,$registros";
    $consulta_total = "SELECT COUNT(categoria_id) FROM categoria WHERE categoria_nombre LIKE '%$busqueda%' OR categoria_ubicacion LIKE '%$busqueda%'";
} else {
    // Consulta para obtener todos los datos de la tabla si no se proporciona una cadena de búsqueda
    $consulta_datos = "SELECT * FROM categoria ORDER BY categoria_nombre ASC LIMIT $inicio,$registros";
    $consulta_total = "SELECT COUNT(categoria_id) FROM categoria";
}

$conexion = conexion();

// Obtener los datos de la consulta de datos
$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

// Obtener el total de registros en la tabla
$total = $conexion->query($consulta_total);
$total = (int)$total->fetchColumn();

$Npaginas = ceil($total / $registros);

if (isTabletOrMobile()) {
    // Mostrar la lista de tarjetas en pantallas de tablet o móvil
    $tabla .= '<div class="columns is-multiline">';
    foreach ($datos as $rows) {
        // Generar tarjeta para cada categoría
        $tabla .= '
            <div class="column is-one-third">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <strong>Nombre:</strong> ' . $rows['categoria_nombre'] . '<br>
                            <strong>Ubicación:</strong> ' . substr($rows['categoria_ubicacion'], 0, 25) . '<br>
                            <strong>Productos:</strong> <a href="index.php?vista=product_category&category_id=' . $rows['categoria_id'] . '">Ver productos</a>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <a href="index.php?vista=category_update&category_id_up=' . $rows['categoria_id'] . '" class="card-footer-item">Actualizar</a>
                        <a href="' . $url . $pagina . '&category_id_del=' . $rows['categoria_id'] . '" class="card-footer-item">Eliminar</a>
                    </footer>
                </div>
            </div>
        ';
    }
    $tabla .= '</div>';
} else {
    // Mostrar la tabla en pantallas de PC o laptop
    $tabla .= '
        <div class="table-container">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th>Productos</th>
                        <th colspan="2">Opciones</th>
                    </tr>
                </thead>
                <tbody>
    ';

    if ($total >= 1 && $pagina <= $Npaginas) {
        $contador = $inicio + 1;
        $pag_inicio = $inicio + 1;
        foreach ($datos as $rows) {
            // Generar filas de la tabla con los datos de cada categoría
            $tabla .= '
                <tr class="has-text-centered">
                    <td>' . $contador . '</td>
                    <td>' . $rows['categoria_nombre'] . '</td>
                    <td>' . substr($rows['categoria_ubicacion'], 0, 25) . '</td>
                    <td>
                        <a href="index.php?vista=product_category&category_id=' . $rows['categoria_id'] . '" class="button is-link is-rounded is-small">Ver productos</a>
                    </td>
                    <td>
                        <a href="index.php?vista=category_update&category_id_up=' . $rows['categoria_id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="' . $url . $pagina . '&category_id_del=' . $rows['categoria_id'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;
        }
        $pag_final = $contador - 1;
    } else {
        if ($total >= 1) {
            // Mensaje de recarga si hay registros pero no se muestran en la página actual
            $tabla .= '
                <tr class="has-text-centered">
                    <td colspan="5">
                        <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                            Haga clic aquí para recargar el listado
                        </a>
                    </td>
                </tr>
            ';
        } else {
            // Mensaje de no hay registros si no hay registros en la tabla
            $tabla .= '
                <tr class="has-text-centered">
                    <td colspan="5">
                        No hay registros en el sistema
                    </td>
                </tr>
            ';
        }
    }

    $tabla .= '</tbody></table></div>';

    if ($total > 0 && $pagina <= $Npaginas) {
        // Mostrar información sobre los registros mostrados en la tabla
        $tabla .= '<p class="has-text-right">Mostrando categorías <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
    }
}

$conexion = null;
echo $tabla;


?>
