<?php
// Verificar si se recibieron los datos del formulario
if (isset($_POST['facultad']) && isset($_POST['grupo']) && isset($_POST['mes'])) {
    $facultad_seleccionada = $_POST['facultad'];
    $grupo_seleccionada = $_POST['grupo'];
    $mes_seleccionado = $_POST['mes'];
    $opcion = 2;
    // Redirigir a MenuMaterias.php con los datos como parámetros GET
    header("Location: pruebaReporte.php?facultad=$facultad_seleccionada&grupo=$grupo_seleccionada&mes=$mes_seleccionado&opcion=$opcion");
    exit; // Asegúrate de salir del script después de la redirección
} else {
    echo "No se recibieron todos los datos del formulario.";
}
?>