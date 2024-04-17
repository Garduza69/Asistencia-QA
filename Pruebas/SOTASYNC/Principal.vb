Imports System.Runtime.InteropServices
Imports System.Data.SqlClient
Public Class Principal

    Private Sub Timer1_Tick(sender As Object, e As EventArgs) Handles Timer1.Tick

        Dim cont As Integer = 0

        If Me.Opacity < 1 Then
            Me.Opacity += 0.4

        End If

        cont += 1
    End Sub


    Private Sub Principal_Load(sender As Object, e As EventArgs) Handles MyBase.Load


        ReleaseCapture()
        SendMessage(Me.Handle, &H112&, &HF012&, 0)
        Me.Opacity = 0.0
        Timer1.Start()
    End Sub

    Private Sub CargarDatosPasajeros()
        Dim connectionString As String = "Data Source=CASA_MAYOR_11\SQLEXPRESS;Initial Catalog=PRUEBAS_ETL;Integrated Security=True;"

        Dim query As String = "SELECT * FROM Usuario"

        ' Crea una nueva conexión SQL utilizando la cadena de conexión
        Using connection As New SqlConnection(connectionString)
            ' Crea un adaptador de datos SQL y un DataSet
            Using adapter As New SqlDataAdapter(query, connection)
                Dim dataSet As New DataSet()

                Try
                    ' Abre la conexión y llena el DataSet con los datos de la consulta
                    connection.Open()
                    adapter.Fill(dataSet, "Usuari")

                    ' Asigna el DataSet como origen de datos del DataGridView
                    Contenedor.DataSource = dataSet.Tables("Usuari")
                Catch ex As Exception
                    MessageBox.Show("Error al llenar el DataGridView: " & ex.Message)
                End Try
            End Using
        End Using

    End Sub

    Private Sub CargarDatosmaterias()
        Dim connectionString As String = "Data Source=CASA_MAYOR_11\SQLEXPRESS;Initial Catalog=PRUEBAS_ETL;Integrated Security=True;"

        Dim query As String = "SELECT * FROM MATERIAS"

        ' Crea una nueva conexión SQL utilizando la cadena de conexión
        Using connection As New SqlConnection(connectionString)
            ' Crea un adaptador de datos SQL y un DataSet
            Using adapter As New SqlDataAdapter(query, connection)
                Dim dataSet As New DataSet()

                Try
                    ' Abre la conexión y llena el DataSet con los datos de la consulta
                    connection.Open()
                    adapter.Fill(dataSet, "MATERIAS")

                    ' Asigna el DataSet como origen de datos del DataGridView
                    Contenedor.DataSource = dataSet.Tables("MATERIAS")
                Catch ex As Exception
                    MessageBox.Show("Error al llenar el DataGridView: " & ex.Message)
                End Try
            End Using
        End Using

    End Sub

    Private Sub CargarDatosVuelos()

    End Sub

    <DllImport("user32.DLL", EntryPoint:="ReleaseCapture")>
    Private Shared Sub ReleaseCapture()
    End Sub

    <DllImport("user32.DLL", EntryPoint:="SendMessage")>
    Private Shared Sub SendMessage(hwnd As IntPtr, wmsg As Integer, wparam As Integer, lparam As Integer)
    End Sub

    Private Sub titleBar_MouseDown(sender As Object, e As MouseEventArgs) Handles titleBar.MouseDown
        ReleaseCapture()
        SendMessage(Me.Handle, &H112&, &HF012&, 0)
    End Sub

    Private Sub Prinicipal_MouseDown(sender As Object, e As MouseEventArgs) Handles MyBase.MouseDown
        ReleaseCapture()
        SendMessage(Me.Handle, &H112, &HF012, 0)
    End Sub

    Private Sub panel1_MouseDown(sender As Object, e As MouseEventArgs) Handles panel1.MouseDown
        ReleaseCapture()
        SendMessage(Me.Handle, &H112, &HF012, 0)
    End Sub

    Private Sub btnminimizar_Click(sender As Object, e As EventArgs) Handles btnminimizar.Click
        Me.WindowState = FormWindowState.Minimized
    End Sub

    Private Sub btnsalir_Click(sender As Object, e As EventArgs) Handles btnsalir.Click

        Dim resultado As DialogResult = MessageBox.Show("¿Deseas cerrar sesión?", "Cerrar Sesión", MessageBoxButtons.YesNo, MessageBoxIcon.Question)
        If resultado = DialogResult.Yes Then
            Me.Close()

        End If
    End Sub


    Private Sub Compania_Click(sender As Object, e As EventArgs) Handles Compania.Click

    End Sub

    Private Sub Pasajeros_Click(sender As Object, e As EventArgs) Handles Pasajeros.Click
        ' Limpiar el DataGridView
        Contenedor.DataSource = Nothing
        Contenedor.Rows.Clear()

        ' Cargar nuevamente los datos de la tabla Pasajeros
        CargarDatosPasajeros()
        Listas.Show()
    End Sub

    Private Sub Contenedor_CellContentClick(sender As Object, e As DataGridViewCellEventArgs) Handles Contenedor.CellContentClick

    End Sub

    Private Sub materias_Click(sender As Object, e As EventArgs) Handles materias.Click
        ' Limpiar el DataGridView
        Contenedor.DataSource = Nothing
        Contenedor.Rows.Clear()

        ' Cargar nuevamente los datos de la tabla Vuelos
        CargarDatosmaterias()
    End Sub
End Class