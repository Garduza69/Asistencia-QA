<?php
require('./fpdf.php');
require('../../../conexion2.php');


class PDFWithFooter extends FPDF {
    // Pie de página
    function Footer() {
        // Posición a 1,5 cm desde abajo
        $this->SetY(-13);
        // Arial italic 8
        $this->SetFont('Arial','I',9);
        
        // Establecer la zona horaria a México
        date_default_timezone_set('America/Mexico_City');
        
        // Obtener la fecha de hoy en formato dd/mm/aaaa
        $fecha_actual = date('d/m/Y');
        
        // Obtener la hora actual en formato 00:00:00 PM/AM
        $hora_actual = date('h:i:s A');
        
        // Agregar la fecha actual al pie de página
        $this->Cell(0, 15, utf8_decode($fecha_actual.'  '.$hora_actual), 0, 0, 'L');
        $this->Cell(-280, 15, utf8_decode('Martires de Chicago No 205. Col. Tesoro' . '               (921) 218 - 2311 / 218 - 2312 / 218 - 9180'), 0, 0, 'C');    
        
        $this->Cell(250, 15, utf8_decode('Coatzacoalcos, Ver.'), 0, 0, 'R');
        
        $this->Cell(0, 15, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'R');
    }
}

$pdf = new PDFWithFooter();
$matricula = $_GET['matricula'];
$dia_seleccionado = $_GET['dia_seleccionado'];
$mes = $_GET['mes'];
$motivo = $_GET['motivo_seleccionado'];
$fecha = $_GET['dia'];

