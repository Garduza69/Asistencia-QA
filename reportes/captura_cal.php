<?php
session_start();
require('../conexion2.php');
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

$email_usuario = $_SESSION['email'];
global $parcialnot;
global $select_fac;
global $parcialSeleccionado;

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

        // Si se envía una solicitud AJAX para actualizar las materias según el grupo
        if (isset($_POST['grupo']) && isset($_POST['ajax'])) {
            $grupoSeleccionado = $_POST['grupo'];

            // Consulta para obtener las materias según el grupo seleccionado
            $sql_materias_grupo = "SELECT m.nombre AS nombre
                                   FROM horarios h
                                   JOIN materias m ON m.materia_id = h.materia_id
                                   JOIN grupos g ON g.grupo_id = h.grupo_id
                                   WHERE h.profesor_id = ? AND g.clave_grupo = ? AND g.vigenciaSem = 1
                                   GROUP BY m.nombre";
            $stmt_materias_grupo = $db->prepare($sql_materias_grupo);
            $stmt_materias_grupo->bind_param("is", $profesor_id, $grupoSeleccionado);
            $stmt_materias_grupo->execute();
            $result_materias_grupo = $stmt_materias_grupo->get_result();

            // Devolver las opciones de materias en formato HTML
            $options_materias = '';
            while ($row = $result_materias_grupo->fetch_assoc()) {
                $options_materias .= '<option value="' . $row['nombre'] . '">' . $row['nombre'] . '</option>';
            }
            echo $options_materias;
            exit; // Terminar aquí para no continuar con el resto de la página
        }

        // Consultar las materias que imparte el profesor en la tabla horarios
        $options_materias = '';
        $options_grupos = '';
        $sql_materias = "SELECT m.nombre AS nombre, g.clave_grupo AS Grupos 
                FROM horarios h 
                JOIN materias m ON m.materia_id = h.materia_id
                JOIN grupos g ON g.grupo_id = h.grupo_id
                WHERE h.profesor_id = ? AND g.vigenciaSem = 1
                GROUP BY m.nombre, g.clave_grupo;";
        $stmt_materias = $db->prepare($sql_materias);
        $stmt_materias->bind_param("i", $profesor_id);
        $stmt_materias->execute();
        $result_materias = $stmt_materias->get_result();
        
        while ($row = $result_materias->fetch_assoc()) {
            $options_grupos .= '<option value="' . $row['Grupos'] . '">' . $row['Grupos'] . '</option>';
            $options_materias .= '<option value="' . $row['nombre'] . '">' . $row['nombre'] . '</option>';
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los valores seleccionados
    $selected_materia = isset($_POST['materia']) ? $_POST['materia'] : '';
    $selected_grupo = isset($_POST['grupos']) ? $_POST['grupos'] : '';

    // Consulta para obtener las calificaciones
    $sql_calificaciones = "SELECT 
                          alu.alumno_id,  -- Añadir alumno_id
                              alu.matricula,
                              CONCAT(alu.primer_apellido, ' ', alu.segundo_apellido, ' ', alu.nombre) AS nombre_completo,
                              g.clave_grupo,
							  ma.nombre AS materia_nombre,
                              ma.materia_id,
							  h.profesor_id AS nombre_docente
                          FROM 
                              matricula mat
                          JOIN 
                              alumnos alu ON mat.alumno_id = alu.alumno_id
                          JOIN 
                              grupos g ON mat.grupo_id = g.grupo_id
                          JOIN 
                              materias ma ON mat.materia_id = ma.materia_id
						  JOIN 
                              horarios h ON h.materia_id = ma.materia_id AND h.grupo_id = g.grupo_id
                          WHERE 
                              ma.nombre = ? AND g.clave_grupo = ?
                          GROUP BY 
                              alu.alumno_id,
                              alu.matricula,
                              nombre_completo,
                              g.clave_grupo,
                              ma.materia_id,
							  ma.nombre,
							  h.profesor_id
                          ORDER BY 
                              nombre_completo;";
                                
    $stmt_calificaciones = $db->prepare($sql_calificaciones);
    $stmt_calificaciones->bind_param("ss", $selected_materia, $selected_grupo);
    $stmt_calificaciones->execute();
    $result_calificaciones = $stmt_calificaciones->get_result();

    // Guardar los resultados en un array
    $calificaciones = [];
    while ($row = $result_calificaciones->fetch_assoc()) {
        $calificaciones[] = $row;
		$alumno_ids[] = $row['alumno_id'];
    }

    $stmt_calificaciones->close();
}
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
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section label {
            display: block;
            margin-bottom: 8px;
        }

        .section select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .grades-table {
            width: auto; /* Ajusta el ancho al contenido */
            margin: 0 auto; /* Centra la tabla */
            border-collapse: collapse;
            margin-top: 30px;
            text-align: center;
        }

        .grades-table th, .grades-table td {
            border: 1px solid #d3d3d3;
            padding: 10px;
            font-size: 14px;
            white-space: nowrap; /* Evita que el contenido se envuelva */
        }

        .grades-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            color: #333;
        }

        .grades-table td {
            background-color: #ffffff;
        }

        .grades-table td:focus, .grades-table td input:focus {
            outline: 2px solid #4a90e2; /* Resalta la celda activa */
            background-color: #e8f0fe; /* Color de fondo al hacer foco */
        }

            /* Ajusta el ancho del campo de entrada de las calificaciones */
        .grades-table td input[type="text"] {
            width: 60px; /* Ajusta el ancho a un tamaño compacto */
            text-align: center; /* Centra el texto en el campo */
        }

        /* Estilo para el botón */
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
            margin-top: 20px; /* Espacio adicional arriba del botón */
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>



    <script>
    // Función para cargar materias basadas en el grupo seleccionado
    function cargarMaterias() {
        var grupoSelect = document.getElementById('grupos');
        var materiaSelect = document.getElementById('materia');
        var grupoSeleccionado = grupoSelect.value;
		
		materiaSelect.disabled = true;
        materiaSelect.innerHTML = '<option value="">Cargando materias...</option>';

        // Crear un objeto XMLHttpRequest
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Definir qué hacer cuando la solicitud sea exitosa
        xhr.onload = function() {
            if (this.status === 200) {
                // Actualizar las opciones del combo de materias con la respuesta del servidor
                materiaSelect.innerHTML = this.responseText;
				materiaSelect.disabled = false;
            } else {
                // Si hay un error, mostrar un mensaje
                materiaSelect.innerHTML = '<option value="">Error al cargar materias</option>';
            }
        };

        // Enviar la solicitud con el grupo seleccionado y un indicador AJAX
        xhr.send("grupo=" + grupoSeleccionado + "&ajax=true");
    }

    document.addEventListener('DOMContentLoaded', function() {
    const inputs = Array.from(document.querySelectorAll('tbody input[type="text"]'));

        // Calcula el número de columnas de forma dinámica basado en la primera fila
        const firstRowInputs = document.querySelectorAll('tbody tr:first-child input[type="text"]');
        const columns = firstRowInputs.length;

        document.addEventListener('keydown', function(e) {
            const focused = document.activeElement;

            // Verifica si el elemento enfocado es un input y si es editable
            if (focused.tagName.toLowerCase() === 'input' && focused.type === 'text') {
                const index = inputs.indexOf(focused);
                let newIndex = index;

                // Obtiene la posición del cursor en el campo actual
                const cursorPos = focused.selectionStart;
                const valueLength = focused.value.length;

                switch (e.key) {
                    case 'ArrowUp':
                        // Solo cambia de celda si no se está editando en una posición específica
                        newIndex = index - columns >= 0 ? index - columns : index;
                        break;
                    case 'ArrowDown':
                        newIndex = index + columns < inputs.length ? index + columns : index;
                        break;
                    case 'ArrowLeft':
                        // Permite moverse entre caracteres si no está al inicio del campo
                        if (cursorPos === 0) {
                            newIndex = index - 1 >= 0 ? index - 1 : index;
                        }
                        break;
                    case 'ArrowRight':
                        // Permite moverse entre caracteres si no está al final del campo
                        if (cursorPos === valueLength) {
                            newIndex = index + 1 < inputs.length ? index + 1 : index;
                        }
                        break;
                    default:
                        return; // Ignora si no es una tecla de flecha
                }

                if (newIndex !== index) {
                    e.preventDefault(); // Evita el movimiento de cursor dentro del campo
                    inputs[newIndex].focus(); // Mueve el foco a la nueva posición de celda
                }
            }
        });
    });
    </script>
