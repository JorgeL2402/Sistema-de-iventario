<?php
$conexion = mysqli_connect("localhost", "root", "Doraditas22*", "inventario");

// Verificar si la conexión se estableció correctamente
if (mysqli_connect_errno()) {
    echo "Error al conectar a MySQL: " . mysqli_connect_error();
    exit();
}

// Establecer la codificación de caracteres UTF-8
mysqli_set_charset($conexion, 'utf8');

