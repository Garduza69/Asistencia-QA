<?php
if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "u712195824_sistema2";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Consulta para obtener los datos del usuario por email
    $sql = "SELECT nombre, apellidos FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        // Devolver los datos en formato JSON
        echo json_encode($usuario);
    } else {
        // Si no se encuentra, devolver un JSON vacío
        echo json_encode(null);
    }

    $stmt->close();
    $conn->close();
}
?>
