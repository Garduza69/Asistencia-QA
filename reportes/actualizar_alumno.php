<?php
    // Realiza la consulta de actualización
    $consultaActualizacion = $db->query("UPDATE asistencia
        SET asistencia = 2
        WHERE 
            MONTH(fecha_alta) = 4
            AND DAY(fecha_alta) = 25
            AND alumno_id IN (
                SELECT asis.alumno_id
                FROM asistencia asis
                JOIN alumnos al ON asis.alumno_id = al.alumno_id
                WHERE 
                    MONTH(asis.fecha_alta) = 4
                    AND DAY(asis.fecha_alta) = 25
                    AND al.matricula = '12130586'
                GROUP BY 
                    asis.alumno_id, asis.fecha_alta
            )");

    // Verificar si la consulta se ejecutó correctamente
    if ($consultaActualizacion) {
        echo "La actualización se realizó correctamente.";
    } else {
        echo "Error al realizar la actualización.";
    }
} else {
    // Si la solicitud de generación de lista no está presente, muestra un mensaje de error
    echo "No se recibió la solicitud para generar la lista.";
}
?>