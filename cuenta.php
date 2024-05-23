<?php
session_start();

// Incluimos el archivo de conexión a la base de datos
include 'conexion.php';

// Verificamos si hay un correo electrónico enviado desde verificar_usuario.php
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Llamamos a la función para verificar el tipo de usuario y redirigir según el tipo
    redirigir_según_tipo($email, $pdo); // Pasamos la conexión como argumento
} else {
    echo "No se proporcionó un correo electrónico.";
}

// Función para verificar el tipo de usuario en la base de datos y redirigir
function redirigir_según_tipo($email, $conn) {
    // Query para consultar el tipo de usuario basado en el correo electrónico
    $query = "SELECT id_perfil FROM usuario WHERE email = :email";
    
    // Preparamos la consulta
    $stmt = $conn->prepare($query);

    // Bind de parámetros
    $stmt->bindParam(':email', $email);

    // Ejecutamos la consulta
    $stmt->execute();

    // Obtenemos el resultado
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Si se encontró el correo en la tabla registros, obtenemos el tipo de usuario
        $tipo_usuario = $row['id_perfil'];

        // Redirigimos según el tipo de usuario
        switch ($tipo_usuario) {
            case 1:
                header("Location: docente.php");
                exit();
                break;
            case 2:
                header("Location: alumno.php");
                exit();
                break;
            case 3:
                header("Location: administrativo.php");
                exit();
                break;
            case 4:
                header("Location: director_fac.php");
                exit();
                break;
            default:
                echo "Tipo de usuario desconocido";
                break;
        }
    } else {
        // Si no se encontró el correo en la tabla registros
        echo "Correo no registrado";
    }
}
?>