$consultaJustificacion = $db->query("UPDATE asistencia AS asis
JOIN alumnos AS al ON asis.alumno_id = al.alumno_id
SET asis.asistencia = 2
WHERE MONTH(asis.fecha_alta) = '".$mes."'
    AND DAY(asis.fecha_alta) = '".$dia_seleccionado."'
    AND al.matricula = '".$matricula."';");

$pdf->SetTitle('Justificante', true);

$consultaEncabezado = $db->query("SELECT 
    al.matricula,
    al.nombre AS Nombre, 
    ' ', 
    al.primer_apellido AS Apellido_Paterno, 
    ' ', 
    al.segundo_apellido AS Apellido_Materno,
    f.nombre AS Facultad,
    gr.clave_grupo AS Grupo,
    s.Turno AS Turno,
    asis.fecha_alta,
    asis.asistencia,
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
    s.nombre AS Semestre
FROM 
    matricula mat
JOIN 
    alumnos al ON mat.alumno_id = al.alumno_id
JOIN 
    grupos gr ON mat.grupo_id = gr.grupo_id
JOIN 
    facultades f ON gr.facultad_id = f.facultad_id
JOIN 
    asistencia asis ON asis.asistencia 
JOIN 
    semestres s ON gr.semestre_id = s.semestre_id
WHERE 
    MONTH(asis.fecha_alta) = '".$mes."'
    AND DAY(asis.fecha_alta) = '".$dia_seleccionado."'
    AND al.matricula =  '".$matricula."'
    AND gr.vigenciaSem = 1;");


if($consultaEncabezado->num_rows > 0) {
    while ($fila = $consultaEncabezado->fetch_assoc()) {
        $pdf->AddPage('L', array(279.4, 148));
        $pdf->AliasNbPages();
        $pdf->Image('../../../img/logoSotavento.png', 22.5, 7.5, 25);
        $pdf->Image('../../../img/IQS.jpg', 232.5, 7.5, 25);
        $pdf->SetFont('Arial', 'B', 17);
        $pdf->Cell(100);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(60, 1, utf8_decode('UNIVERSIDAD DE SOTAVENTO, A.C.'), 0, 1, 'C', 0);
        // Establecer la posición absoluta del bloque
        $pdf->SetXY(10, 5);

        // Dibujar las celdas del bloque
        $pdf->Cell(50, 30, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(160, 30, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 30, utf8_decode(' '), 1, 1, 'C');




        $pdf->SetFont('Arial', 'B', 17);
        $pdf->Ln(5);
        $pdf->Cell(260, -40, utf8_decode('CAMPUS COATZACOALCOS'), 0, 1, 'C', 0);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 17);
        $pdf->Cell(260, 50, utf8_decode('DIRECCION ACADEMICA'), 0, 1, 'C', 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Ln(5);

        $pdf->SetXY(10, 40);
        $pdf->SetFont('Arial', 'B', 13);
		$pdf->SetFillColor(219, 219, 219); // Gris claro
        // Dibujar las celdas del bloque
        $pdf->Cell(70, 8, utf8_decode('APELLIDO PATERNO'), 1, 0, 'C', true);
        $pdf->Cell(120, 8, utf8_decode('APELLIDO MATERNO'), 1, 0, 'C', true);
        $pdf->Cell(70, 8, utf8_decode('NOMBRE'), 1, 1, 'C', true);

        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 16);
        $pdf->SetXY(10, 48);

        $pdf->Cell(70, 12, utf8_decode($fila['Apellido_Paterno']), 1, 0, 'C');
        $pdf->Cell(120, 12, utf8_decode($fila['Apellido_Materno']), 1, 0, 'C');
        $pdf->Cell(70, 12, utf8_decode($fila['Nombre']), 1, 1, 'C');

        $pdf->Ln(5);

        $pdf->SetXY(10, 60);
        $pdf->SetFont('Arial', 'B', 13);
		$pdf->SetFillColor(219, 219, 219); // Gris claro

        $pdf->Cell(70, 8, utf8_decode('LICENCIATURA'), 1, 0, 'C', true);
        $pdf->Cell(120, 8, utf8_decode('SEMESTRE'), 1, 0, 'C', true);
        $pdf->Cell(70, 8, utf8_decode('TURNO'), 1, 1, 'C', true);

        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 16);
        $pdf->SetXY(10, 68);

        $pdf->Cell(70, 12, utf8_decode($fila['Facultad']), 1, 0, 'C');
        $pdf->Cell(120, 12, utf8_decode($fila['Semestre']), 1, 0, 'C');
        $pdf->Cell(70, 12, utf8_decode($fila['Turno']), 1, 1, 'C');

        $pdf->Ln(5);

        $pdf->SetXY(10, 80);
        $pdf->SetFont('Arial', 'B', 13);
		$pdf->SetFillColor(219, 219, 219); // Gris claro

        $pdf->Cell(70, 8, utf8_decode('PERIODO A JUSTIFICAR'), 1, 0, 'C', true);
        $pdf->Cell(190, 8, utf8_decode('MOTIVO DE LA FALTA'), 1, 0, 'C', true);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 16);
        $pdf->SetXY(10, 88);
        // Convertir la fecha a formato UNIX y luego formatearla como dd/mm/aaaa
        $fecha_formateada = date("d/m/Y", strtotime($fecha));

        $pdf->Cell(70, 14, utf8_decode($fecha_formateada), 1, 0, 'C');
		$pdf->SetFont('Arial', '', 14);
        $pdf->Cell(190, 14, utf8_decode($motivo), 1, 0, 'C');

        $pdf->Ln(5);

        $pdf->SetXY(10, 102);
        $pdf->SetFont('Arial', 'B', 13);
		$pdf->SetFillColor(219, 219, 219); // Gris claro

        $pdf->Cell(70, 8, utf8_decode('AUTORIZACION'), 1, 0, 'C', true);
        $pdf->Cell(120, 8, utf8_decode('SELLO DE LA INSTITUCION'), 1, 0, 'C', true);
        $pdf->Cell(70, 8, utf8_decode('FECHA'), 1, 1, 'C', true);

        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 15);
        $pdf->SetXY(10, 110);
        // Establecer la zona horaria a México
        date_default_timezone_set('America/Mexico_City');
        
        // Obtener la fecha de hoy en formato dd/mm/aaaa
        $fecha_actual = date('d/m/Y');
        
        // Agregar la fecha actual al pie de página
        $pdf->Cell(70, 17, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(120, 17, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(70, 17, utf8_decode($fecha_actual), 1, 1, 'C');

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(163, 163, 163);
        $pdf->SetFont('Arial', '', 9);






    }
		if(isset($pdf->Footer)) {
        $footer = $pdf->Footer;
        $footer();
    }
	

} else {
    echo "0 resultados";
}
$pdf->Output('Justificante.pdf', 'I', true, 'UTF-8');
$db->close();
?>