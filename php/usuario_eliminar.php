<?php

	/*== Almacenando datos ==*/
    $user_id_del=limpiar_cadena($_GET['user_id_del']); // Obtener el ID del usuario a eliminar y limpiar la cadena

    /*== Verificando usuario ==*/
    $check_usuario=conexion(); // Conectar a la base de datos y obtener una instancia de conexión
    $check_usuario=$check_usuario->query("SELECT usuario_id FROM usuario WHERE usuario_id='$user_id_del'"); // Verificar si el usuario existe en la base de datos
    
    if($check_usuario->rowCount()==1){ // Si el usuario existe

    	$check_productos=conexion(); // Conectar a la base de datos y obtener una instancia de conexión
    	$check_productos=$check_productos->query("SELECT usuario_id FROM producto WHERE usuario_id='$user_id_del' LIMIT 1"); // Verificar si el usuario tiene productos registrados

    	if($check_productos->rowCount()<=0){ // Si el usuario no tiene productos registrados
    		
	    	$eliminar_usuario=conexion(); // Conectar a la base de datos y obtener una instancia de conexión
	    	$eliminar_usuario=$eliminar_usuario->prepare("DELETE FROM usuario WHERE usuario_id=:id"); // Preparar la consulta de eliminación del usuario

	    	$eliminar_usuario->execute([":id"=>$user_id_del]); // Ejecutar la consulta de eliminación, pasando el ID del usuario como parámetro

	    	if($eliminar_usuario->rowCount()==1){ // Si se elimina correctamente el usuario
		        echo '
		            <div class="notification is-info is-light">
		                <strong>¡USUARIO ELIMINADO!</strong><br>
		                Los datos del usuario se eliminaron con éxito.
		            </div>
		        ';
		    }else{ // Si ocurre un error al eliminar el usuario
		        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrió un error inesperado!</strong><br>
		                No se pudo eliminar el usuario, por favor inténtelo nuevamente.
		            </div>
		        ';
		    }
		    $eliminar_usuario=null; // Liberar la consulta preparada
    	}else{ // Si el usuario tiene productos registrados
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrió un error inesperado!</strong><br>
	                No podemos eliminar el usuario ya que tiene productos registrados asociados.
	            </div>
	        ';
    	}
    	$check_productos=null; // Liberar la consulta de verificación de productos
    }else{ // Si el usuario no existe
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El USUARIO que intenta eliminar no existe.
            </div>
        ';
    }
    $check_usuario=null; // Liberar la consulta de verificación de usuario
?>
