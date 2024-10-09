<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Alumnos y Horarios</title>
  <link rel="stylesheet" href="bdd.css">
  <style>
    #searchEmail {
      margin-bottom: 10px;
      padding: 5px;
      width: 300px;
    }
  </style>
  <script>
    function filterEmails() {
      var input, filter, select, options, i;
      input = document.getElementById("searchEmail");
      filter = input.value.toUpperCase();
      select = document.getElementById("id_usuario");
      options = select.getElementsByTagName("option");

      for (i = 0; i < options.length; i++) {
        if (options[i].text.toUpperCase().indexOf(filter) > -1) {
          options[i].style.display = "";
        } else {
          options[i].style.display = "none";
        }
      }
    }
  </script>
</head>
<body>
  <h2>Agregar Nuevo Alumno</h2>

  <form action="bdd.php" method="POST">
    <!-- Formulario de Alumno -->
    <h3>Datos del Alumno</h3>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br>

    <label for="primer_apellido">Primer Apellido:</label>
    <input type="text" id="primer_apellido" name="primer_apellido" required><br>

    <label for="segundo_apellido">Segundo Apellido:</label>
    <input type="text" id="segundo_apellido" name="segundo_apellido" required><br>

    <label for="matricula">Matrícula:</label>
    <input type="text" id="matricula" name="matricula" required><br>

    <label for="curp">CURP:</label>
    <input type="text" id="curp" name="curp" required><br>

    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br>

    <label for="sexo">Sexo:</label>
    <select id="sexo" name="sexo" required>
      <option value="M">Masculino</option>
      <option value="F">Femenino</option>
    </select><br>

    <!-- Sección de selección de ID Usuario con búsqueda -->
    <label for="id_usuario">Buscar por Email:</label>
    <input type="text" id="searchEmail" onkeyup="filterEmails()" placeholder="Buscar email...">
    
    <label for="id_usuario">ID de Usuario (Email):</label>
    <select id="id_usuario" name="id_usuario" required>
      <option value="">Seleccione un Usuario</option>
      <?php
      include 'conexion2.php';

      // Verificar conexión
      if ($db->connect_error) {
          die("Error en la conexión: " . $db->connect_error);
      }

      // Consulta para obtener todos los usuarios
      $sql = "SELECT idUsuario, email FROM usuario";
      $result = $db->query($sql);

      // Verificar si hay resultados y crear las opciones del select
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '<option value="' . $row['idUsuario'] . '">' . $row['email'] . '</option>';
          }
      } else {
          echo '<option value="">No hay usuarios disponibles</option>';
      }

      // Cerrar la conexión
      $db->close();
      ?>
    </select><br>

    <input type="submit" value="Agregar alumno">
  </form>
</body>
</html>
