<?php
session_start();
// Incluir el archivo de conexión a la base de datos
require('conexion2.php');

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
//Recupera el email del usuario
$email_usuario = $_SESSION['email'];

// Consultar el idUsuario asociado al correo del usuario actual
$sql_usuario = "SELECT idUsuario FROM usuario WHERE Email = ?";
$stmt_usuario = $db->prepare($sql_usuario);
$stmt_usuario->bind_param("s", $email_usuario);
$stmt_usuario->execute();
$stmt_usuario->store_result();
if ($stmt_usuario->num_rows > 0) {
    $stmt_usuario->bind_result($id_usuario);
    $stmt_usuario->fetch();

    // Consultar el profesor_id asociado al idUsuario en la tabla profesores
    $sql_profesor = "SELECT profesor_id FROM profesores WHERE id_usuario = ?";
    $stmt_profesor = $db->prepare($sql_profesor);
    $stmt_profesor->bind_param("i", $id_usuario);
    $stmt_profesor->execute();
    $stmt_profesor->store_result();
    if ($stmt_profesor->num_rows > 0) {
        $stmt_profesor->bind_result($profesor_id);
        $stmt_profesor->fetch();

        // Consultar las materias que imparte el profesor en la tabla horarios
        $options = '';
        $sql_materias = "SELECT m.nombre AS nombre FROM horarios h 
                        JOIN materias m ON m.materia_id = h.materia_id
                        WHERE h.profesor_id = ? GROUP BY nombre";
        $stmt_materias = $db->prepare($sql_materias);
        $stmt_materias->bind_param("i", $profesor_id);
        $stmt_materias->execute();
        $result_materias = $stmt_materias->get_result();
        
        while ($row = $result_materias->fetch_assoc()) {
            $options .= '<option value="' . $row['nombre'] . '">' . $row['nombre'] . '</option>';
        }
    }
}

// Query para obtener las materias desde la base de datos
//$mat = "select nombre from materias;";
//$materias = $db->query($mat);

// Query para obtener nombres de facultades desde la base de datos
$fac = "SELECT nombre FROM facultades";
$facultad = $db->query($fac);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Selección</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Formulario de Selección</h1>
        <form action="procesar_datos.php" method="post">
            <label for="facultad">Facultad:</label>
            <select name="facultad" id="facultad">
                <?php
                // Verificar si se obtuvieron resultados de la consulta
                if ($facultad->num_rows > 0) {
                    // Iterar sobre los resultados y generar las opciones del combo box
                    while ($row = $facultad->fetch_assoc()) {
                        echo '<option value="' . $row["nombre"] . '">' . $row["nombre"] . '</option>';
                    }
                } else {
                    echo '<option value="">No hay materias disponibles</option>';
                }

                // Cerrar la consulta
                $facultad->close();
                ?>
            </select>

            <label for="materia">Materia:</label>
            <select name="materia" id="materia">
                <?php
                // Verificar si se obtuvieron resultados de la consulta
                if ($result_materias->num_rows > 0) {
                    // Iterar sobre los resultados y generar las opciones del combo box
                    while ($row = $result_materias->fetch_assoc()) {
                        $options .= '<option value="' . $row['nombre'] . '">' . $row['nombre'] . '</option>';
                    }
                    echo $options;
                } else {
                    echo '<option value="">No hay materias disponibles</option>';
                }
                
                // Cerrar la consulta
                $result_materias->close();
                ?>
            </select>

            <label for="mes">Mes:</label>
            <select name="mes" id="mes">
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>

            <button type="submit">Generar Lista</button>
        </form>
    </div>
</body>
</html>
