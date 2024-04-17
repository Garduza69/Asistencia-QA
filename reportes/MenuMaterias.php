<?php
require('./fpdf.php');
require('conexion.php');
$facultad = $_GET['facultad'];
$materia = $_GET['materia'];
$mes = $_GET['mes'];

$pdf = new FPDF();
$pdf->SetTitle($facultad, true);

$consultaEncabezado = $db->query("SELECT 
    f.nombre AS nombre_facultad,
    ma.nombre AS nombre_materia,
    s.nombre AS nombre_semestre,
    g.clave_grupo AS cve_grupo,
    CONCAT(p.nombre, ' ', p.primer_apellido, ' ', p.segundo_apellido) AS Docente,
    MAX(CASE 
            WHEN MONTH(asis.fecha_alta) = 1 THEN 'Enero'
            WHEN MONTH(asis.fecha_alta) = 2 THEN 'Febrero'
            WHEN MONTH(asis.fecha_alta) = 3 THEN 'Marzo'
            WHEN MONTH(asis.fecha_alta) = 4 THEN 'Abril'
            WHEN MONTH(asis.fecha_alta) = 5 THEN 'Mayo'
            WHEN MONTH(asis.fecha_alta) = 6 THEN 'Junio'
            WHEN MONTH(asis.fecha_alta) = 7 THEN 'Julio'
            WHEN MONTH(asis.fecha_alta) = 8 THEN 'Agosto'
            WHEN MONTH(asis.fecha_alta) = 9 THEN 'Septiembre'
            WHEN MONTH(asis.fecha_alta) = 10 THEN 'Octubre'
            WHEN MONTH(asis.fecha_alta) = 11 THEN 'Noviembre'
            WHEN MONTH(asis.fecha_alta) = 12 THEN 'Diciembre'
        END) AS Mes,
        ma.materia_id
    FROM asistencia asis
    JOIN matricula m ON asis.alumno_id = m.alumno_id
    JOIN profesores p ON m.profesor_id = p.profesor_id
    JOIN materias ma ON m.materia_id = ma.materia_id
    JOIN grupos g ON m.grupo_id = g.grupo_id
    JOIN facultades f ON g.facultad_id = f.facultad_id
    JOIN semestres s ON g.semestre_id = s.semestre_id
    WHERE MONTH(asis.fecha_alta) = ".$mes."
        AND f.nombre = '".$facultad."'
        AND ma.nombre = '".$materia."'
    GROUP BY 
        f.nombre,
        CONCAT(p.nombre, ' ', p.primer_apellido, ' ', p.segundo_apellido),
        ma.nombre,
        s.nombre,
        g.clave_grupo,
        ma.materia_id");

if($consultaEncabezado->num_rows > 0) {
    while ($fila = $consultaEncabezado->fetch_assoc()) {
        $pdf->AddPage("landscape");
        $pdf->AliasNbPages();
        $pdf->Image('UNAM.jpg', 15, 5, 20);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(95);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(80, 2, utf8_decode('UNIVERSIDAD DE SOTAVENTO, A.C.'), 0, 1, 'C', 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Ln(5);
        $pdf->Cell(275, 4, utf8_decode('INCORPORADA A LA SECRETARIA DE EDUCACION PUBLICA'), 0, 1, 'C', 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Ln(5);
        $pdf->Cell(265, 1, utf8_decode('Campus Coatzacoalcos'), 0, 1, 'C', 0);
        $pdf->Ln(5);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(163, 163, 163);
        $pdf->SetFont('Arial', '', 9);

        $pdf->Cell(100, 10, utf8_decode('CARRERAS: '. $facultad), 1, 0, 'L', 1);
        $pdf->Cell(40, 10, utf8_decode('CLAVE: 20181190/1'), 1, 0, 'L', 1);
        $pdf->Cell(65, 10, utf8_decode('PERIODO:'), 1, 0, 'L', 1);
        $pdf->Cell(70, 10, utf8_decode('/ '. $fila['Docente']), 1, 1, 'C', 1);

        $pdf->Cell(100, 10, utf8_decode('MATERIA: '. $materia), 1, 0, 'L', 0);
        $pdf->Cell(40, 10, utf8_decode($fila['nombre_semestre']), 1, 0, 'L', 0);
        $pdf->Cell(65, 10, utf8_decode('GRUPO: '. $fila['cve_grupo']), 1, 0, 'L', 0);
		// Guarda la posición actual
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        // Imprime la celda existente
        $pdf->Cell(30, 10, utf8_decode($fila['Mes']), 1, 0, 'C', 0);
		
        // Establece la posición para la nueva celda (a la derecha)
        $pdf->SetXY($x + 30, $y);

        // Imprime la nueva celda
        $pdf->Cell(40, 10, utf8_decode('Firma: '), 1, 1, 'L', 0); 

        $pdf->Ln(5);

        $pdf->Cell(100, 1, utf8_decode('Calificacion Minima Aprobatoria para Ordinario:   6'), 0, 1, 'C', 0);
        $pdf->Ln(5);

        $pdf->Cell(90, 12, utf8_decode('Matricula                         A l u m n o '), 1, 0, 'L', 0);
        $pdf->Cell(155, 12, utf8_decode(' '), 1, 0, 'C', 0);


        $pdf->Cell(18, 12, utf8_decode('Total Faltas'), 1, 0, 'C', 0);
        $pdf->Cell(20, 12, utf8_decode('Calificacion'), 1, 0, 'C', 0);
        $pdf->Ln(5);
        $pdf->Ln(5);
        $pdf->Ln(2);

        $materiaEncabezado = $fila['materia_id'];
        $consultaAlumnos = $db->query("select alu.matricula,
                            CONCAT(alu.primer_apellido, ' ', alu.segundo_apellido, ' ', alu.nombre) AS nombre_completo,
                            alu.alumno_id
                    from asistencia asi
                    join alumnos alu on asi.alumno_id = alu.alumno_id
                    where month(asi.fecha_alta) = ".$mes."
                        and asi.materia_id = ".$materiaEncabezado."
                    group by alu.matricula,
                            CONCAT(alu.primer_apellido, ' ', alu.segundo_apellido, ' ', alu.nombre),
                            alu.alumno_id
                    order by 2");

        while ($alu = $consultaAlumnos->fetch_assoc()) {
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(90, 5, $alu['matricula'] . "            " . $alu['nombre_completo'], 1, 0, 'L');

            for ($dia = 1; $dia <= 31; $dia++) {
                $consultaAsistencia = $db->query("
                        select asis.alumno_id,
                                asis.fecha_alta,
                                max(case when asis.asistencia = 1 then '*'
                                        when asis.asistencia = 2 then '*'
                                    else '/' end) as reporteAsis
                        from asistencia asis
                        where month(asis.fecha_alta) = ".$mes."
                            and materia_id = ".$materiaEncabezado."
                            and asis.alumno_id = ".$alu['alumno_id']."
                            and day(asis.fecha_alta) = ".$dia."
                            and month(asis.fecha_alta)
                        group by asis.alumno_id, asis.fecha_alta
                        order by 2
                ");

                if($consultaAsistencia->num_rows > 0){
                    while ($registros = $consultaAsistencia->fetch_assoc()){
                        $asistencias = $registros['reporteAsis'];
                    }
                } else {
                    $asistencias = " ";
                }

                $pdf->Cell(5, 5, utf8_decode($asistencias), 1, 0, 'C', false);
            }

            $pdf->Cell(18, 5, utf8_decode(' '), 1, 0, 'C', false);
            $pdf->Cell(20, 5, utf8_decode(' '), 1, 0, 'C', false);

            $pdf->Ln();
        }
		// Posición inicial del bloque de celdas
		// Posición inicial del bloque de celdas
        $x_inicio = 100; // Establece la posición en el eje x
        $y_inicio = 70; // Establece la posición en el eje y
        $x = 153;
        $y = 67.5;

        // Dibuja el texto en la posición especificada
        $pdf->Text($x, $y, utf8_decode('DIAS DE CLASES EN EL MES'));

        // Establecer la posición inicial del bloque
        $pdf->SetXY($x_inicio, $y_inicio);

        // Obtener el número de días en el mes seleccionado
        $numero_dias_mes = date('t', mktime(0, 0, 0, $mes, 1));

        // Tamaño de las celdas
        $ancho_celda = 5;
        $alto_celda = 5;

        // Determinar en qué día de la semana comienza el mes (1: Lunes, 7: Domingo)
        $primer_dia_semana = date('N', strtotime(date('Y-m-01', mktime(0, 0, 0, $mes, 1))));

        // Crear una matriz de nombres de día de semana ajustada al inicio del mes
        $nombres_dias_semana = array('L', 'M', 'M', 'J', 'V', 'S', 'D');
                for ($i = 0; $i < $primer_dia_semana - 1; $i++) {
                    array_push($nombres_dias_semana, array_shift($nombres_dias_semana));
                }


        // Establecer la posición inicial del bloque
        $pdf->SetXY($x_inicio, $y_inicio);

        // Iterar sobre los días del mes
        $pdf->SetFont('Arial', '', 6); // Establecer la fuente antes de imprimir los días
                for ($dia = 1; $dia <= $numero_dias_mes; $dia++) {
            // Obtener el nombre del día de la semana abreviado
            $nombre_dia_semana = $nombres_dias_semana[date('N', strtotime(date('Y-m-' . $dia))) - 1];

            // Combinar el nombre del día de la semana con el día del mes
            $texto_a_mostrar = $nombre_dia_semana . sprintf("%02d", $dia); // Se agrega un cero si el día es menor de 10

            // Agregar la celda con el texto
            $pdf->Cell($ancho_celda, $alto_celda, $texto_a_mostrar, 1, 0, 'C'); // Relleno de la celda y alineación del texto

            // Mover la posición al siguiente rectángulo
            $x_inicio += $ancho_celda; // Ajusta la posición para el siguiente día
            if ($x_inicio > 400) { // Si se alcanza el borde derecho de la página, regresa a la izquierda
                $x_inicio = $pdf->GetX() - 150.5;
                $y_inicio += $alto_celda; // Mueve a la siguiente fila
                $pdf->SetXY($x_inicio, $y_inicio); // Establece la nueva posición
            }
        }
    }

} else {
    echo "0 resultados";
}

$pdf->Output('Lista de Asistencia de ' . $materia . '.pdf', 'I', true, 'UTF-8');
$db->close();
?>