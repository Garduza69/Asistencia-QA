<?php
// Incluir las bibliotecas de PHPMailer
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verifica si se recibió el token y el resultado por GET
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $resultado = $_GET['result'];

    // Configuración de la base de datos
    $servername = "localhost"; // Cambia localhost por el servidor de tu base de datos
    $username = "u712195824_sistema2"; // Cambia tu_usuario por el nombre de usuario de tu base de datos
    $password = "Cruzazul443"; // Cambia tu_contraseña por la contraseña de tu base de datos
    $dbname = "u712195824_sistema2"; // Cambia login por el nombre de tu base de datos

    // Crear conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta a la base de datos para obtener el correo asociado al token
    $sql = "SELECT correo FROM codigos_qr WHERE token = '$token'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $correo_destinatario = $row['correo'];

        // Ejemplo de envío de correo electrónico (reemplaza con tu código real)
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP (Gmail)
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sistemasotaventous@gmail.com'; // Cambia esto por tu dirección de correo electrónico
            $mail->Password = 'le a w w w o j o l i r q x j m'; // Cambia esto por tu contraseña de correo electrónico
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom($correo_destinatario, 'SOTAVENTO');
            $mail->addAddress($correo_destinatario);
            $mail->isHTML(true);

             // Consulta de id_notificacion para obtener el asunto y cuerpo del correo en la tabla notificaciones 
            $sql_notificacion = "SELECT asunto, cuerpo  FROM notificaciones WHERE id_notificacion = '$resultado'";
            $result_notificacion = $conn->query($sql_notificacion);
            if ($result_notificacion->num_rows > 0) {
                $row_notificacion = $result_notificacion->fetch_assoc();
                $asunto = $row_notificacion['asunto'];
                $cuerpo = $row_notificacion['cuerpo'];

                $mail->Subject = "$asunto";
                $mail->Body = "$cuerpo";

            // Envía el correo
            $mail->send();
            //Envía un mensaje cuando el lector haya escaneado el código QR
            echo $cuerpo;
            /*if ($resultado === "success") {
                echo 'Registro de asistencia exitoso.';
            } 
            elseif ($resultado === "registrado") {
                echo 'La asistencia ya ha sido registrada para este alumno y esta materia hoy.';
            }
            elseif ($resultado === "cerrado") {
                echo 'La clase ya ha sido cerrada.';
            }
            elseif ($resultado === "materia") {
                echo 'Error: La materia asociada al token no coincide con las materias que imparte el profesor.';
            }
            elseif ($resultado === "usado") {
                echo 'Error: El código ya fue usado';
            }elseif($resultado === "error") {
                echo 'Error al registrar la asistencia';
            }*/

            }
            
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: No se encontró ningún registro asociado al token.";
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} else {
    // Si el token o el resultado no se recibieron por GET, muestra un mensaje de error
    echo "Error: No se proporcionaron suficientes parámetros en la URL.";
}
?>

