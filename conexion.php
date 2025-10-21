<?php
$host = "localhost";
$usuario = "root";      // Usuario por defecto de XAMPP
$contrasena = "";        // Contraseña por defecto (vacía)
$base_datos = "matricula_escolar";

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");
?>
