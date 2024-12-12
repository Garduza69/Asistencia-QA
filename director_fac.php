<?php
session_start();

isset($_SESSION['tipo_usuario']);
$tipo_usuario = $_SESSION['tipo_usuario'];

if (!isset($_SESSION['loggedin']) || $tipo_usuario != 4 ) {
    header("Location: index.php");
    exit();
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Universidad de Sotavento</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">
  <link href="img/logoUS.png" rel="icon">
  <link href="img/logoUS.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700|Open+Sans:300,300i,400,400i,700,700i" rel="stylesheet">
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="lib/magnific-popup/magnific-popup.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <style>
#logo h1 a {
  display: inline-block;
  width: 150px;
  height: 70px;
  background-image: url('img/sotavento.png');
  background-size: contain;
  background-repeat: no-repeat;
  text-indent: -9999px;
}
  </style>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('check_session.php', { cache: 'no-store' })
                .then(response => response.json())
                .then(data => {
                    if (!data.authenticated) {
                        window.location.href = 'index.php';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
        if (window.history && window.history.pushState) {
            window.history.pushState(null, null, window.location.href);
            window.onpopstate = function() {
                window.history.pushState(null, null, window.location.href);
            };
        }
    </script>
</head>
<body>
  <header id="header">
    <div class="container">
        <div id="logo" class="pull-left">
          <h1><a href="#intro" class="scrollto">Universidad de Sotavento</a></h1>
        </div>
      <nav id="nav-menu-container">
        <ul class="nav-menu">
		<li class="menu-has-children"><a href="interfaz_principal.php">Nuevo semestre</a></li>
          <li class="menu-has-children"><a href="">Justificantes</a>
            <ul>
                <li><a href="reportes/Materias.php">Consultar Asistencia</a></li>
                <li><a href="reportes/Justificantes.php">Generar Justificante</a></li>
            </ul>
          </li>
          <li class="menu-has-children"><a href="">Consultas</a>
            <ul>
              <li class="menu-has-children"><a>Consultar Listas</a>
                <ul>
                  <li><a href="reportes/MateriasAdmin.php">Listas por Materia</a></li>
                  <li><a href="reportes/Facultades.php">Listas por Facultad</a></li>
                </ul>
              </li>
				<li class="menu-has-children"><a>Consultar Calificaciones</a>
                <ul>
                  <li><a href="reportes/calificaciones_facultades.php">Calificación por Facultad</a></li>
                </ul>					
            </ul>
          </li>
		<li class="menu-active"><a href="cerrar_sesion.php">Cerrar sesión</a></li>	
        </ul>
      </nav>
    </div>
  </header>
  <section id="intro">
    <div class="intro-text">
      <h2 id="welcome-message"></h2>
    </div>
    <div class="product-screens">
      <div class="product-screen-1 wow fadeInUp" data-wow-delay="0.4s" data-wow-duration="0.6s">
        <img src="img/noticia1.png" alt="">
      </div>
      <div class="product-screen-2 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.6s">
        <img src="img/noticia2.png" alt="">
      </div>
      <div class="product-screen-3 wow fadeInUp" data-wow-duration="0.6s">
        <img src="img/noticia3.png" alt="">
      </div>
    </div>
  </section>
  <main id="main">
    <section id="about" class="section-bg">
      <div class="container-fluid">
        <div class="section-header">
          <h3 class="section-title">Dra Rosa Rodríguez Caamaño como nueva Rectora</h3>
          <span class="section-divider"></span>
          <p class="section-description">
            Coatzacoalcos, Ver. – El rector de la Universidad de Sotavento, Juan Manuel Rodríguez García, anunció hoy como su sucesora a la Dra. Rosa Aurora Rodríguez Caamaño, <br>al iniciar la celebración del 30 aniversario de fundación de la institución.
            </p>
        </div>

        <div class="row">
          <div class="col-lg-6 about-img wow fadeInLeft">
            <img src="img/rector.jpg" alt="">
          </div>

          <div class="col-lg-6 content wow fadeInRight">
            <h2>Inicia celebración de los 30 años de fundación de la US, con placa conmemorativa, cápsula del tiempo, medallas a fundadores, exposición pictórica y conferencia magistral</h2>
            <h3></h3>
            <p>
              Rodríguez García expresó que la directora de Posgrados e Investigación, Rodríguez Caamaño, asumirá oficialmente este cargo en los próximos días. La nueva Rectora tiene 25 años colaborando en la dirección de la US, y es Licenciada en Contaduría por el Tecnológico de Monterrey, Máster en Administración de Empresas por la UNAM y Doctora en Administración y Gestión Empresarial por la Universidad Istmo Americana.
            </p>

          </div>
        </div>

      </div>
    </section>
  </main>
  <footer id="footer">

  </footer>
  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>
  <script>
    window.onload = function() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("welcome-message").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ob_nombre.php", true);
        xhttp.send();
    };
</script>
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

</body>
</html>