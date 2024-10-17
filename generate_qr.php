<?php
session_start();

require 'phpqrcode/qrlib.php';
require_once "conexion2.php";

// Verificar si el usuario está autenticado y obtener su correo electrónico
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Consultar el idUsuario del usuario autenticado
    $stmt_usuario = $db->query("SELECT idUsuario FROM usuario WHERE Email = '$email'");
    $row_usuario = $stmt_usuario->fetch_assoc();

    if ($row_usuario) {
        $userId = $row_usuario['idUsuario'];
    } else {
        // Manejar el error apropiadamente si el usuario no se encuentra en la base de datos
        exit("Error: Usuario no encontrado en la base de datos.");
    }
} else {
    // Manejar el error si el usuario no está autenticado
    exit("Error: Usuario no autenticado.");
}

// Generar un token único para el código QR
$token = bin2hex(random_bytes(16)); // Generar un token hexadecimal de 16 bytes

// Insertar el token, correo electrónico, idUsuario y materia_id en la tabla codigos_qr
$sql = "INSERT INTO codigos_qr (token, correo, id_usuario) VALUES (?, ?, ?)";
$stmt_insert = $db->prepare($sql);
 // Enlazar los parámetros a la consulta preparada (tipos: string, string, integer)
$stmt_insert->bind_param('ssi', $token, $email, $userId); // 'ssi' = 2 strings y 1 integer
$stmt_insert->execute();
$stmt_insert->close();


// Obtener el materia_id seleccionado desde la solicitud GET
if (isset($_GET['materia_id'])) {
    $materia_id = $_GET['materia_id'];

    // Consultar el id_codigo asociado al codigo qr recien creado
    $sql_codigo = "SELECT id_codigo FROM codigos_qr WHERE  token= ?";
    $stmt_codigo = $db->prepare($sql_codigo);
    $stmt_codigo->bind_param('s', $token);
    $stmt_codigo->execute();
    // Obtener el resultado de la consulta
    $result_codigo = $stmt_codigo->get_result();
    //extraer los datos de la consulta
    $row_codigo = $result_codigo->fetch_assoc();
    $id_codigo = $row_codigo['id_codigo'];

    // Insertar el id_codigo ligado al código qr creado y la materia_id
    $sql = "INSERT INTO materia_qr (id_codigo, materia_id) VALUES ( ?, ?)";
    $stmt_insertmat = $db->prepare($sql);
    $stmt_insertmat->bind_param('ii', $id_codigo, $materia_id);
    $stmt_insertmat->execute();
    $stmt_insertmat->close();

} 


// Ruta y nombre del archivo generado
$dir = 'temp/';
if (!file_exists($dir)) {
    mkdir($dir);
}
$filename = $dir . 'test' . $token . '.png';

// Parámetros de Configuración para generar el código QR
$tamanio = 10; // Tamaño de Pixel
$level = 'L'; // Precisión Baja
$framSize = 3; // Tamaño en blanco

// Generar el código QR y guardar el archivo
QRcode::png($token, $filename, $level, $tamanio, $framSize);

// Retornar la ruta del archivo generado
echo $filename;
?>
