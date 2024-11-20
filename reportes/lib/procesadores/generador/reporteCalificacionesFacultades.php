<?php


require('./fpdf.php');
require('../../../../conexion2.php');

class PDFWithFooter extends FPDF {
    // Pie de página
    function Footer() {
        // Posición a 1,5 cm desde abajo
        $this->SetY(-13);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        
        // Establecer la zona horaria a México
        date_default_timezone_set('America/Mexico_City');
        
        // Obtener la fecha de hoy en formato dd/mm/aaaa
        $fecha_actual = date('d/m/Y');
        
        // Obtener la hora actual en formato 00:00:00 PM/AM
        $hora_actual = date('h:i:s A');
        
        // Agregar la fecha actual al pie de página
        $this->Cell(0, 15, utf8_decode($fecha_actual.'  '.$hora_actual), 0, 0, 'L');
        $this->Cell(-198, 15, utf8_decode('Martires de Chicago No 205. Col. Tesoro' . '    (921) 218 - 2311 / 218 - 2312 / 218 - 9180'), 0, 0, 'C');    
        
        $this->Cell(182, 15, utf8_decode('Coatzacoalcos, Ver.'), 0, 0, 'R');
		$this->Cell(0, 15, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'R');
        
    }
}

$pdf = new PDFWithFooter();
$facultad = $_GET['facultad'];
$grupo = $_GET['grupo'];

        $queryEncabezado = $db->query("SELECT  
    							al.matricula AS matriculas,
    							CONCAT(al.nombre, ' ', al.primer_apellido, ' ', al.segundo_apellido) AS Nombre_Alumno,
    							al.sr AS nombre,
    							al.domicilio AS domicilio,
								al.colonia AS colonia,
   								al.codigo_postal AS codigo_postal,               
   								al.ciudad AS ciudad,
   								f.nombre AS Facultad,
    								gr.clave_grupo AS Grupo,
    								s.Turno AS Turno,
   								 	s.nombre AS Semestre
								FROM matricula mat
									JOIN alumnos al ON mat.alumno_id = al.alumno_id
										JOIN grupos gr ON mat.grupo_id = gr.grupo_id
										JOIN facultades f ON gr.facultad_id = f.facultad_id
										JOIN semestres s ON gr.semestre_id = s.semestre_id
									WHERE 
    									f.nombre = '".$facultad."'
   										AND gr.clave_grupo = '".$grupo."'
  										AND gr.vigenciaSem = 1
									GROUP BY
    								al.matricula;");

		
        if($queryEncabezado->num_rows > 0){
            while ($fila = $queryEncabezado->fetch_assoc()) {    
                $pdf->AddPage();
                $pdf->AliasNbPages();

                // Configuración del logo
                $pdf->Image('../../../img/UNAM.jpg', 15, 5, 20);
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(95);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(1, 2, utf8_decode('UNIVERSIDAD DE SOTAVENTO, A.C.'), 0, 1, 'C', 0);
                $pdf->SetFont('Arial', '', 11);
                $pdf->Ln(5);
                $pdf->Cell(195, 1, utf8_decode('Campus Coatzacoalcos'), 0, 1, 'C', 0);
                $pdf->SetFont('Courier', '', 10);
                $pdf->Text(15, 30, utf8_decode('BOLETA TEMPORAL.'));
                $pdf->Ln(25);


                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Text(20, 38, utf8_decode('Destinatario.'));

                $pdf->SetXY(20, 40);
                $pdf->Cell(115, 25, utf8_decode(''), 1, 0, 'L', 1);
                $pdf->SetFont('Courier', '', 9);
                $pdf->Text(21, 46, utf8_decode('Sr.									' . $fila['nombre']));
                $pdf->Text(21, 51, utf8_decode('Domicilio:		' . $fila['domicilio']));
                $pdf->Text(21, 56, utf8_decode('Colonia:				'. $fila['colonia']));
                $pdf->Text(21, 61, utf8_decode('Ciudad: 				'  . $fila['ciudad'].' 		Codigo Postal:	'  . $fila['codigo_postal']));
                $pdf->Text(21, 69, utf8_decode('Alumno:       ' . $fila['Nombre_Alumno']));
                $pdf->Text(111, 69, utf8_decode('Sem: ' . $fila['Semestre']));
                $pdf->Ln(50);

                $pdf->SetXY(15, 78);
                $pdf->Cell(90, 21, utf8_decode(''), 1, 0, 'L', 1);
                $pdf->Text(17,82, utf8_decode('Carrera   :  ' . $fila['Facultad']));
                $pdf->Text(17,87, utf8_decode('Semestre  :  ' . $fila['Semestre']));
                $pdf->Text(17,92, utf8_decode('Salon     :  ' . $fila['Grupo']));
                $pdf->Text(17,97, utf8_decode('Turno     :  ' . $fila['Turno']));

                $pdf->Ln(50);
                $pdf->SetXY(120, 78);
                $pdf->Cell(75, 21, utf8_decode(''), 1, 0, 'L', 1);
                $pdf->SetFont('Courier', 'B', 10);
                $pdf->Text(125,85, utf8_decode($fila['Nombre_Alumno']));
                $pdf->SetFont('Courier', 'B', 9);
                $pdf->Text(170,97, utf8_decode($fila['matriculas']));
				
				$pdf->Ln(25); // Salto de línea
				$pdf->SetXY(5, 103);
				
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(10, 8, utf8_decode('No.'), 1, 0, 'C', 0);
				$pdf->Cell(72, 8, utf8_decode('Nombre de la Asignatura'), 1, 0, 'C', 0);
				$pdf->Cell(9, 8, utf8_decode('Cal1'), 1, 0, 'C', 0);
				$pdf->Cell(9, 8, utf8_decode('Cal2'), 1, 0, 'C', 0);
				$pdf->Cell(9, 8, utf8_decode('Cal3'), 1, 0, 'C', 0);
				$pdf->Cell(12, 8, utf8_decode('PROM.'), 1, 0, 'C', 0);
				$pdf->Cell(13, 8, utf8_decode(' '), 1, 0, 'C', 0);
				$pdf->Cell(8, 8, utf8_decode('Ord.'), 1, 0, 'C', 0);
				$pdf->Cell(9.5, 8, utf8_decode('Exa II'), 1, 0, 'C', 0);
				$pdf->Cell(10.5, 8, utf8_decode('Ord. II'), 1, 0, 'C', 0);
				$pdf->Cell(11, 8, utf8_decode('E. Ext.'), 1, 0, 'C', 0);
				$pdf->Cell(19, 8, utf8_decode('Calificación'), 1, 0, 'C', 0);
				$pdf->Cell(10, 8, utf8_decode('Faltas'), 1, 0, 'C', 0);
				$pdf->SetFont('Arial', 'B', 7.5);
				$pdf->Text(127, 106, utf8_decode('Examen'));
				$pdf->Text(127, 109, utf8_decode('Ordinario'));
				$pdf->Ln(8); 



				$pdf->SetFont('Courier', '', 10);
				$pdf->Text(8, 150, utf8_decode('www.universidadsotavento.com'));
											

                $pdf->Ln(1);
                $pdf->SetXY(15, 250);
                $pdf->SetFont('Arial', 'B', 20);
                $pdf->Cell(120, 25, utf8_decode('BOLETA DE CALIFICACIONES'), 1, 0, 'C', 1);
                $pdf->SetXY(135, 250);
                $pdf->Cell(70, 25, utf8_decode(''), 1, 0, 'C', 1);		
            }
        }


$pdf->Output('Boleta Temporal.pdf', 'I');
$db->close();
?>