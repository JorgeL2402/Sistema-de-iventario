<?php
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0; // Calcular el valor de inicio para la consulta LIMIT

	$tabla=""; // Variable para almacenar el código HTML de la tabla

	if(isset($busqueda) && $busqueda!=""){ // Si se ha realizado una búsqueda

		$consulta_datos="SELECT * FROM usuario WHERE ((usuario_id!='".$_SESSION['id']."') AND (usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%' OR usuario_email LIKE '%$busqueda%')) ORDER BY usuario_nombre ASC LIMIT $inicio,$registros"; // Consulta para obtener los datos filtrados

		$consulta_total="SELECT COUNT(usuario_id) FROM usuario WHERE ((usuario_id!='".$_SESSION['id']."') AND (usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%' OR usuario_email LIKE '%$busqueda%'))"; // Consulta para obtener el total de registros filtrados

	}else{ // Si no se ha realizado una búsqueda

		$consulta_datos="SELECT * FROM usuario WHERE usuario_id!='".$_SESSION['id']."' ORDER BY usuario_nombre ASC LIMIT $inicio,$registros"; // Consulta para obtener todos los datos

		$consulta_total="SELECT COUNT(usuario_id) FROM usuario WHERE usuario_id!='".$_SESSION['id']."'"; // Consulta para obtener el total de registros sin filtrar
		
	}

	$conexion=conexion(); // Conectar a la base de datos y obtener una instancia de conexión

	$datos = $conexion->query($consulta_datos); // Ejecutar la consulta de datos
	$datos = $datos->fetchAll(); // Obtener todos los registros como un array

	$total = $conexion->query($consulta_total); // Ejecutar la consulta de total de registros
	$total = (int) $total->fetchColumn(); // Obtener el total de registros como un entero

	$Npaginas = ceil($total/$registros); // Calcular el número total de páginas

	$tabla.='
	<div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                	<th>#</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
	';

	if($total>=1 && $pagina<=$Npaginas){ // Si hay registros y la página es válida
		$contador=$inicio+1; // Inicializar contador de registros
		$pag_inicio=$inicio+1; // Inicializar número de registro en la página inicial
		foreach($datos as $rows){ // Recorrer los registros obtenidos
			$tabla.='
				<tr class="has-text-centered" >
					<td>'.$contador.'</td>
                    <td>'.$rows['usuario_nombre'].'</td>
                    <td>'.$rows['usuario_apellido'].'</td>
                    <td>'.$rows['usuario_usuario'].'</td>
                    <td>'.$rows['usuario_email'].'</td>
                    <td>
                        <a href="index.php?vista=user_update&user_id_up='.$rows['usuario_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&user_id_del='.$rows['usuario_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;
		}
		$pag_final=$contador-1; // Obtener número de registro en la página final
	}else{
		if($total>=1){ // Si hay registros, pero la página es inválida
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="7">
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic acá para recargar el listado
						</a>
					</td>
				</tr>
			';
		}else{ // Si no hay registros
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="7">
						No hay registros en el sistema
					</td>
				</tr>
			';
		}
	}

	$tabla.='</tbody></table></div>'; // Cerrar la tabla HTML

	if($total>0 && $pagina<=$Npaginas){ // Si hay registros y la página es válida
		$tabla.='<p class="has-text-right">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>'; // Mostrar información de paginación
	}

	$conexion=null; // Cerrar la conexión a la base de datos
	echo $tabla; // Imprimir la tabla HTML

	if($total>=1 && $pagina<=$Npaginas){ // Si hay registros y la página es válida
		echo paginador_tablas($pagina,$Npaginas,$url,7); // Imprimir el paginador
	}
?>
