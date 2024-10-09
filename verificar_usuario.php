<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión con Google y obtiene su correo electrónico de la sesión
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Consulta la base de datos para verificar si el correo electrónico está en la tabla usuario
    // Reemplaza 'conexion.php' con el nombre de tu archivo de conexión a la base de datos
    include 'conexion2.php'; // Incluye el archivo de conexión

    $stmt = $db->prepare("SELECT * FROM usuario WHERE email = ?");
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $result_stmt = $stmt->get_result();
    $usuario = $result_stmt->fetch_assoc();

    // Si el usuario existe en la base de datos, redirige a la página protegida (cuenta.php)
    if ($usuario) {
        header("Location: cuenta.php");
        exit();
    } else {
        // Si el usuario no existe en la base de datos, muestra un mensaje de error
        echo "El usuario no está autorizado para acceder a esta página.";
        // O redirige a una página de error si lo deseas
        // header("Location: error.php");
        // exit();
    }
} else {
    // Si el usuario no ha iniciado sesión con Google, muestra un mensaje de error
    echo "El usuario no ha iniciado sesión con Google.";
    // O redirige a una página de error si lo deseas
    // header("Location: error.php");
    // exit();
}
?>