<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    exit();
}

// Evitar almacenamiento en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Sotavento - Docente</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/logoUS.png" rel="icon">
  <link href="img/logoUS.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700|Open+Sans:300,300i,400,400i,700,700i" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="lib/magnific-popup/magnific-popup.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style2.css" rel="stylesheet">

  <!-- Custom Stylesheet for Logo -->
  <style>
#logo h1 a {
  display: inline-block;
  width: 150px; /* Nueva anchura */
  height: 70px; /* Nueva altura */
  background-image: url('img/sotavento.png');
  background-size: contain; /* O ajusta según tu preferencia */
  background-repeat: no-repeat;
  text-indent: -9999px;
}
  </style>

  <!-- =======================================================
    Theme Name: Avilon
    Theme URL: https://bootstrapmade.com/avilon-bootstrap-landing-page-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->

  <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('check_session.php', { cache: 'no-store' })
                .then(response => response.json())
                .then(data => {
                    if (!data.authenticated) {
                        // Redirigir a la página de inicio de sesión si no está autenticado
                        window.location.href = 'index.php';
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Evitar que el navegador almacene en caché
        if (window.history && window.history.pushState) {
            window.history.pushState(null, null, window.location.href);
            window.onpopstate = function() {
                window.history.pushState(null, null, window.location.href);
            };
        }
    </script>
    
</head>

<body>

  <!--==========================
    Header
  ============================-->
  <header id="header">
    <div class="container">
        <div id="logo" class="pull-left">
          <h1><a href="#intro" class="scrollto">Universidad de Sotavento</a></h1>
        </div>
      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="cerrar_sesion.php">Cerrar sesión</a></li>
          <li class="menu-has-children"><a href="">acciones</a>
            <ul>
                <li class="menu-active"><a href="#" onclick="registrarAsistencia()">Registrar Asistencia</a></li>
                <li class="menu-active"><a href="#" onclick="generarReporte()">Generar Reporte</a></li>
                <li class="menu-active"><a href="#" onclick="notificaciones()">Notificaciones</a></li>
            </ul>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <!--==========================
    Intro Section
  ============================-->
  <section id="intro">
    <br>
    <br>
    <div class="intro-text">
        <h2 id="welcome-message"><a class="scrollto"></a></h2>
      <p>Menú</p>
      <a href="#" onclick="registrarAsistencia()" class="btn-get-started scrollto">Registrar Asistencia</a>
      <a href="#" onclick="generarReporte()" class="btn-get-started scrollto">Generar Reporte</a>
      <a href="#" onclick="notificaciones()" class="btn-get-started scrollto">Notificaciones</a>
    </div>



  </section><!-- #intro -->



  <!--==========================
    Footer
  ============================-->


  <!-- JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/jquery/jquery-migrate.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/superfish/hoverIntent.js"></script>
  <script src="lib/superfish/superfish.min.js"></script>
  <script src="lib/magnific-popup/magnific-popup.min.js"></script>

  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>
  <script>
    window.onload = function() {
        // Hacer una solicitud AJAX a docente.php para obtener el mensaje de bienvenida
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("welcome-message").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ob_nombre.php", true);
        xhttp.send();
    };

    function registrarAsistencia() {
        // Redireccionar al docente a lector.html
        window.location.href = "lector.html";
    }

   function generarReporte() {
// Aquí puedes agregar la lógica para generar el reporte
window.location.href = "reportes/Materias.php";
}


    function notificaciones() {
        // Aquí puedes agregar la lógica para generar el reporte
        alert("Funcionalidad de notificaciones en desarrollo.");
    }
</script>

</body>
</html>