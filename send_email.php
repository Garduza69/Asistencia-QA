<?php
// Incluir las bibliotecas de PHPMailer
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Incluye el archivo de conexión a la base de datos
include 'conexion2.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verifica si se recibió el token y el resultado por GET
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $resultado = $_GET['result'];

    // Consulta a la base de datos para obtener el correo asociado al token
    $sql = "SELECT correo FROM codigos_qr WHERE token = '$token'";
    $result = $db->query($sql);

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
            $result_notificacion = $db->query($sql_notificacion);
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

            }
            
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: No se encontró ningún registro asociado al token.";
    }

    // Cierra la conexión a la base de datos
    $db->close();
} else {
    // Si el token o el resultado no se recibieron por GET, muestra un mensaje de error
    echo "Error: No se proporcionaron suficientes parámetros en la URL.";
}
?>

