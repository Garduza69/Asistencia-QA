<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class Form1
    Inherits System.Windows.Forms.Form

    'Form reemplaza a Dispose para limpiar la lista de componentes.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Requerido por el Diseñador de Windows Forms
    Private components As System.ComponentModel.IContainer

    'NOTA: el Diseñador de Windows Forms necesita el siguiente procedimiento
    'Se puede modificar usando el Diseñador de Windows Forms.  
    'No lo modifique con el editor de código.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(Form1))
        Me.mantenimiento = New System.Windows.Forms.GroupBox()
        Me.apellido_paterno_usuario = New System.Windows.Forms.TextBox()
        Me.nombre_usuario = New System.Windows.Forms.TextBox()
        Me.clave_cliente = New System.Windows.Forms.TextBox()
        Me.Label5 = New System.Windows.Forms.Label()
        Me.Label4 = New System.Windows.Forms.Label()
        Me.Label3 = New System.Windows.Forms.Label()
        Me.Label2 = New System.Windows.Forms.Label()
        Me.apellido_materno_usuario = New System.Windows.Forms.TextBox()
        Me.guardar_cliente = New System.Windows.Forms.Button()
        Me.eliminar_cliente = New System.Windows.Forms.Button()
        Me.mantenimiento.SuspendLayout()
        Me.SuspendLayout()
        '
        'mantenimiento
        '
        Me.mantenimiento.BackColor = System.Drawing.Color.Transparent
        Me.mantenimiento.Controls.Add(Me.apellido_materno_usuario)
        Me.mantenimiento.Controls.Add(Me.apellido_paterno_usuario)
        Me.mantenimiento.Controls.Add(Me.nombre_usuario)
        Me.mantenimiento.Controls.Add(Me.clave_cliente)
        Me.mantenimiento.Controls.Add(Me.Label5)
        Me.mantenimiento.Controls.Add(Me.Label4)
        Me.mantenimiento.Controls.Add(Me.Label3)
        Me.mantenimiento.Controls.Add(Me.Label2)
        Me.mantenimiento.Font = New System.Drawing.Font("Microsoft YaHei", 10.8!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.mantenimiento.ForeColor = System.Drawing.SystemColors.ButtonFace
        Me.mantenimiento.Location = New System.Drawing.Point(12, 12)
        Me.mantenimiento.Name = "mantenimiento"
        Me.mantenimiento.Size = New System.Drawing.Size(517, 225)
        Me.mantenimiento.TabIndex = 47
        Me.mantenimiento.TabStop = False
        Me.mantenimiento.Text = "Datos Personales"
        '
        'apellido_paterno_usuario
        '
        Me.apellido_paterno_usuario.BackColor = System.Drawing.Color.SeaShell
        Me.apellido_paterno_usuario.Location = New System.Drawing.Point(151, 115)
        Me.apellido_paterno_usuario.Name = "apellido_paterno_usuario"
        Me.apellido_paterno_usuario.Size = New System.Drawing.Size(348, 27)
        Me.apellido_paterno_usuario.TabIndex = 12
        '
        'nombre_usuario
        '
        Me.nombre_usuario.BackColor = System.Drawing.Color.SeaShell
        Me.nombre_usuario.Location = New System.Drawing.Point(151, 67)
        Me.nombre_usuario.Name = "nombre_usuario"
        Me.nombre_usuario.Size = New System.Drawing.Size(348, 27)
        Me.nombre_usuario.TabIndex = 11
        '
        'clave_cliente
        '
        Me.clave_cliente.BackColor = System.Drawing.Color.SeaShell
        Me.clave_cliente.Location = New System.Drawing.Point(151, 24)
        Me.clave_cliente.Name = "clave_cliente"
        Me.clave_cliente.Size = New System.Drawing.Size(113, 27)
        Me.clave_cliente.TabIndex = 10
        '
        'Label5
        '
        Me.Label5.AutoSize = True
        Me.Label5.Location = New System.Drawing.Point(9, 117)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(139, 19)
        Me.Label5.TabIndex = 3
        Me.Label5.Text = "Apellido paterno:"
        '
        'Label4
        '
        Me.Label4.AutoSize = True
        Me.Label4.Location = New System.Drawing.Point(5, 159)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(144, 19)
        Me.Label4.TabIndex = 2
        Me.Label4.Text = "Apellido materno:"
        '
        'Label3
        '
        Me.Label3.AutoSize = True
        Me.Label3.Location = New System.Drawing.Point(72, 70)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(76, 19)
        Me.Label3.TabIndex = 1
        Me.Label3.Text = "Nombre:"
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Location = New System.Drawing.Point(56, 29)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(86, 19)
        Me.Label2.TabIndex = 0
        Me.Label2.Text = "ID Cliente:"
        '
        'apellido_materno_usuario
        '
        Me.apellido_materno_usuario.BackColor = System.Drawing.Color.SeaShell
        Me.apellido_materno_usuario.Location = New System.Drawing.Point(151, 157)
        Me.apellido_materno_usuario.Name = "apellido_materno_usuario"
        Me.apellido_materno_usuario.Size = New System.Drawing.Size(348, 27)
        Me.apellido_materno_usuario.TabIndex = 13
        '
        'guardar_cliente
        '
        Me.guardar_cliente.BackColor = System.Drawing.Color.Transparent
        Me.guardar_cliente.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Bold)
        Me.guardar_cliente.Image = CType(resources.GetObject("guardar_cliente.Image"), System.Drawing.Image)
        Me.guardar_cliente.Location = New System.Drawing.Point(548, 23)
        Me.guardar_cliente.Name = "guardar_cliente"
        Me.guardar_cliente.Size = New System.Drawing.Size(82, 103)
        Me.guardar_cliente.TabIndex = 48
        Me.guardar_cliente.Text = "Guardar"
        Me.guardar_cliente.TextAlign = System.Drawing.ContentAlignment.BottomCenter
        Me.guardar_cliente.UseVisualStyleBackColor = False
        '
        'eliminar_cliente
        '
        Me.eliminar_cliente.BackColor = System.Drawing.SystemColors.ControlLightLight
        Me.eliminar_cliente.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.0!, System.Drawing.FontStyle.Bold)
        Me.eliminar_cliente.Image = CType(resources.GetObject("eliminar_cliente.Image"), System.Drawing.Image)
        Me.eliminar_cliente.Location = New System.Drawing.Point(549, 137)
        Me.eliminar_cliente.Name = "eliminar_cliente"
        Me.eliminar_cliente.Size = New System.Drawing.Size(82, 106)
        Me.eliminar_cliente.TabIndex = 49
        Me.eliminar_cliente.Text = "Eliminar"
        Me.eliminar_cliente.TextAlign = System.Drawing.ContentAlignment.BottomCenter
        Me.eliminar_cliente.UseVisualStyleBackColor = False
        '
        'Form1
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.BackColor = System.Drawing.Color.FromArgb(CType(CType(25, Byte), Integer), CType(CType(30, Byte), Integer), CType(CType(50, Byte), Integer))
        Me.ClientSize = New System.Drawing.Size(643, 255)
        Me.Controls.Add(Me.eliminar_cliente)
        Me.Controls.Add(Me.guardar_cliente)
        Me.Controls.Add(Me.mantenimiento)
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None
        Me.Name = "Form1"
        Me.Text = "Form1"
        Me.mantenimiento.ResumeLayout(False)
        Me.mantenimiento.PerformLayout()
        Me.ResumeLayout(False)

    End Sub

    Friend WithEvents mantenimiento As GroupBox
    Friend WithEvents apellido_materno_usuario As TextBox
    Friend WithEvents apellido_paterno_usuario As TextBox
    Friend WithEvents nombre_usuario As TextBox
    Friend WithEvents clave_cliente As TextBox
    Friend WithEvents Label5 As Label
    Friend WithEvents Label4 As Label
    Friend WithEvents Label3 As Label
    Friend WithEvents Label2 As Label
    Friend WithEvents guardar_cliente As Button
    Friend WithEvents eliminar_cliente As Button
End Class
