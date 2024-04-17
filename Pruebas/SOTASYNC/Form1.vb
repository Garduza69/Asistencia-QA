Imports System.Runtime.InteropServices
Imports System.Data.SqlClient
Imports System.Runtime.InteropServices.JavaScript.JSType

Public Class Form1
    Private Sub CustomizeComponents()

        txtUser.AutoSize = False
        txtUser.Size = New Size(350, 30)

        txtPass.AutoSize = False
        txtPass.Size = New Size(350, 30)
        txtPass.UseSystemPasswordChar = True
    End Sub

    'Cerrar y Minimizar Formulario
    Private Sub btnClose_Click(sender As Object, e As EventArgs) Handles btnClose.Click
        Application.Exit()
    End Sub

    Private Sub btnMinimize_Click(sender As Object, e As EventArgs) Handles btnMinimize.Click
        Me.WindowState = FormWindowState.Minimized
    End Sub


    'mover Formulario

    <DllImport("user32.DLL", EntryPoint:="ReleaseCapture")>
    Private Shared Sub ReleaseCapture()
    End Sub
    <DllImport("user32.DLL", EntryPoint:="SendMessage")>
    Private Shared Sub SendMessage(hWnd As IntPtr, wMsg As Integer, wParam As Integer, lParam As Integer)
    End Sub

    Private Sub titleBar_MouseDown(sender As Object, e As MouseEventArgs) Handles titleBar.MouseDown
        ReleaseCapture()
        SendMessage(Me.Handle, &H112&, &HF012&, 0)
    End Sub

    Private Sub Form1_MouseDown(sender As Object, e As MouseEventArgs) Handles MyBase.MouseDown
        ReleaseCapture()
        SendMessage(Me.Handle, &H112&, &HF012&, 0)
    End Sub

    Private Sub iniciar_sesion_Click(sender As Object, e As EventArgs)

    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs)

        Me.Hide()
    End Sub

    Private Sub datos_Tick(sender As Object, e As EventArgs) Handles datos.Tick
        lblHora.Text = DateTime.Now.ToString("hh:mm:ss")
        lblFecha.Text = DateTime.Now.ToLongDateString()
    End Sub

    Private Sub Login_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        datos.Enabled = True
    End Sub

    Private Sub btnLogin_Click(sender As Object, e As EventArgs) Handles btnLogin.Click
        ' Dim connectionString As String = "Data Source=CASA_MAYOR_11\SQLEXPRESS;Initial Catalog=PRUEBA_ETL;Integrated Security=True;"
        'Dim query As String = "SELECT COUNT(*) FROM Usuario WHERE Email=@Usuario AND contrasena=@Contraseña"

        'Using connection As New SqlConnection(connectionString)
        'Dim command As New SqlCommand(query, connection)
        'Command.Parameters.AddWithValue("@Usuario", txtUser.Text)
        ' Command.Parameters.AddWithValue("@Contraseña", txtPass.Text)

        'connection.Open()
        'Dim result As Integer = CInt(command.ExecuteScalar())
        'connection.Close()

        'If result > 0 Then
        'MessageBox.Show("Inicio de sesión exitoso.")
        'Aquí puedes redirigir al usuario a otra ventana o mostrar el contenido protegido.'
        ' conectar.textoGuardado = txtUser.Text
        Principal.Show()
        Me.Hide()
        ' Else
        'MessageBox.Show("Usuario o contraseña incorrectos.")
        'End If
        'End Using
    End Sub

    Private Sub BtnRegistro_Click(sender As Object, e As EventArgs) Handles BtnRegistro.Click
    End Sub

End Class
