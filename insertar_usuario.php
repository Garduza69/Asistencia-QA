<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Usuario</title>
    <link rel="stylesheet" href="bdd.css"> <!-- Mismo CSS que en el formulario del alumno -->
</head>
<body>
    <h2>Agregar Nuevo Usuario</h2>

    <?php
    include 'conexion2.php';

    // Verificar la conexión
    if ($db->connect_error) {
        die("Error de conexión: " . $db->connect_error);
    }

    // Si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recoger los datos del formulario
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $id_perfil = $_POST['id_perfil'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

        // Consulta para insertar los datos en la tabla usuario
        $sql = "INSERT INTO usuario (nombre, apellidos, id_perfil, email, password, fecha_ult_login, fec_alta, fec_modif)
                VALUES ('$nombre', '$apellidos', '$id_perfil', '$email', '$password', NULL, NOW(), NOW())";

        // Ejecutar la consulta
        if ($db->query($sql) === TRUE) {
            header("Location: success_usuario.php"); // Redirigir a la página de éxito
            exit();
        } else {
            echo "Error: " . $db->error;
        }
    }

    // Cerrar la conexión
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <!-- Formulario de Usuario -->
        <h3>Datos del Usuario</h3>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required><br>

        <label for="id_perfil">Perfil:</label>
        <select id="id_perfil" name="id_perfil" required>
            <?php
            // Obtener los perfiles disponibles desde la tabla perfil
            $sql = "SELECT id_perfil, nombre_perfil FROM perfil";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id_perfil'] . "'>" . $row['nombre_perfil'] . "</option>";
                }
            } else {
                echo "<option value=''>No hay perfiles disponibles</option>";
            }
            ?>
        </select><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Agregar Usuario">
    </form>
</body>
</html>
