<?php
    require_once "main.php";

    /*== Almacenando datos ==*/
    $nombre=limpiar_cadena($_POST['categoria_nombre']);
    $ubicacion=limpiar_cadena($_POST['categoria_ubicacion']);


    /*== Verificando campos obligatorios ==*/
    if($nombre==""){
        // Si el campo de nombre está vacío, muestra un mensaje de error.
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos obligatorios
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
    $check_nombre=conexion();
    $check_nombre=$check_nombre->query("SELECT categoria_nombre FROM categoria WHERE categoria_nombre='$nombre'");
    if($check_nombre->rowCount()>0){
        // Si el nombre ingresado ya existe, muestra un mensaje de error.
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_nombre=null;


    /*== Guardando datos ==*/
    $guardar_categoria=conexion();
    $guardar_categoria=$guardar_categoria->prepare("INSERT INTO categoria(categoria_nombre,categoria_ubicacion) VALUES(:nombre,:ubicacion)");

    $marcadores=[
        ":nombre"=>$nombre,
        ":ubicacion"=>$ubicacion
    ];

    $guardar_categoria->execute($marcadores);

    if($guardar_categoria->rowCount()==1){
        // Si se registra correctamente, muestra un mensaje de éxito.
        echo '
            <div class="notification is-info is-light">
                <strong>¡CATEGORIA REGISTRADA!</strong><br>
                La categoría se registró con éxito
            </div>
        ';
    }else{
        // Si no se puede registrar la categoría, muestra un mensaje de error.
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo registrar la categoría, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_categoria=null;
?>