</head>

<body>
    <div class="container">
        <h1>Nombre del Docente</h1>
        <form action="" method="post">
            <!-- Sección de Facultad -->
            <div class="section">
                <label for="facultad">Facultad:</label>
                <select name="facultad" id="facultad">
                <?php
                if ($facultad->num_rows > 0) {
                    while ($row = $facultad->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row["nombre"]) . '">' . htmlspecialchars($row["nombre"]) . '</option>';
                    }
                } else {
                    echo '<option value="">No hay facultades disponibles</option>';
                }
                $facultad->close();
                ?>
                </select>
            </div>

            <!-- Sección de Grupo -->
            <div class="section">
                <label for="grupos">Grupo:</label>
                <select name="grupos" id="grupos" onchange="cargarMaterias()">
					<option value="">Seleccione un grupo</option>
                <?php echo $options_grupos; ?>
                </select>
            </div>
            
            <!-- Sección de Materia -->
            <div class="section">
                <label for="materia">Materia:</label>
                <select name="materia" id="materia" disabled required>
					<option value="">Seleccione una materia</option>
                <?php echo $options_materias; ?>
                </select>
            </div>

            <!-- Sección de parciales y ordinarios -->
            <div class="section">
                <label for="parcial">Parciales:</label>
                <select name="parcial" id="parcial">
					<option value="">Seleccione un parcial u ordinario</option>
                    <option value="parcial 1"> Parcial 1</option>
                    <option value="parcial 2"> Parcial 2</option>
                    <option value="parcial 3"> Parcial 3</option>
                    <option value="ordinario 1"> Ordinario</option>
                    <option value="ordinario 2"> Ordinario 2</option>
               
                </select>
            </div>
            
            <button type="submit" name="buscar">Buscar</button>
        </form>

        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar'])) {
    // Obtiene la opción seleccionada
    $parcialSeleccionado = isset($_POST['parcial']) ? $_POST['parcial'] : '';
    $selected_materia = isset($_POST['materia']) ? $_POST['materia'] : '';
    $selected_grupo = isset($_POST['grupos']) ? $_POST['grupos'] : '';
    $select_fac = isset( $_POST['facultad']) ? $_POST['facultad']:'';

    $_SESSION['parcial'] = $_POST['parcial'];
    $_SESSION['materia'] = $_POST['materia'];
    $_SESSION['facultad'] = $_POST['facultad'];

    // Consulta SQL para recuperar las calificaciones de la base de datos
    $sql_calificaciones = "
        SELECT 
            alu.alumno_id,
            alu.matricula,
            CONCAT(alu.primer_apellido, ' ', alu.segundo_apellido, ' ', alu.nombre) AS nombre_completo,
            g.clave_grupo,
            ma.nombre AS materia_nombre,
            ma.materia_id,
            h.profesor_id AS nombre_docente,
            cal.parcial_1,
            cal.parcial_2,
            cal.parcial_3,
            cal.ordinario_1,
            cal.ordinario_2
        FROM 
            matricula mat
        JOIN 
            alumnos alu ON mat.alumno_id = alu.alumno_id
        JOIN 
            grupos g ON mat.grupo_id = g.grupo_id
        JOIN 
            materias ma ON mat.materia_id = ma.materia_id
        JOIN 
            horarios h ON h.materia_id = ma.materia_id AND h.grupo_id = g.grupo_id
        LEFT JOIN 
            calificaciones cal ON cal.alumno_id = alu.alumno_id AND cal.materia_id = ma.materia_id AND cal.profesor_id = h.profesor_id
        WHERE 
            ma.nombre = ? AND g.clave_grupo = ?
        GROUP BY 
            alu.alumno_id,
            alu.matricula,
            nombre_completo,
            g.clave_grupo,
            ma.materia_id,
            cal.parcial_1,
            cal.parcial_2,
            cal.parcial_3,
            cal.ordinario_1,
            cal.ordinario_2
    ";

    $stmt_calificaciones = $db->prepare($sql_calificaciones);
    $stmt_calificaciones->bind_param("ss", $selected_materia, $selected_grupo);
    $stmt_calificaciones->execute();
    $result_calificaciones = $stmt_calificaciones->get_result();

    $calificaciones = [];
    while ($row = $result_calificaciones->fetch_assoc()) {
        $calificaciones[] = [
            'alumno_id' => $row['alumno_id'],
            'matricula' => $row['matricula'],
            'nombre_completo' => $row['nombre_completo'],
            'materia_nombre' => $row['materia_nombre'],
            'materia_id' => $row['materia_id'],
            'nombre_docente' => $row['nombre_docente'],
            'parcial_1' => $row['parcial_1'],
            'parcial_2' => $row['parcial_2'],
            'parcial_3' => $row['parcial_3'],
            'ordinario_1' => $row['ordinario_1'],
            'ordinario_2' => $row['ordinario_2']
        ];
    }

    $stmt_calificaciones->close();

    if (count($calificaciones) > 0 && !empty($parcialSeleccionado)): ?>
        <form method="post">
            <table class="grades-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Matrícula</th>
                        <th>Alumno</th>
                        <?php
                        // Mostrar el encabezado solo para la columna seleccionada
                        switch ($parcialSeleccionado) {
                            case 'parcial 1':
                                echo "<th>Parcial 1</th>";
                                break;
                            case 'parcial 2':
                                echo "<th>Parcial 2</th>";
                                break;
                            case 'parcial 3':
                                echo "<th>Parcial 3</th>";
                                break;
                            case 'ordinario 1':
                                echo "<th>Ordinario</th>";
                                break;
                            case 'ordinario 2':
                                echo "<th>Ordinario 2</th>";
                                break;
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $valoresCiclo = [];
                    for ($i = 0; $i < count($calificaciones); $i++): 
                        $valoresCiclo[] = [
                            'indice' => $i + 1,
                            'matricula' => $calificaciones[$i]['matricula'],
                            'nombre_completo' => $calificaciones[$i]['nombre_completo'],
                            'materia_nombre' => $calificaciones[$i]['materia_nombre'],
                            'alumno_id' => $calificaciones[$i]['alumno_id'],
                            'materia_id' => $calificaciones[$i]['materia_id'],
                            'nombre_docente' => $calificaciones[$i]['nombre_docente']
                        ];

                        // Recuperar calificación específica del parcial seleccionado desde la base de datos
                        $alumno_id = $calificaciones[$i]['alumno_id'];
                        $calificacionParcial = 0; // Valor por defecto en caso de no encontrar nada

                        // Determina cuál campo usar basado en el parcial seleccionado
                        switch ($parcialSeleccionado) {
                            case 'parcial 1':
                                $calificacionParcial = isset($calificaciones[$i]['parcial_1']) ? $calificaciones[$i]['parcial_1'] : 0;
                                break;
                            case 'parcial 2':
                                $calificacionParcial = isset($calificaciones[$i]['parcial_2']) ? $calificaciones[$i]['parcial_2'] : 0;
                                break;
                            case 'parcial 3':
                                $calificacionParcial = isset($calificaciones[$i]['parcial_3']) ? $calificaciones[$i]['parcial_3'] : 0;
                                break;
                            case 'ordinario 1':
                                $calificacionParcial = isset($calificaciones[$i]['ordinario_1']) ? $calificaciones[$i]['ordinario_1'] : 0;
                                break;
                            case 'ordinario 2':
                                $calificacionParcial = isset($calificaciones[$i]['ordinario_2']) ? $calificaciones[$i]['ordinario_2'] : 0;
                                break;
                        }

                        $disabled = $calificacionParcial > 0 ? "disabled" : ""; // Desactiva si el valor es mayor a 0
                        if($calificacionParcial == 0){
                            $calificacionParcial = null;
                        }
                    ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo htmlspecialchars($calificaciones[$i]['matricula']); ?></td>
                            <td><?php echo htmlspecialchars($calificaciones[$i]['nombre_completo']); ?></td>
                            <?php
                            // Mostrar solo la columna de calificación seleccionada con el valor recuperado
                            switch ($parcialSeleccionado) {
                                case 'parcial 1':
                                    echo "<td><input type='text' name='parcial_1_{$alumno_id}' value='" . htmlspecialchars($calificacionParcial) . "' tabindex='1' $disabled /></td>";
                                    $parcialnot = "parcial 1";
                                    break;
                                case 'parcial 2':
                                    echo "<td><input type='text' name='parcial_2_{$alumno_id}' value='" . htmlspecialchars($calificacionParcial) . "' tabindex='1' $disabled /></td>";
                                    $parcialnot = "parcial 2";
                                    break;
                                case 'parcial 3':
                                    echo "<td><input type='text' name='parcial_3_{$alumno_id}' value='" . htmlspecialchars($calificacionParcial) . "' tabindex='1' $disabled /></td>";
                                    $parcialnot = "parcial 3";
                                    break;
                                case 'ordinario 1':
                                    echo "<td><input type='text' name='ordinario_1_{$alumno_id}' value='" . htmlspecialchars($calificacionParcial) . "' tabindex='1' $disabled /></td>";
                                    $parcialnot = "ordinario 1";
                                    break;
                                case 'ordinario 2':
                                    echo "<td><input type='text' name='ordinario_2_{$alumno_id}' value='" . htmlspecialchars($calificacionParcial) . "' tabindex='1' $disabled /></td>";
                                    $parcialnot = "ordinario 2";
                                    break;
                            }
                            ?>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
            <input type="hidden" name="valores_ciclo" value='<?php echo htmlspecialchars(json_encode($valoresCiclo)); ?>'>
            <button type="submit" name="registrar">Registrar</button>
        </form>
    <?php else: ?>
        <p>No hay datos disponibles para la selección actual.</p>
    <?php endif;
        }

        // Recuperar los valores de la sesión
        $parcialSeleccionado = isset($_SESSION['parcial']) ? $_SESSION['parcial'] : '';
        $selected_materia = isset($_SESSION['materia']) ? $_SESSION['materia'] : '';
        $select_fac = isset($_SESSION['facultad']) ? $_SESSION['facultad'] : '';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar'])) { 
            $valoresCiclo = json_decode($_POST['valores_ciclo'], true);
        
            // Preparar la consulta para inserción
            $sqlInsert = "INSERT INTO calificaciones 
                          (profesor_id, alumno_id, materia_id, parcial_1, parcial_2, parcial_3, ordinario_1, ordinario_2, promedio, usuario_alta, usuario_actualizacion) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
            // Preparar la consulta para actualización
            $sqlUpdate = "UPDATE calificaciones SET 
                          parcial_1 = ?, parcial_2 = ?, parcial_3 = ?, ordinario_1 = ?, ordinario_2 = ?, promedio = ?, usuario_actualizacion = ? 
                          WHERE profesor_id = ? AND alumno_id = ? AND materia_id = ?";
        
            // Consulta para verificar si existe el registro
            $sqlCheck = "SELECT profesor_id FROM calificaciones WHERE profesor_id = ? AND alumno_id = ? AND materia_id = ?";
            $stmtCheck = $db->prepare($sqlCheck);
        
            // Preparar las sentencias para insertar y actualizar
            $stmtInsert = $db->prepare($sqlInsert);
            $stmtUpdate = $db->prepare($sqlUpdate);
        
        foreach ($valoresCiclo as $valor) {
            $profesor_id = $valor['nombre_docente']; // Ajustar según el ID real del profesor
            $alumno_id = $valor['alumno_id'];
            $materia_id = $valor['materia_id'];
            $usuario_alta = 'admin';
            $usuario_actualizacion = 'admin';
        
            // Inicializar variables para los parciales con los valores enviados en el formulario
            $parcial_1 = isset($_POST['parcial_1_' . $alumno_id]) ? floatval($_POST['parcial_1_' . $alumno_id]) : null;
            $parcial_2 = isset($_POST['parcial_2_' . $alumno_id]) ? floatval($_POST['parcial_2_' . $alumno_id]) : null;
            $parcial_3 = isset($_POST['parcial_3_' . $alumno_id]) ? floatval($_POST['parcial_3_' . $alumno_id]) : null;
            $ordinario_1 = isset($_POST['ordinario_1_' . $alumno_id]) ? floatval($_POST['ordinario_1_' . $alumno_id]) : null;
            $ordinario_2 = isset($_POST['ordinario_2_' . $alumno_id]) ? floatval($_POST['ordinario_2_' . $alumno_id]) : null;
        
            // Recuperar los valores existentes antes de realizar la actualización
            $stmtCheck->bind_param("iii", $profesor_id, $alumno_id, $materia_id);
            $stmtCheck->execute();
            $stmtCheck->store_result();
        
                if ($stmtCheck->num_rows > 0) {
                    // Recupera las calificaciones existentes
                    $sqlCheckcal = "SELECT parcial_1, parcial_2, parcial_3, ordinario_1, ordinario_2 FROM calificaciones WHERE profesor_id = ? AND alumno_id = ? AND materia_id = ?";
                    $stmtCheckcal = $db->prepare($sqlCheckcal);
                    $stmtCheckcal->bind_param("iii", $profesor_id, $alumno_id, $materia_id);
                    $stmtCheckcal->execute();
                    $stmtCheckcal->store_result();
                    $stmtCheckcal->bind_result($current_parcial_1, $current_parcial_2, $current_parcial_3, $current_ordinario_1, $current_ordinario_2);
                    $stmtCheckcal->fetch();
        
                    // Mantén las calificaciones actuales si no se han enviado en el formulario
                    $parcial_1 = is_null($parcial_1) ? $current_parcial_1 : $parcial_1;
                    $parcial_2 = is_null($parcial_2) ? $current_parcial_2 : $parcial_2;
                    $parcial_3 = is_null($parcial_3) ? $current_parcial_3 : $parcial_3;
                    $ordinario_1 = is_null($ordinario_1) ? $current_ordinario_1 : $ordinario_1;
                    $ordinario_2 = is_null($ordinario_2) ? $current_ordinario_2 : $ordinario_2;
        
                    // Calcular el promedio actualizado
                    $promedio = ($parcial_1 + $parcial_2 + $parcial_3) / 3;
        
                    // Actualizar el registro existente
                    $stmtUpdate->bind_param("ddddddsiis", 
                        $parcial_1, $parcial_2, $parcial_3, $ordinario_1, $ordinario_2, $promedio, 
                        $usuario_actualizacion, $profesor_id, $alumno_id, $materia_id
                    );
                    if ($stmtUpdate->execute()) {
                        echo "Registro actualizado correctamente.<br>";
                        ?>
                        <form id="redirectForm" action="../send_email.php" method="get">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email_usuario); ?>">
                        <input type="hidden" name="parcial" value="<?php echo htmlspecialchars($parcialSeleccionado); ?>">
                        <input type="hidden" name="materia" value="<?php echo htmlspecialchars($selected_materia); ?>">
                        <input type="hidden" name="facultad" value="<?php echo htmlspecialchars($select_fac); ?>">
                        </form>
                        <script>
                        document.getElementById('redirectForm').submit();
                        </script>
                        <?php
                        unset($_SESSION['parcial']);
                        unset($_SESSION['materia']);
                        unset($_SESSION['facultad']);
                    } else {
                        echo "Error al actualizar el registro: " . $stmtUpdate->error . "<br>";
                    }
                } else {
                    // Si el registro no existe, insertar con los valores actuales
                    $parcial_1 = is_null($parcial_1) ? 0 : $parcial_1;
                    $parcial_2 = is_null($parcial_2) ? 0 : $parcial_2;
                    $parcial_3 = is_null($parcial_3) ? 0 : $parcial_3;
                    $ordinario_1 = is_null($ordinario_1) ? 0 : $ordinario_1;
                    $ordinario_2 = is_null($ordinario_2) ? 0 : $ordinario_2;
        
                    $promedio = ($parcial_1 + $parcial_2 + $parcial_3) / 3;
        
                    // Inserción del registro
                    $stmtInsert->bind_param("iiidddddsss", 
                        $profesor_id, $alumno_id, $materia_id, $parcial_1, $parcial_2, $parcial_3, 
                        $ordinario_1, $ordinario_2, $promedio, $usuario_alta, $usuario_actualizacion
                    );
                    if ($stmtInsert->execute()) {
                        echo "Registro actualizado correctamente.<br>";
                        ?>
                        <form id="redirectForm" action="../send_email.php" method="get">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email_usuario); ?>">
                        <input type="hidden" name="parcial" value="<?php echo htmlspecialchars($parcialSeleccionado); ?>">
                        <input type="hidden" name="materia" value="<?php echo htmlspecialchars($selected_materia); ?>">
                        <input type="hidden" name="facultad" value="<?php echo htmlspecialchars($select_fac); ?>">
                        </form>
                        <script>
                        document.getElementById('redirectForm').submit();
                        </script>
                        <?php
                        unset($_SESSION['parcial']);
                        unset($_SESSION['materia']);
                        unset($_SESSION['facultad']);
                    } else {
                        echo "Error al insertar el registro: " . $stmtInsert->error . "<br>";
                    }
                }
        }
        
            // Cerrar las sentencias después de que se hayan usado
            $stmtCheck->close();
            $stmtInsert->close();
            $stmtUpdate->close();
        }
        ?>
    </div>
</body>
</html>