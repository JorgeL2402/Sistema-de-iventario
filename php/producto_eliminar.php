<?php
	/*== Almacenando datos ==*/
	$product_id_del=limpiar_cadena($_GET['product_id_del']); // Obtener el ID del producto y limpiarlo

	/*== Verificando producto ==*/
	$check_producto=conexion(); // Conectar a la base de datos
	$check_producto=$check_producto->query("SELECT * FROM producto WHERE producto_id='$product_id_del'"); // Verificar si existe el producto en la base de datos

	if($check_producto->rowCount()==1){ // Si se encontró el producto

		$datos=$check_producto->fetch(); // Obtener los datos del producto

		$eliminar_producto=conexion(); // Conectar a la base de datos nuevamente
		$eliminar_producto=$eliminar_producto->prepare("DELETE FROM producto WHERE producto_id=:id"); // Preparar la consulta para eliminar el producto

		$eliminar_producto->execute([":id"=>$product_id_del]); // Ejecutar la consulta de eliminación del producto

		if($eliminar_producto->rowCount()==1){ // Si se eliminó el producto correctamente

			if(is_file("./img/producto/".$datos['producto_foto'])){ // Verificar si existe el archivo de la foto del producto
				chmod("./img/producto/".$datos['producto_foto'], 0777); // Cambiar los permisos del archivo
				unlink("./img/producto/".$datos['producto_foto']); // Eliminar el archivo de la foto del producto
			}

			echo '
				<div class="notification is-info is-light">
					<strong>¡PRODUCTO ELIMINADO!</strong><br>
					Los datos del producto se eliminaron con éxito
				</div>
			';
		}else{ // Si no se pudo eliminar el producto
			echo '
				<div class="notification is-danger is-light">
					<strong>¡Ocurrió un error inesperado!</strong><br>
					No se pudo eliminar el producto, por favor intente nuevamente
				</div>
			';
		}
		$eliminar_producto=null; // Liberar la consulta de eliminación del producto
	}else{ // Si no se encontró el producto
		echo '
			<div class="notification is-danger is-light">
				<strong>¡Ocurrió un error inesperado!</strong><br>
				El PRODUCTO que intenta eliminar no existe
			</div>
		';
	}
	$check_producto=null; // Liberar la consulta de verificación del producto
?>
