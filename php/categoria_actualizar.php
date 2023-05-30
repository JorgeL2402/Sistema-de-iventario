<?php
    require_once "main.php";

    /*== Almacenando id ==*/
    $id=limpiar_cadena($_POST['categoria_id']);

    /*== Verificando categoria ==*/
    $check_categoria=conexion();
    $check_categoria=$check_categoria->query("SELECT * FROM categoria WHERE categoria_id='$id'");

    if($check_categoria->rowCount()<=0){
        // Si no se encuentra la categoría en el sistema, muestra un mensaje de error.
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La categoría no existe en el sistema
            </div>
        ';
        exit();
    }else{
        $datos=$check_categoria->fetch();
    }
    $check_categoria=null;

    /*== Almacenando datos ==*/
    $nombre=limpiar_cadena($_POST['categoria_nombre']);
    $ubicacion=limpiar_cadena($_POST['categoria_ubicacion']);

    /*== Verificando campos obligatorios ==*/
    if($nombre==""){
        // Si el campo del nombre está vacío, muestra un mensaje de error.
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
        // Si el nombre no coincide con el formato solicitado, muestra un mensaje de error.
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if($ubicacion!=""){
        if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}",$ubicacion)){
            // Si la ubicación no coincide con el formato solicitado, muestra un mensaje de error.
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    La UBICACION no coincide con el formato solicitado
                </div>
            ';
            exit();
        }
    }

    /*== Verificando nombre ==*/
    if($nombre!=$datos['categoria_nombre']){
        $check_nombre=conexion();
        $check_nombre=$check_nombre->query("SELECT categoria_nombre FROM categoria WHERE categoria_nombre='$nombre'");
        if($check_nombre->rowCount()>0){
            // Si el nombre ingresado ya está registrado, muestra un mensaje de error.
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
                </div>
            ';
            exit();
        }
        $check_nombre=null;
    }

    /*== Actualizar datos ==*/
    $actualizar_categoria=conexion();
    $actualizar_categoria=$actualizar_categoria->prepare("UPDATE categoria SET categoria_nombre=:nombre,categoria_ubicacion=:ubicacion WHERE categoria_id=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":ubicacion"=>$ubicacion,
        ":id"=>$id
    ];

    if($actualizar_categoria->execute($marcadores)){
        // Si la actualización se realiza correctamente, muestra un mensaje de éxito.
        echo '
            <div class="notification is-info is-light">
                <strong>¡CATEGORIA ACTUALIZADA!</strong><br>
                La categoría se actualizó con éxito
            </div>
        ';
    }else{
        // Si no se puede actualizar la categoría, muestra un mensaje de error.
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo actualizar la categoría, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_categoria=null;
?>
