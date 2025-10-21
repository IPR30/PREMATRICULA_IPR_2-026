<?php
// === CONEXIÓN A LA BASE DE DATOS ===
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "matriculas_db";

// Obtener datos del formulario
// Usamos el operador ternario para evitar errores si la variable no existe
$codigo_matricula = $_POST['codigoMatricula'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$dni = $_POST['dni'] ?? '';
$fecha_nac = $_POST['fechaNac'] ?? '';
$grado = $_POST['grado'] ?? '';
$seccion = $_POST['seccion'] ?? '';
$encargado = $_POST['encargado'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$correo = $_POST['correo'] ?? '';
$repite = $_POST['repite'] ?? '';
$retrasada = $_POST['retrasada'] ?? '';

if (empty($dni) || empty($codigo_matricula) || empty($nombre)) {
    echo "ERROR: Datos requeridos incompletos";
    exit;
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta de inserción con marcadores de posición para seguridad
    $sql = "INSERT INTO alumnos (codigo_matricula, nombre, dni, fecha_nac, grado, seccion, encargado, telefono, correo, repite, retrasada)
            VALUES (:codigo, :nombre, :dni, :fecha_nac, :grado, :seccion, :encargado, :telefono, :correo, :repite, :retrasada)";

    $stmt = $conn->prepare($sql);

    // Vincular y ejecutar
    $stmt->bindParam(':codigo', $codigo_matricula);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':dni', $dni);
    $stmt->bindParam(':fecha_nac', $fecha_nac);
    $stmt->bindParam(':grado', $grado);
    $stmt->bindParam(':seccion', $seccion);
    $stmt->bindParam(':encargado', $encargado);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':repite', $repite);
    $stmt->bindParam(':retrasada', $retrasada);

    $stmt->execute();

    // Respuesta de éxito para el JavaScript
    echo "OK";

} catch(PDOException $e) {
    // Manejo de errores de base de datos
    echo "ERROR_BD: Fallo al guardar en BD: " . $e->getMessage();
}

$conn = null;
?>
