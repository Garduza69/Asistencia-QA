<?php
// Incluir la biblioteca PHP QR Code para generar el código QR
require_once 'C:\xampp\htdocs\25-Navegacion_Fija\qr-code-main\src\QrCode.php';
require_once 'C:\xampp\htdocs\25-Navegacion_Fija\qr-code-main\src\QrCodeInterface.php';

// Verificar si se ha enviado una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    $fecha_hora = isset($_POST["fecha_hora"]) ? $_POST["fecha_hora"] : '';
    $materia = isset($_POST["materia"]) ? $_POST["materia"] : '';

    // Generar el token para el código QR
    $token = uniqid();

    // Crear el contenido del código QR con la información necesaria
    $qrContent = "Correo: $email\nFecha: $fecha_hora\nMateria: $materia";

    // Configurar la generación del código QR
    $qrConfig = [
        'cacheDir' => 'qr_codes/', // Directorio donde se guardará el código QR
        'errorCorrectionLevel' => 'L', // Nivel de corrección de errores (L, M, Q, H)
        'matrixPointSize' => 10 // Tamaño del punto en la matriz
    ];

    try {
        // Generar el código QR y obtener la ruta de la imagen
        $qrImagePath = QRcode::png($qrContent, $qrConfig['cacheDir'] . $token . '.png', $qrConfig['errorCorrectionLevel'], $qrConfig['matrixPointSize']);

        // Mostrar el código QR generado en la página web
        echo '<img src="' . $qrImagePath . '" alt="Código QR">';
    } catch (\Exception $e) {
        // Manejar errores si la generación del código QR falla
        echo "Error al generar el código QR: " . $e->getMessage();
    }
}
?>



