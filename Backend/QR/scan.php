<?php
// Incluir el archivo de conexión a la base de datos
require_once "config.php";

// Verificar si se recibió un token válido
if (isset($_GET["token"])) {
    $token = $_GET["token"];

    // Consultar la base de datos para verificar si el token existe y no ha sido utilizado
    $sql = "SELECT * FROM qr_codes WHERE token = ? AND used = 0";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        // Si el token existe y no ha sido utilizado
        if (mysqli_stmt_num_rows($stmt) == 1) {
            // Registrar la asistencia del usuario en otra tabla (por ejemplo, la tabla asistencia)
            $user_id = $_SESSION["id"]; // Suponiendo que $_SESSION["id"] contiene el ID del usuario que inició sesión
            $timestamp = date("Y-m-d H:i:s"); // Obtener el timestamp actual

            $sql_asistencia = "INSERT INTO asistencia (user_id, timestamp) VALUES (?, ?)";
            if ($stmt_asistencia = mysqli_prepare($link, $sql_asistencia)) {
                mysqli_stmt_bind_param($stmt_asistencia, "is", $user_id, $timestamp);
                mysqli_stmt_execute($stmt_asistencia);
                mysqli_stmt_close($stmt_asistencia);

                // Actualizar el estado del token como utilizado en la tabla qr_codes
                $sql_update = "UPDATE qr_codes SET used = 1 WHERE token = ?";
                if ($stmt_update = mysqli_prepare($link, $sql_update)) {
                    mysqli_stmt_bind_param($stmt_update, "s", $token);
                    mysqli_stmt_execute($stmt_update);
                    mysqli_stmt_close($stmt_update);

                    // Devolver una respuesta de éxito
                    echo "success";
                } else {
                    echo "Error al actualizar el token en la base de datos";
                }
            } else {
                echo "Error al registrar la asistencia en la base de datos";
            }
        } else {
            echo "Token no válido o ya utilizado";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error al consultar la base de datos";
    }

    mysqli_close($link);
} else {
    echo "No se recibió ningún token";
}
?>
