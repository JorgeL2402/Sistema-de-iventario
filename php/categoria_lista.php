<?php
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	$tabla="";

	if(isset($busqueda) && $busqueda!=""){

		// Consulta para buscar por nombre o ubicación si se proporciona una cadena de búsqueda
		$consulta_datos="SELECT * FROM categoria WHERE categoria_nombre LIKE '%$busqueda%' OR categoria_ubicacion LIKE '%$busqueda%' ORDER BY categoria_nombre ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(categoria_id) FROM categoria WHERE categoria_nombre LIKE '%$busqueda%' OR categoria_ubicacion LIKE '%$busqueda%'";

	}else{

		// Consulta para obtener todos los datos de la tabla si no se proporciona una cadena de búsqueda
		$consulta_datos="SELECT * FROM categoria ORDER BY categoria_nombre ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(categoria_id) FROM categoria";
		
	}

	$conexion=conexion();

	// Obtener los datos de la consulta de datos
	$datos = $conexion->query($consulta_datos);
	$datos = $datos->fetchAll();

	// Obtener el total de registros en la tabla
	$total = $conexion->query($consulta_total);
	$total = (int) $total->fetchColumn();

	$Npaginas = ceil($total/$registros);

	$tabla.='
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

	if($total>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){
			// Generar filas de la tabla con los datos de cada categoría
			$tabla.='
				<tr class="has-text-centered" >
					<td>'.$contador.'</td>
                    <td>'.$rows['categoria_nombre'].'</td>
                    <td>'.substr($rows['categoria_ubicacion'],0,25).'</td>
                    <td>
                        <a href="index.php?vista=product_category&category_id='.$rows['categoria_id'].'" class="button is-link is-rounded is-small">Ver productos</a>
                    </td>
                    <td>
                        <a href="index.php?vista=category_update&category_id_up='.$rows['categoria_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&category_id_del='.$rows['categoria_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;
		}
		$pag_final=$contador-1;
	}else{
		if($total>=1){
			// Mensaje de recarga si hay registros pero no se muestran en la página actual
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="5">
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic acá para recargar el listado
						</a>
					</td>
				</tr>
			';
		}else{
			// Mensaje de no hay registros si no hay registros en la tabla
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="5">
						No hay registros en el sistema
					</td>
				</tr>
			';
		}
	}

	$tabla.='</tbody></table></div>';

	if($total>0 && $pagina<=$Npaginas){
		// Mostrar información sobre los registros mostrados en la tabla
		$tabla.='<p class="has-text-right">Mostrando categorías <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;

	if($total>=1 && $pagina<=$Npaginas){
		// Mostrar el paginador si hay registros y la página actual es válida
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}
?>
