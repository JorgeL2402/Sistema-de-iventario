<?php
    /*== Almacenando datos ==*/
    $category_id_del=limpiar_cadena($_GET['category_id_del']);

    /*== Verificando categoría ==*/
    $check_categoria=conexion();
    $check_categoria=$check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$category_id_del'");
    
    if($check_categoria->rowCount()==1){

        $check_productos=conexion();
        $check_productos=$check_productos->query("SELECT categoria_id FROM producto WHERE categoria_id='$category_id_del' LIMIT 1");

        if($check_productos->rowCount()<=0){
            // Si no hay productos asociados a la categoría, procede con la eliminación.

            $eliminar_categoria=conexion();
            $eliminar_categoria=$eliminar_categoria->prepare("DELETE FROM categoria WHERE categoria_id=:id");

            $eliminar_categoria->execute([":id"=>$category_id_del]);

            if($eliminar_categoria->rowCount()==1){
                // Si se elimina correctamente, muestra un mensaje de éxito.
                echo '
                    <div class="notification is-info is-light">
                        <strong>¡CATEGORIA ELIMINADA!</strong><br>
                        Los datos de la categoría se eliminaron con éxito
                    </div>
                ';
            }else{
                // Si no se puede eliminar la categoría, muestra un mensaje de error.
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        No se pudo eliminar la categoría, por favor intente nuevamente
                    </div>
                ';
            }
            $eliminar_categoria=null;
        }else{
            // Si hay productos asociados a la categoría, muestra un mensaje de error.
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    No podemos eliminar la categoría ya que tiene productos asociados
                </div>
            ';
        }
        $check_productos=null;
    }else{
        // Si la categoría que se intenta eliminar no existe, muestra un mensaje de error.
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La CATEGORIA que intenta eliminar no existe
            </div>
        ';
    }
    $check_categoria=null;
?>
