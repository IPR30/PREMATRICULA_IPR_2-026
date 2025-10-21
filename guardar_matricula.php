¡<?php
require_once "conexion.php";

// Verificar que llegan los datos
if (
    isset($_POST['codigoMatricula'], $_POST['nombre'], $_POST['dni'],
          $_POST['fechaNac'], $_POST['grado'], $_POST['seccion'],
          $_POST['retrasada'], $_POST['repite'], $_POST['encargado'], $_POST['telefono'])
) {
    $codigo = $_POST['codigoMatricula'];
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $fechaNac = $_POST['fechaNac'];
    $grado = $_POST['grado'];
    $seccion = $_POST['seccion'];
    $retrasada = $_POST['retrasada'];
    $repite = $_POST['repite'];
    $encargado = $_POST['encargado'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'] ?? '';

    // Verificar si ya existe una matrícula con el mismo DNI
    $check = $conexion->prepare("SELECT id FROM matriculas WHERE dni = ?");
    $check->bind_param("s", $dni);
    $check->execute();
    $resultado = $check->get_result();

    if ($resultado->num_rows > 0) {
        echo "DUPLICADO";
    } else {
        $stmt = $conexion->prepare("INSERT INTO matriculas 
            (codigoMatricula, nombre, dni, fechaNac, grado, seccion, retrasada, repite, encargado, telefono, correo) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss",
            $codigo, $nombre, $dni, $fechaNac, $grado, $seccion, 
            $retrasada, $repite, $encargado, $telefono, $correo
        );

        if ($stmt->execute()) {
            echo "OK";
        } else {
            echo "ERROR: " . $stmt->error;
        }

        $stmt->close();
    }

    $check->close();
    $conexion->close();
} else {
    echo "ERROR_DATOS";
}
?>
