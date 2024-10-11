<?php
// Verificar si se recibieron los datos del formulario
if (isset($_POST['facultad']) && isset($_POST['materia']) && isset($_POST['mes'])) {
    $facultad_seleccionada = $_POST['facultad'];
    $materia_seleccionada = $_POST['materia'];
    $mes_seleccionado = $_POST['mes'];
    $opcion = 1;
    // Redirigir a MenuMaterias.php con los datos como parámetros GET
    //header("Location: pruebaReporte.php?facultad=$facultad_seleccionada&materia=$materia_seleccionada&mes=$mes_seleccionado&opcion=$opcion");
    header("Location: generador/pruebaReporte.php?facultad=$facultad_seleccionada&grupo=1&mes=$mes_seleccionado&opcion=$opcion&materia=$materia_seleccionada");
    exit; // Asegúrate de salir del script después de la redirección
} else {
    echo "No se recibieron todos los datos del formulario.";
}
?>