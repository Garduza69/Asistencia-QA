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

        // Ejemplo de envío de correo electrónico
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
} 

//verifica si se recibió el email y parcial de la captura_cal
if (isset($_GET['email']) && isset($_GET['parcial'])){
    $correo_destinatario = $_GET['email'];
    $parcial = $_GET['parcial'];
    $materia = $_GET['materia'];
    $facultad = $_GET['facultad'];

    // Ejemplo de envío de correo electrónico
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

        $asunto = "Calificacion del " . $parcial . " recibida";
        $cuerpo = "Se subieron correctamente las califiaciones del " . $parcial . " de la materia " . $materia . " de " . $facultad;

        $mail->Subject = "$asunto";
        $mail->Body = "$cuerpo";

        // Envía el correo
        $mail->send();
        echo $cuerpo;
        header("Location: reportes/captura_cal.php");

    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }


}
?>

