<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'u712195824_sistema2');
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $grupo_id = $_POST['grupo_id'];
    $materia_id = $_POST['materia_id'];
    $profesor_id = $_POST['profesor_id'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    // Insertar en la tabla horarios
    $sql = "INSERT INTO horarios (grupo_id, materia_id, profesor_id, hora_inicio, hora_fin)
            VALUES ('$grupo_id', '$materia_id', '$profesor_id', '$hora_inicio', '$hora_fin')";

    if ($conexion->query($sql) === TRUE) {
        echo "Horario creado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}

// Obtener los grupos (clave_grupo), materias (nombre), y profesores (nombre completo)
$grupos = $conexion->query("SELECT grupo_id, clave_grupo FROM grupos");
$materias = $conexion->query("SELECT materia_id, nombre FROM materias");
$profesores = $conexion->query("SELECT profesor_id, CONCAT(nombre, ' ', primer_apellido, ' ', segundo_apellido) AS nombre_completo FROM profesores");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Horario</title>
    <link rel="stylesheet" href="bdd.css">
    <style>
        /* Estilos para los buscadores */
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
    </style>
    <script>
        // Función para filtrar opciones en un select
        function filtrarOpciones(inputId, selectId) {
            var input, filter, select, options, i;
            input = document.getElementById(inputId);
            filter = input.value.toUpperCase();
            select = document.getElementById(selectId);
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

    <h2>Nuevo Horario</h2>

    <form action="crear_horario.php" method="POST">
        <!-- Buscador y selección de grupo -->
        <label for="grupo_id">Seleccionar Grupo:</label>
        <input type="text" id="buscarGrupo" onkeyup="filtrarOpciones('buscarGrupo', 'grupo_id')" placeholder="Buscar grupo...">
        <select id="grupo_id" name="grupo_id" required>
            <option value="">Selecciona un grupo</option>
            <?php while ($grupo = $grupos->fetch_assoc()): ?>
                <option value="<?php echo $grupo['grupo_id']; ?>">
                    <?php echo $grupo['clave_grupo']; ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <!-- Buscador y selección de materia -->
        <label for="materia_id">Seleccionar Materia:</label>
        <input type="text" id="buscarMateria" onkeyup="filtrarOpciones('buscarMateria', 'materia_id')" placeholder="Buscar materia...">
        <select id="materia_id" name="materia_id" required>
            <option value="">Selecciona una materia</option>
            <?php while ($materia = $materias->fetch_assoc()): ?>
                <option value="<?php echo $materia['materia_id']; ?>">
                    <?php echo $materia['nombre']; ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <!-- Buscador y selección de profesor -->
        <label for="profesor_id">Seleccionar Profesor:</label>
        <input type="text" id="buscarProfesor" onkeyup="filtrarOpciones('buscarProfesor', 'profesor_id')" placeholder="Buscar profesor...">
        <select id="profesor_id" name="profesor_id" required>
            <option value="">Selecciona un profesor</option>
            <?php while ($profesor = $profesores->fetch_assoc()): ?>
                <option value="<?php echo $profesor['profesor_id']; ?>">
                    <?php echo $profesor['nombre_completo']; ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <!-- Selección de horario -->
        <label for="hora_inicio">Hora de Inicio:</label>
        <input type="time" id="hora_inicio" name="hora_inicio" required><br><br>

        <label for="hora_fin">Hora de Fin:</label>
        <input type="time" id="hora_fin" name="hora_fin" required><br><br>

        <input type="submit" value="Crear Horario">
    </form>
</body>
</html>

<?php
// Cerrar la conexión
$conexion->close();
?>
