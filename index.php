<?php require "./inc/session_start.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <?php include "./inc/head.php"; ?>
    </head>
    <body>
        <?php

            // Verificar si no se ha proporcionado el parámetro 'vista' en la URL o si está vacío
            if(!isset($_GET['vista']) || $_GET['vista']==""){
                $_GET['vista']="login";
            }

            // Verificar si existe un archivo correspondiente a la vista proporcionada y si no es la vista de login ni la vista de error 404
            if(is_file("./vistas/".$_GET['vista'].".php") && $_GET['vista']!="login" && $_GET['vista']!="404"){

                /*== Cerrar sesion ==*/
                // Verificar si no se ha iniciado sesión o si la sesión ha expirado
                if((!isset($_SESSION['id']) || $_SESSION['id']=="") || (!isset($_SESSION['usuario']) || $_SESSION['usuario']=="")){
                    // Incluir el archivo logout.php para cerrar la sesión y redirigir al usuario al inicio de sesión
                    include "./vistas/logout.php";
                    exit();
                }

                // Incluir el archivo navbar.php para mostrar la barra de navegación
                include "./inc/navbar.php";

                // Incluir el archivo de la vista correspondiente
                include "./vistas/".$_GET['vista'].".php";

                // Incluir el archivo script.php que contiene scripts adicionales
                include "./inc/script.php";

            }else{
                // Verificar si la vista es la de login
                if($_GET['vista']=="login"){
                    // Incluir el archivo login.php para mostrar el formulario de inicio de sesión
                    include "./vistas/login.php";
                }else{
                    // Incluir el archivo 404.php para mostrar la página de error 404
                    include "./vistas/404.php";
                }
            }
        ?>
    </body>
</html>
