<?php

if (isset($_POST['facultad']) && isset($_POST['grupo'])) {
    $facultad_seleccionada = $_POST['facultad'];
    $grupo_seleccionada = $_POST['grupo'];


    header("Location: generador/reporteCalificacionesFacultades.php?facultad=$facultad_seleccionada&grupo=$grupo_seleccionada");
    exit; 
} else {
    echo "No se recibieron todos los datos del formulario.";
}
?>