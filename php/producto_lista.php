<?php
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0; // Calcular el inicio de los registros a mostrar en la página

	$tabla=""; // Variable para almacenar la tabla HTML

	$campos="producto.producto_id,producto.producto_codigo,producto.producto_nombre,producto.producto_precio,producto.producto_stock,producto.producto_foto,producto.categoria_id,producto.usuario_id,categoria.categoria_id,categoria.categoria_nombre,usuario.usuario_id,usuario.usuario_nombre,usuario.usuario_apellido"; // Campos a seleccionar en la consulta

	if(isset($busqueda) && $busqueda!=""){ // Si se realiza una búsqueda

		$consulta_datos="SELECT $campos FROM producto INNER JOIN categoria ON producto.categoria_id=categoria.categoria_id INNER JOIN usuario ON producto.usuario_id=usuario.usuario_id WHERE producto.producto_codigo LIKE '%$busqueda%' OR producto.producto_nombre LIKE '%$busqueda%' ORDER BY producto.producto_nombre ASC LIMIT $inicio,$registros"; // Consulta para obtener los datos de los productos que coinciden con la búsqueda

		$consulta_total="SELECT COUNT(producto_id) FROM producto WHERE producto_codigo LIKE '%$busqueda%' OR producto_nombre LIKE '%$busqueda%'"; // Consulta para obtener el total de productos que coinciden con la búsqueda

	}elseif($categoria_id>0){ // Si se selecciona una categoría

		$consulta_datos="SELECT $campos FROM producto INNER JOIN categoria ON producto.categoria_id=categoria.categoria_id INNER JOIN usuario ON producto.usuario_id=usuario.usuario_id WHERE producto.categoria_id='$categoria_id' ORDER BY producto.producto_nombre ASC LIMIT $inicio,$registros"; // Consulta para obtener los datos de los productos de la categoría seleccionada

		$consulta_total="SELECT COUNT(producto_id) FROM producto WHERE categoria_id='$categoria_id'"; // Consulta para obtener el total de productos de la categoría seleccionada

	}else{ // Si no se realiza una búsqueda ni se selecciona una categoría

		$consulta_datos="SELECT $campos FROM producto INNER JOIN categoria ON producto.categoria_id=categoria.categoria_id INNER JOIN usuario ON producto.usuario_id=usuario.usuario_id ORDER BY producto.producto_nombre ASC LIMIT $inicio,$registros"; // Consulta para obtener todos los datos de los productos

		$consulta_total="SELECT COUNT(producto_id) FROM producto"; // Consulta para obtener el total de productos en general

	}

	$conexion=conexion(); // Conectar a la base de datos

	$datos = $conexion->query($consulta_datos); // Ejecutar la consulta de datos
	$datos = $datos->fetchAll(); // Obtener todos los registros

	$total = $conexion->query($consulta_total); // Ejecutar la consulta de total de registros
	$total = (int) $total->fetchColumn(); // Obtener el número total de registros como entero

	$Npaginas =ceil($total/$registros); // Calcular el número de páginas necesarias para mostrar todos los registros

	if($total>=1 && $pagina<=$Npaginas){ // Si hay registros y la página es válida
		$contador=$inicio+1; // Iniciar el contador de registros
		$pag_inicio=$inicio+1; // Registro inicial en la página

		foreach($datos as $rows){ // Recorrer los datos de los productos y construir las filas de la tabla
			$tabla.='
				<article class="media">
			        <figure class="media-left">
			            <p class="image is-64x64">';
			            if(is_file("./img/producto/".$rows['producto_foto'])){ // Verificar si existe la imagen del producto
			            	$tabla.='<img src="./img/producto/'.$rows['producto_foto'].'">';
			            }else{
			            	$tabla.='<img src="./img/producto.png">'; // Si no existe, mostrar una imagen por defecto
			            }
			   $tabla.='</p>
			        </figure>
			        <div class="media-content">
			            <div class="content">
			              <p>
			                <strong>'.$contador.' - '.$rows['producto_nombre'].'</strong><br>
			                <strong>CODIGO:</strong> '.$rows['producto_codigo'].', <strong>PRECIO:</strong> $'.$rows['producto_precio'].', <strong>STOCK:</strong> '.$rows['producto_stock'].', <strong>CATEGORIA:</strong> '.$rows['categoria_nombre'].', <strong>REGISTRADO POR:</strong> '.$rows['usuario_nombre'].' '.$rows['usuario_apellido'].'
			              </p>
			            </div>
			            <div class="has-text-right">
			                <a href="index.php?vista=product_img&product_id_up='.$rows['producto_id'].'" class="button is-link is-rounded is-small">Imagen</a>
			                <a href="index.php?vista=product_update&product_id_up='.$rows['producto_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
			                <a href="'.$url.$pagina.'&product_id_del='.$rows['producto_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
			            </div>
			        </div>
			    </article>

			    <hr>
            ';
            $contador++; // Incrementar el contador
		}
			$pag_final=$contador-1; // Registro final en la página
	}else{
		if($total>=1){ // Si hay registros pero la página no es válida
			$tabla.='
				<p class="has-text-centered" >
					<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
						Haga clic acá para recargar el listado
					</a>
				</p>
			';
		}else{ // Si no hay registros
			$tabla.='
				<p class="has-text-centered" >No hay registros en el sistema</p>
			';
		}
	}

	if($total>0 && $pagina<=$Npaginas){ // Si hay registros y la página es válida
		$tabla.='<p class="has-text-right">Mostrando productos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null; // Cerrar la conexión a la base de datos
	echo $tabla; // Imprimir la tabla HTML

	
?>
