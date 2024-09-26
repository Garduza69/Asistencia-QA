<?php
// Initialize the session
session_start();
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Docente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="row justify-content-center mt-5">
    <div class="col-sm-4 shadow p-3">
      <h5 class="text-center">Escanear código QR</h5>
      <div class="row text-center">
        <a id="btn-scan-qr" href="#">
          <img src="https://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg" class="img-fluid text-center" width="175">
        <a/>
        <canvas hidden="" id="qr-canvas" class="img-fluid"></canvas>
        </div>
        <div class="row mx-5 my-3">
        <button class="btn btn-success btn-sm rounded-3 mb-2" onclick="encenderCamara()">Encender cámara</button>
        <button class="btn btn-danger btn-sm rounded-3" onclick="cerrarCamara()">Detener cámara</button>
      </div>
    </div>
  </div>
  <audio id="audioScaner" src="assets/sonido.mp3"></audio>
  <script>
    let scanner;

    function encenderCamara() {
        // Solicitar permisos para acceder a la cámara
        navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
            document.getElementById('qr-canvas').style.display = 'block';
            scanner = new Instascan.Scanner({ video: document.getElementById('qr-canvas') });
            scanner.addListener('scan', function(content) {
                window.location.href = 'registrar_asistencia.php?token=' + content;
            });
            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No se encontraron cámaras disponibles.');
                }
            }).catch(function(e) {
                console.error(e);
            });
        })
        .catch(function(err) {
            console.error('Error al acceder a la cámara:', err);
        });
    }

    function cerrarCamara() {
        scanner.stop();
        document.getElementById('qr-canvas').style.display = 'none';
    }
  </script>
</body>
</html>
