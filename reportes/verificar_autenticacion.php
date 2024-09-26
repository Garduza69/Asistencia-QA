<?php
session_start();

// Verificar si hay una sesión de usuario iniciada y si el usuario está autorizado
if (isset($_SESSION['email']) && $_SESSION['email'] == "isc20.gerson.sahagun@us.edu.mx") {
    // El usuario está autenticado y autorizado
    echo json_encode(['autenticado' => true]);
} else {
    // El usuario no está autenticado o no está autorizado
    echo json_encode(['autenticado' => false]);
}
?>
