<?php
session_start();

// Incluye el archivo de conexión a la base de datos
include 'conexion2.php';

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
// Verifica si hay un correo electrónico enviado desde verificar_usuario.php
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Llama a la función para obtener el nombre asociado al correo electrónico
    $nombre = obtener_nombre($email, $db);

    // Muestra el mensaje de bienvenida personalizado
    echo "<h1>Bienvenido, $nombre</h1>";
} else {
    echo "No se proporcionó un correo electrónico.";
}

// Función para obtener el nombre asociado al correo electrónico en la base de datos
function obtener_nombre($email, $db) {
    // Query para obtener el nombre basado en el correo electrónico
    $query = "SELECT nombre FROM usuario WHERE email = ?";

    // Preparar la consulta
    $stmt = $db->prepare($query);

    // Bind de parámetros
    $stmt->bind_param('s', $email);

    // Ejecutar la consulta
    $stmt->execute();
    // Obtener el resultado de la consulta
    $result_nombre = $stmt->get_result();
    // extraer el resultado
    $row = $result_nombre->fetch_assoc();

    // Devolver el nombre si se encontró, de lo contrario, devuelve un mensaje predeterminado
    return $row ? $row['nombre'] : "Estudiante";
}
?>
