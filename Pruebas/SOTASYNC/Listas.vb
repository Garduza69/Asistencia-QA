Imports iTextSharp.text.pdf
Imports iTextSharp.text
Imports PdfiumViewer
Imports System.IO
Public Class Listas
    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        ' Define la ruta donde se guardará el archivo PDF
        Dim rutaPDF As String = "D:\Archivos\archivo.pdf" ' Cambia "ruta\archivo.pdf" por la ruta deseada

        ' Crea un documento PDF con orientación apaisada
        Using documento As New Document(PageSize.A4.Rotate()) ' Orientación apaisada
            ' Crea un escritor para el documento PDF
            Using escritor As PdfWriter = PdfWriter.GetInstance(documento, New FileStream(rutaPDF, FileMode.Create))
                ' Abre el documento para escribir contenido
                documento.Open()

                ' Agrega el encabezado
                AgregarEncabezado(escritor, documento)

                ' Añade espacios en blanco
                documento.Add(New Paragraph(" ")) ' Agrega un espacio en blanco entre el título y la tabla
                documento.Add(New Paragraph(" ")) ' Agrega otro espacio en blanco
                documento.Add(New Paragraph(" ")) ' Agrega otro espacio en blanco
                documento.Add(New Paragraph(" ")) ' Agrega otro espacio en blanco
                documento.Add(New Paragraph(" ")) ' Agrega otro espacio en blanco
                documento.Add(New Paragraph(" ")) ' Agrega otro espacio en blanco



                ' Agrega una tabla al documento
                Dim tabla As New PdfPTable(3) ' 3 columnas
                tabla.DefaultCell.BorderWidth = 1
                tabla.WidthPercentage = 100

                ' Agrega las celdas a la tabla
                For i As Integer = 1 To 10 ' Ejemplo: 10 filas
                    tabla.AddCell("Celda " & i & ",1")
                    tabla.AddCell("Celda " & i & ",2")
                    tabla.AddCell("Celda " & i & ",3")
                Next

                documento.Add(tabla)

                ' Cierra el documento
                documento.Close()
            End Using
        End Using

        ' Muestra un mensaje de éxito
        MessageBox.Show("PDF generado correctamente.", "Éxito", MessageBoxButtons.OK, MessageBoxIcon.Information)
    End Sub

    ' Crea un evento para agregar contenido al encabezado
    Private Sub AgregarEncabezado(writer As PdfWriter, documento As Document)
        ' Crea una instancia de la clase PdfContentByte
        Dim cb As PdfContentByte = writer.DirectContent

        ' Carga la imagen desde una ruta relativa en tu proyecto
        Dim imagen As iTextSharp.text.Image = iTextSharp.text.Image.GetInstance("D:\Proyectos visual Studio\SOTASYNC\Imagenes\UNAM.jpg") ' Cambia "ruta\imagen.jpg" por la ruta de tu imagen
        imagen.ScaleToFit(70, 70) ' Escala la imagen a un tamaño adecuado


        ' Agrega la imagen al encabezado en la esquina superior izquierda de la página
        imagen.SetAbsolutePosition(documento.Left, documento.Top - imagen.ScaledHeight)
        cb.AddImage(imagen)

        ' Agrega el título centrado en la parte superior
        Dim fuenteTitulo As BaseFont = BaseFont.CreateFont(BaseFont.HELVETICA, BaseFont.CP1250, BaseFont.NOT_EMBEDDED)
        cb.SetFontAndSize(fuenteTitulo, 12)
        cb.BeginText()
        cb.SetTextMatrix(documento.Left + 270, documento.Top - 1) ' Posición centrada
        cb.ShowText("UNIVERSIDAD DE SOTAVENTO A.C.")

        cb.EndText()

        Dim fuenteSubtitulo As BaseFont = BaseFont.CreateFont(BaseFont.HELVETICA, BaseFont.CP1250, BaseFont.NOT_EMBEDDED)
        cb.SetFontAndSize(fuenteSubtitulo, 10)
        cb.BeginText()
        cb.SetTextMatrix(documento.Left + 240, documento.Top - 20) ' Posición centrada
        cb.ShowText("INCORPORADA A LA SECRETARIA DE EDUCACION PUBLICA")
        cb.EndText()

        ' Agrega "Campos Sotavento" debajo del título
        Dim fuenteCampos As BaseFont = BaseFont.CreateFont(BaseFont.HELVETICA, BaseFont.CP1250, BaseFont.NOT_EMBEDDED)
        cb.SetFontAndSize(fuenteCampos, 12)
        cb.BeginText()
        cb.SetTextMatrix(documento.Left + 320, documento.Top - 40) ' Posición centrada
        cb.ShowText("Campus Sotavento")
        cb.EndText()
    End Sub

End Class