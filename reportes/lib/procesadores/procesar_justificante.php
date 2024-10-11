<?php
// Verificar si se recibieron los datos del formulario
if (isset($_POST['matricula']) && isset($_POST['dia_seleccionado']) && isset($_POST['mes']) && isset($_POST['motivo_seleccionado']) && isset($_POST['dia'])) {
    // Si los datos están presentes, asignarlos a variables
    $matricula_seleccionada = $_POST['matricula'];
    $dia_seleccionado = $_POST['dia_seleccionado'];
    $mes_seleccionado = $_POST['mes'];
	$motivo_seleccionado = $_POST['motivo_seleccionado'];
	$fecha_seleccionada = $_POST['dia'];
    // Imprimir los datos para depuración
    echo "Matrícula: $matricula_seleccionada<br>";
    echo "Día seleccionado: $dia_seleccionado<br>";
    echo "Mes seleccionado: $mes_seleccionado<br>";
	echo "Motivo seleccionado: $motivo_seleccionado<br>";
	echo "Fecha seleccionado: $fecha_seleccionada<br>";
	
    // Redirigir a otro archivo con los datos como parámetros GET
    header("Location: generador/reporteJustificante.php?matricula=$matricula_seleccionada&dia_seleccionado=$dia_seleccionado&mes=$mes_seleccionado&motivo_seleccionado=$motivo_seleccionado&dia=$fecha_seleccionada");
    exit; // Asegúrate de salir del script después de la redirección

} else {
    // Si falta algún dato, mostrar un mensaje de error
    echo "No se recibieron todos los datos del formulario.";
}
?>