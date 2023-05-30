<?php
    
require_once "main.php"; // Incluir archivo main.php que contiene las funciones y la configuración necesaria

/*== Almacenando datos ==*/
$nombre=limpiar_cadena($_POST['usuario_nombre']); // Obtener y limpiar el nombre del usuario
$apellido=limpiar_cadena($_POST['usuario_apellido']); // Obtener y limpiar el apellido del usuario

$usuario=limpiar_cadena($_POST['usuario_usuario']); // Obtener y limpiar el nombre de usuario
$email=limpiar_cadena($_POST['usuario_email']); // Obtener y limpiar el email del usuario

$clave_1=limpiar_cadena($_POST['usuario_clave_1']); // Obtener y limpiar la primera clave
$clave_2=limpiar_cadena($_POST['usuario_clave_2']); // Obtener y limpiar la segunda clave


/*== Verificando campos obligatorios ==*/
if($nombre=="" || $apellido=="" || $usuario=="" || $clave_1=="" || $clave_2==""){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios.
        </div>
    ';
    exit();
}


/*== Verificando integridad de los datos ==*/
if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El NOMBRE no coincide con el formato solicitado.
        </div>
    ';
    exit();
}

if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El APELLIDO no coincide con el formato solicitado.
        </div>
    ';
    exit();
}

if(verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El USUARIO no coincide con el formato solicitado.
        </div>
    ';
    exit();
}

if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            Las CLAVES no coinciden con el formato solicitado.
        </div>
    ';
    exit();
}


/*== Verificando email ==*/
if($email!=""){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $check_email=conexion(); // Conectar a la base de datos y obtener una instancia de conexión
        $check_email=$check_email->query("SELECT usuario_email FROM usuario WHERE usuario_email='$email'"); // Verificar si el correo electrónico ya está registrado

        if($check_email->rowCount()>0){ // Si el correo electrónico ya está registrado
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    El correo electrónico ingresado ya se encuentra registrado, por favor elija otro.
                </div>
            ';
            exit();
        }
        $check_email=null; // Liberar la consulta
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Ha ingresado un correo electrónico no válido.
            </div>
        ';
        exit();
    } 
}


/*== Verificando usuario ==*/
$check_usuario=conexion(); // Conectar a la base de datos y obtener una instancia de conexión
$check_usuario=$check_usuario->query("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'"); // Verificar si el nombre de usuario ya está registrado

if($check_usuario->rowCount()>0){ // Si el nombre de usuario ya está registrado
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El USUARIO ingresado ya se encuentra registrado, por favor elija otro.
        </div>
    ';
    exit();
}
$check_usuario=null; // Liberar la consulta


/*== Verificando claves ==*/
if($clave_1!=$clave_2){ // Si las claves no coinciden
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            Las CLAVES que ha ingresado no coinciden.
        </div>
    ';
    exit();
}else{
    $clave=password_hash($clave_1,PASSWORD_BCRYPT,["cost"=>10]); // Generar el hash de la clave usando Bcrypt
}


/*== Guardando datos ==*/
$guardar_usuario=conexion(); // Conectar a la base de datos y obtener una instancia de conexión
$guardar_usuario=$guardar_usuario->prepare("INSERT INTO usuario(usuario_nombre,usuario_apellido,usuario_usuario,usuario_clave,usuario_email) VALUES(:nombre,:apellido,:usuario,:clave,:email)"); // Preparar la consulta de inserción de usuario

$marcadores=[
    ":nombre"=>$nombre,
    ":apellido"=>$apellido,
    ":usuario"=>$usuario,
    ":clave"=>$clave,
    ":email"=>$email
];

$guardar_usuario->execute($marcadores); // Ejecutar la consulta de inserción, pasando los marcadores como parámetros

if($guardar_usuario->rowCount()==1){ // Si se registra correctamente el usuario
    echo '
        <div class="notification is-info is-light">
            <strong>¡USUARIO REGISTRADO!</strong><br>
            El usuario se registró con éxito.
        </div>
    ';
}else{ // Si ocurre un error al registrar el usuario
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo registrar el usuario, por favor inténtelo nuevamente.
        </div>
    ';
}
$guardar_usuario=null; // Liberar la consulta
?>
