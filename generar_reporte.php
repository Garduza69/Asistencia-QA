<?php
// Incluir la biblioteca TCPDF
require_once('Tcpdf.php');

// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "u712195824_sotavento";
$password = "Cruzazul443";
$dbname = "u712195824_Sotaproyecto";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Función para generar el reporte general
function generarReporteGeneral($conn) {
    // Consulta SQL para obtener todos los registros
    $sql = "SELECT * FROM registros";
    $result = $conn->query($sql);

    // Crear el objeto TCPDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Agregar una página
    $pdf->AddPage();

    // Definir el contenido del PDF
    $content = '<h1>Reporte General de Asistencia</h1>';
    $content .= '<table border="1">';
    $content .= '<tr><th>Nombre</th><th>Apellido Paterno</th><th>Apellido Materno</th><th>Matrícula</th></tr>';

    if ($result->num_rows > 0) {
        // Mostrar los datos en el PDF
        while ($row = $result->fetch_assoc()) {
            $content .= '<tr><td>'.$row['nombre'].'</td><td>'.$row['apellido_paterno'].'</td><td>'.$row['apellido_materno'].'</td><td>'.$row['matricula'].'</td></tr>';
        }
    }

    $content .= '</table>';

    // Escribir el contenido en el PDF
    $pdf->writeHTML($content, true, false, true, false, '');

    // Salida del PDF
    $pdf->Output('reporte_general.pdf', 'D');
}

// Función para generar el reporte de un alumno específico
function generarReporteAlumno($conn, $matricula) {
    // Consulta SQL para obtener los datos del alumno con la matrícula proporcionada
    $sql = "SELECT * FROM registros WHERE matricula = '$matricula'";
    $result = $conn->query($sql);

    // Crear el objeto TCPDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Agregar una página
    $pdf->AddPage();

    // Definir el contenido del PDF
    $content = '<h1>Reporte de Asistencia del Alumno con Matrícula '.$matricula.'</h1>';
    $content .= '<table border="1">';
    $content .= '<tr><th>Nombre</th><th>Apellido Paterno</th><th>Apellido Materno</th><th>Matrícula</th></tr>';

    if ($result->num_rows > 0) {
        // Mostrar los datos en el PDF
        while ($row = $result->fetch_assoc()) {
            $content .= '<tr><td>'.$row['nombre'].'</td><td>'.$row['apellido_paterno'].'</td><td>'.$row['apellido_materno'].'</td><td>'.$row['matricula'].'</td></tr>';
        }
    }

    $content .= '</table>';

    // Escribir el contenido en el PDF
    $pdf->writeHTML($content, true, false, true, false, '');

    // Salida del PDF
    $pdf->Output('reporte_alumno_'.$matricula.'.pdf', 'D');
}

// Verificar qué botón se ha presionado
if (isset($_POST['reporte_general'])) {
    generarReporteGeneral($conn);
} elseif (isset($_POST['reporte_alumno'])) {
    $matricula = $_POST['matricula'];
    generarReporteAlumno($conn, $matricula);
}

// Cerrar la conexión
$conn->close();
?>
