<?php
require('./fpdf.php');
require('conexion2.php');

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
        $this->Cell(-320, 15, utf8_decode('Martires de Chicago No 205. Col. Tesoro' . '                          (921) 218 - 2311 / 218 - 2312 / 218 - 9180'), 0, 0, 'C');    
        
        $this->Cell(280, 15, utf8_decode('Coatzacoalcos, Ver.'), 0, 0, 'R');
        
        $this->Cell(0, 15, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'R');
    }
}

$pdf = new PDFWithFooter();
    
        $pdf->AddPage();
        $pdf->AliasNbPages();

		            // Configuración del logo
        $pdf->Image('UNAM.jpg', 15, 5, 20); //logo de la empresa, moverDerecha, moverAbajo, tamañoIMG
            // Título 1
        $pdf->SetFont('Arial', 'B', 16); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $pdf->Cell(95); // Movernos a la derecha
        $pdf->SetTextColor(0, 0, 0); //color
        $pdf->Cell(1, 2, utf8_decode('UNIVERSIDAD DE SOTAVENTO, A.C.'), 0, 1, 'C', 0); // AnchoCelda, AltoCelda, Titulo, Borde, SaltoLinea, Posicion(L-C-R), ColorFondo
        $pdf->SetFont('Arial', '', 11); // Tipo de fuente, estilo, tamaño
        $pdf->Ln(5); // Salto de línea

            // Título 3
        $pdf->Cell(195, 1, utf8_decode('Campus Coatzacoalcos'), 0, 1, 'C', 0); // AnchoCelda, AltoCelda, Titulo, Borde, SaltoLinea, Posicion(L-C-R), ColorFondo
        $pdf->SetFont('Courier', '', 10); // Establece la fuente
        $pdf->Text(15, 30, utf8_decode('BOLETA TEMPORAL.'));;
        $pdf->Ln(25); // Salto de línea

		$pdf->SetFillColor(255, 255, 255); //colorFondo
        $pdf->SetTextColor(0, 0, 0); //colorTexto
        $pdf->SetDrawColor(0, 0, 0); //colorBorde
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Text(20, 38, utf8_decode('Destinatario.'));

        $pdf->SetXY(20, 40);
        $pdf->Cell(108, 25, utf8_decode(''), 1, 0, 'L', 1);
        $pdf->SetFont('Courier', '', 9); // Establece la fuente
        $pdf->Text(21, 46, utf8_decode('Sr.'));
        $pdf->Text(21, 51, utf8_decode('Domicilio:'));
        $pdf->Text(21, 56, utf8_decode('Colonia:'));
        $pdf->Text(21, 61, utf8_decode('Ciudad:             Codigo Postal:'));
        $pdf->Text(21, 69, utf8_decode('Alumno:       Nombre del Alumno'));
        $pdf->Text(111, 69, utf8_decode('Sem: 7'));
        $pdf->Ln(50); // Salto de línea

        $pdf->SetXY(15, 78);
        $pdf->Cell(90, 21, utf8_decode(''), 1, 0, 'L', 1);
        $pdf->Text(17,82, utf8_decode('Carrera   :  13 INGENIERIA EN SISTEMAS'));
        $pdf->Text(17,87, utf8_decode('Semestre  :  Noveno'));
        $pdf->Text(17,92, utf8_decode('Salon     :  9510'));
        $pdf->Text(17,97, utf8_decode('Turno     :  Vespertino'));

        $pdf->Ln(50); // Salto de línea
        $pdf->SetXY(120, 78);
        $pdf->Cell(75, 21, utf8_decode(''), 1, 0, 'L', 1);
        $pdf->SetFont('Courier', 'B', 10);
        $pdf->Text(125,85, utf8_decode('Nombre Completo del Alumno'));
        $pdf->SetFont('Courier', 'B', 9);
        $pdf->Text(170,97, utf8_decode('21.103.0075'));

        $pdf->Ln(1); // Salto de línea

        $pdf->SetXY(15, 250);
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(120, 25, utf8_decode('BOLETA DE CALIFICACIONES'), 1, 0, 'C', 1);
        $pdf->SetXY(135, 250);
		$pdf->Cell(70, 25, utf8_decode(''), 1, 0, 'C', 1);
        //------------------------------FIN DEL ENCABEZADO----------------------------------------------
		
        //----------------------INICIO DE LA LISTA DE LOS ALUMNOS--------------------------------------





	    if(isset($pdf->Footer)) {
        $footer = $pdf->Footer;
        $footer();
    }
	


    //echo "</ul>";



    
$pdf->Output('Listas de Asistencia.pdf', 'I');

$db->close();

?>