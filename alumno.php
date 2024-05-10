<?php
session_start();

// Incluye el archivo de conexión a la base de datos
include 'conexion.php';

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
// Verifica si hay un correo electrónico enviado desde verificar_usuario.php
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Llama a la función para obtener el nombre asociado al correo electrónico
    $nombre = obtener_nombre($email, $pdo);

    // Muestra el mensaje de bienvenida personalizado
    echo "<h1>Bienvenido, $nombre</h1>";
} else {
    echo "No se proporcionó un correo electrónico.";
}

// Función para obtener el nombre asociado al correo electrónico en la base de datos
function obtener_nombre($email, $conn) {
    // Query para obtener el nombre basado en el correo electrónico
    $query = "SELECT nombre FROM usuario WHERE email = :email";

    // Preparar la consulta
    $stmt = $conn->prepare($query);

    // Bind de parámetros
    $stmt->bindParam(':email', $email);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devolver el nombre si se encontró, de lo contrario, devuelve un mensaje predeterminado
    return $row ? $row['nombre'] : "Estudiante";
}
?>
