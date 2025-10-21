<?php
// === CONEXIÓN A LA BASE DE DATOS ===
$servername = "localhost";
$username = "root"; // Usuario por defecto de XAMPP
$password = "";     // Contraseña vacía por defecto de XAMPP
$dbname = "matriculas_db"; // Nombre de la BD

// Obtener el DNI desde la solicitud GET
$dni = $_GET['dni'] ?? '';

if (empty($dni)) {
    echo "ERROR: DNI no proporcionado";
    exit;
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para verificar la existencia del DNI
    $stmt = $conn->prepare("SELECT COUNT(*) FROM alumnos WHERE dni = :dni");
    $stmt->bindParam(':dni', $dni);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    // Devuelve "SI" o "NO" al JavaScript
    if ($count > 0) {
        echo "SI";
    } else {
        echo "NO";
    }

} catch(PDOException $e) {
    // Retorna un error para que el JS sepa que algo falló
    echo "ERROR_BD: Fallo de conexión o consulta: " . $e->getMessage();
}

$conn = null;
?>