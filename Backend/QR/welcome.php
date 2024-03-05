<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

	//Agregamos la librería para genera códigos QR
	require 'phpqrcode/qrlib.php';

    // Include config file
    require_once "config.php";

    // Get the user's username from the session
    $username = $_SESSION["username"];


    // Generate a unique token for this user's QR code
    $token = bin2hex(random_bytes(16)); // Generate a hexadecimal token of 16 bytes

    // Guardar el token en la base de datos junto con el nombre de usuario
    // Suponiendo que $username contiene el nombre de usuario del usuario actual
    $sql = "INSERT INTO qr_codes (token, usuario) VALUES (?, ?)";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("ss", $token, $username);
    $stmt->execute();
    $stmt->close();

	
	//Declaramos una carpeta temporal para guardar la imágenes generadas
	$dir = 'temp/';
	
	//Si no existe la carpeta la creamos
	if (!file_exists($dir))
        mkdir($dir);
	
        //Declaramos la ruta y nombre del archivo a generar
	$filename = $dir.'test'. $token .'.png';

        //Parámetros de Configuración
	
	$tamanio = 10; //Tamaño de Pixel
	$level = 'L'; //Precisión Baja
	$framSize = 3; //Tamaño en blanco
	
        //Enviamos los parámetros a la Función para generar código QR 
	QRcode::png($token, $filename, $level, $tamanio, $framSize); 
        
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="mt-5">Bienvenido, <?php echo htmlspecialchars($_SESSION["username"]); ?></h2>
                <p class="mt-3">Este es tu código:</p>
                <?php echo '<img src="'.$dir.basename($filename).'" /><hr/>'?> 
                <p class="mt-3">El profesor debe escanearlo para registrar tu asistencia.</p>
                <a href="logout.php" class="btn btn-danger">cerrar sesión</a>
            </div>
        </div>
    </div>
</body>
</html>