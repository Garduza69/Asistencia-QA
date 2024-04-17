<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()>
Partial Class Principal
    Inherits System.Windows.Forms.Form

    'Form reemplaza a Dispose para limpiar la lista de componentes.
    <System.Diagnostics.DebuggerNonUserCode()>
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
    <System.Diagnostics.DebuggerStepThrough()>
    Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container()
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(Principal))
        Me.titleBar = New System.Windows.Forms.Panel()
        Me.btnminimizar = New System.Windows.Forms.PictureBox()
        Me.MenuVertical = New System.Windows.Forms.Panel()
        Me.PictureBox8 = New System.Windows.Forms.PictureBox()
        Me.PictureBox7 = New System.Windows.Forms.PictureBox()
        Me.PictureBox6 = New System.Windows.Forms.PictureBox()
        Me.PictureBox5 = New System.Windows.Forms.PictureBox()
        Me.PictureBox4 = New System.Windows.Forms.PictureBox()
        Me.PictureBox2 = New System.Windows.Forms.PictureBox()
        Me.PictureBox1 = New System.Windows.Forms.PictureBox()
        Me.pictureBox3 = New System.Windows.Forms.PictureBox()
        Me.btnsalir = New System.Windows.Forms.PictureBox()
        Me.panel7 = New System.Windows.Forms.Panel()
        Me.btnReportes = New System.Windows.Forms.Button()
        Me.panel6 = New System.Windows.Forms.Panel()
        Me.button6 = New System.Windows.Forms.Button()
        Me.panel5 = New System.Windows.Forms.Panel()
        Me.Tripulacion = New System.Windows.Forms.Button()
        Me.panel4 = New System.Windows.Forms.Panel()
        Me.Aeronaves = New System.Windows.Forms.Button()
        Me.panel3 = New System.Windows.Forms.Panel()
        Me.Pasajeros = New System.Windows.Forms.Button()
        Me.panel2 = New System.Windows.Forms.Panel()
        Me.Compania = New System.Windows.Forms.Button()
        Me.panel1 = New System.Windows.Forms.Panel()
        Me.materias = New System.Windows.Forms.Button()
        Me.Timer1 = New System.Windows.Forms.Timer(Me.components)
        Me.Timer2 = New System.Windows.Forms.Timer(Me.components)
        Me.Contenedor = New System.Windows.Forms.DataGridView()
        Me.panelContenedor = New System.Windows.Forms.Panel()
        Me.titleBar.SuspendLayout()
        CType(Me.btnminimizar, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.MenuVertical.SuspendLayout()
        CType(Me.PictureBox8, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox7, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox6, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox5, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox4, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox2, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.pictureBox3, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.btnsalir, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.Contenedor, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.panelContenedor.SuspendLayout()
        Me.SuspendLayout()
        '
        'titleBar
        '
        Me.titleBar.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.titleBar.Controls.Add(Me.btnminimizar)
        Me.titleBar.Dock = System.Windows.Forms.DockStyle.Top
        Me.titleBar.Location = New System.Drawing.Point(0, 0)
        Me.titleBar.Name = "titleBar"
        Me.titleBar.Size = New System.Drawing.Size(1300, 40)
        Me.titleBar.TabIndex = 26
        '
        'btnminimizar
        '
        Me.btnminimizar.Cursor = System.Windows.Forms.Cursors.Hand
        Me.btnminimizar.Image = CType(resources.GetObject("btnminimizar.Image"), System.Drawing.Image)
        Me.btnminimizar.Location = New System.Drawing.Point(1273, 12)
        Me.btnminimizar.Name = "btnminimizar"
        Me.btnminimizar.Size = New System.Drawing.Size(15, 15)
        Me.btnminimizar.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom
        Me.btnminimizar.TabIndex = 19
        Me.btnminimizar.TabStop = False
        '
        'MenuVertical
        '
        Me.MenuVertical.BackColor = System.Drawing.Color.DarkRed
        Me.MenuVertical.Controls.Add(Me.PictureBox8)
        Me.MenuVertical.Controls.Add(Me.PictureBox7)
        Me.MenuVertical.Controls.Add(Me.PictureBox6)
        Me.MenuVertical.Controls.Add(Me.PictureBox5)
        Me.MenuVertical.Controls.Add(Me.PictureBox4)
        Me.MenuVertical.Controls.Add(Me.PictureBox2)
        Me.MenuVertical.Controls.Add(Me.PictureBox1)
        Me.MenuVertical.Controls.Add(Me.pictureBox3)
        Me.MenuVertical.Controls.Add(Me.btnsalir)
        Me.MenuVertical.Controls.Add(Me.panel7)
        Me.MenuVertical.Controls.Add(Me.btnReportes)
        Me.MenuVertical.Controls.Add(Me.panel6)
        Me.MenuVertical.Controls.Add(Me.button6)
        Me.MenuVertical.Controls.Add(Me.panel5)
        Me.MenuVertical.Controls.Add(Me.Tripulacion)
        Me.MenuVertical.Controls.Add(Me.panel4)
        Me.MenuVertical.Controls.Add(Me.Aeronaves)
        Me.MenuVertical.Controls.Add(Me.panel3)
        Me.MenuVertical.Controls.Add(Me.Pasajeros)
        Me.MenuVertical.Controls.Add(Me.panel2)
        Me.MenuVertical.Controls.Add(Me.Compania)
        Me.MenuVertical.Controls.Add(Me.panel1)
        Me.MenuVertical.Controls.Add(Me.materias)
        Me.MenuVertical.Dock = System.Windows.Forms.DockStyle.Left
        Me.MenuVertical.Location = New System.Drawing.Point(0, 40)
        Me.MenuVertical.Name = "MenuVertical"
        Me.MenuVertical.Size = New System.Drawing.Size(220, 610)
        Me.MenuVertical.TabIndex = 27
        '
        'PictureBox8
        '
        Me.PictureBox8.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.PictureBox8.Image = CType(resources.GetObject("PictureBox8.Image"), System.Drawing.Image)
        Me.PictureBox8.Location = New System.Drawing.Point(12, 398)
        Me.PictureBox8.Name = "PictureBox8"
        Me.PictureBox8.Size = New System.Drawing.Size(32, 32)
        Me.PictureBox8.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom
        Me.PictureBox8.TabIndex = 24
        Me.PictureBox8.TabStop = False
        '
        'PictureBox7
        '
        Me.PictureBox7.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.PictureBox7.Image = CType(resources.GetObject("PictureBox7.Image"), System.Drawing.Image)
        Me.PictureBox7.Location = New System.Drawing.Point(11, 360)
        Me.PictureBox7.Name = "PictureBox7"
        Me.PictureBox7.Size = New System.Drawing.Size(32, 32)
        Me.PictureBox7.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom
        Me.PictureBox7.TabIndex = 23
        Me.PictureBox7.TabStop = False
        '
        'PictureBox6
        '
        Me.PictureBox6.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.PictureBox6.Image = CType(resources.GetObject("PictureBox6.Image"), System.Drawing.Image)
        Me.PictureBox6.Location = New System.Drawing.Point(12, 322)
        Me.PictureBox6.Name = "PictureBox6"
        Me.PictureBox6.Size = New System.Drawing.Size(32, 32)
        Me.PictureBox6.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom
        Me.PictureBox6.TabIndex = 22
        Me.PictureBox6.TabStop = False
        '
        'PictureBox5
        '
        Me.PictureBox5.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.PictureBox5.Image = CType(resources.GetObject("PictureBox5.Image"), System.Drawing.Image)
        Me.PictureBox5.Location = New System.Drawing.Point(12, 284)
        Me.PictureBox5.Name = "PictureBox5"
        Me.PictureBox5.Size = New System.Drawing.Size(32, 32)
        Me.PictureBox5.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom
        Me.PictureBox5.TabIndex = 21
        Me.PictureBox5.TabStop = False
        '
        'PictureBox4
        '
        Me.PictureBox4.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.PictureBox4.Image = CType(resources.GetObject("PictureBox4.Image"), System.Drawing.Image)
        Me.PictureBox4.Location = New System.Drawing.Point(12, 246)
        Me.PictureBox4.Name = "PictureBox4"
        Me.PictureBox4.Size = New System.Drawing.Size(32, 32)
        Me.PictureBox4.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom
        Me.PictureBox4.TabIndex = 20
        Me.PictureBox4.TabStop = False
        '
        'PictureBox2
        '
        Me.PictureBox2.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.PictureBox2.Image = CType(resources.GetObject("PictureBox2.Image"), System.Drawing.Image)
        Me.PictureBox2.Location = New System.Drawing.Point(12, 170)
        Me.PictureBox2.Name = "PictureBox2"
        Me.PictureBox2.Size = New System.Drawing.Size(32, 32)
        Me.PictureBox2.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom
        Me.PictureBox2.TabIndex = 19
        Me.PictureBox2.TabStop = False
        '
        'PictureBox1
        '
        Me.PictureBox1.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.PictureBox1.Image = CType(resources.GetObject("PictureBox1.Image"), System.Drawing.Image)
        Me.PictureBox1.Location = New System.Drawing.Point(12, 208)
        Me.PictureBox1.Name = "PictureBox1"
        Me.PictureBox1.Size = New System.Drawing.Size(32, 32)
        Me.PictureBox1.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom
        Me.PictureBox1.TabIndex = 18
        Me.PictureBox1.TabStop = False
        '
        'pictureBox3
        '
        Me.pictureBox3.Image = CType(resources.GetObject("pictureBox3.Image"), System.Drawing.Image)
        Me.pictureBox3.Location = New System.Drawing.Point(43, 23)
        Me.pictureBox3.Name = "pictureBox3"
        Me.pictureBox3.Size = New System.Drawing.Size(140, 127)
        Me.pictureBox3.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom
        Me.pictureBox3.TabIndex = 17
        Me.pictureBox3.TabStop = False
        '
        'btnsalir
        '
        Me.btnsalir.Image = CType(resources.GetObject("btnsalir.Image"), System.Drawing.Image)
        Me.btnsalir.Location = New System.Drawing.Point(3, 568)
        Me.btnsalir.Name = "btnsalir"
        Me.btnsalir.Size = New System.Drawing.Size(46, 41)
        Me.btnsalir.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom
        Me.btnsalir.TabIndex = 16
        Me.btnsalir.TabStop = False
        '
        'panel7
        '
        Me.panel7.BackColor = System.Drawing.Color.Red
        Me.panel7.Location = New System.Drawing.Point(0, 398)
        Me.panel7.Name = "panel7"
        Me.panel7.Size = New System.Drawing.Size(5, 32)
        Me.panel7.TabIndex = 14
        '
        'btnReportes
        '
        Me.btnReportes.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.btnReportes.FlatAppearance.BorderSize = 0
        Me.btnReportes.FlatAppearance.MouseOverBackColor = System.Drawing.Color.FromArgb(CType(CType(0, Byte), Integer), CType(CType(80, Byte), Integer), CType(CType(200, Byte), Integer))
        Me.btnReportes.FlatStyle = System.Windows.Forms.FlatStyle.Flat
        Me.btnReportes.Font = New System.Drawing.Font("Century Gothic", 11.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.btnReportes.ForeColor = System.Drawing.Color.White
        Me.btnReportes.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft
        Me.btnReportes.Location = New System.Drawing.Point(3, 398)
        Me.btnReportes.Name = "btnReportes"
        Me.btnReportes.Size = New System.Drawing.Size(217, 32)
        Me.btnReportes.TabIndex = 13
        Me.btnReportes.Text = "CALIFICACIONES"
        Me.btnReportes.UseVisualStyleBackColor = False
        '
        'panel6
        '
        Me.panel6.BackColor = System.Drawing.Color.Red
        Me.panel6.Location = New System.Drawing.Point(0, 360)
        Me.panel6.Name = "panel6"
        Me.panel6.Size = New System.Drawing.Size(5, 32)
        Me.panel6.TabIndex = 12
        '
        'button6
        '
        Me.button6.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.button6.FlatAppearance.BorderSize = 0
        Me.button6.FlatAppearance.MouseOverBackColor = System.Drawing.Color.FromArgb(CType(CType(0, Byte), Integer), CType(CType(80, Byte), Integer), CType(CType(200, Byte), Integer))
        Me.button6.FlatStyle = System.Windows.Forms.FlatStyle.Flat
        Me.button6.Font = New System.Drawing.Font("Century Gothic", 11.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.button6.ForeColor = System.Drawing.Color.White
        Me.button6.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft
        Me.button6.Location = New System.Drawing.Point(3, 360)
        Me.button6.Name = "button6"
        Me.button6.Size = New System.Drawing.Size(217, 32)
        Me.button6.TabIndex = 11
        Me.button6.Text = "JUSTIFICACIONES"
        Me.button6.UseVisualStyleBackColor = False
        '
        'panel5
        '
        Me.panel5.BackColor = System.Drawing.Color.Red
        Me.panel5.Location = New System.Drawing.Point(0, 322)
        Me.panel5.Name = "panel5"
        Me.panel5.Size = New System.Drawing.Size(5, 32)
        Me.panel5.TabIndex = 10
        '
        'Tripulacion
        '
        Me.Tripulacion.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.Tripulacion.FlatAppearance.BorderSize = 0
        Me.Tripulacion.FlatAppearance.MouseOverBackColor = System.Drawing.Color.FromArgb(CType(CType(0, Byte), Integer), CType(CType(80, Byte), Integer), CType(CType(200, Byte), Integer))
        Me.Tripulacion.FlatStyle = System.Windows.Forms.FlatStyle.Flat
        Me.Tripulacion.Font = New System.Drawing.Font("Century Gothic", 11.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Tripulacion.ForeColor = System.Drawing.Color.White
        Me.Tripulacion.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft
        Me.Tripulacion.Location = New System.Drawing.Point(3, 322)
        Me.Tripulacion.Name = "Tripulacion"
        Me.Tripulacion.Size = New System.Drawing.Size(217, 32)
        Me.Tripulacion.TabIndex = 9
        Me.Tripulacion.Text = "ASISTENCIAS"
        Me.Tripulacion.UseVisualStyleBackColor = False
        '
        'panel4
        '
        Me.panel4.BackColor = System.Drawing.Color.Red
        Me.panel4.Location = New System.Drawing.Point(0, 284)
        Me.panel4.Name = "panel4"
        Me.panel4.Size = New System.Drawing.Size(5, 32)
        Me.panel4.TabIndex = 8
        '
        'Aeronaves
        '
        Me.Aeronaves.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.Aeronaves.FlatAppearance.BorderSize = 0
        Me.Aeronaves.FlatAppearance.MouseOverBackColor = System.Drawing.Color.FromArgb(CType(CType(0, Byte), Integer), CType(CType(80, Byte), Integer), CType(CType(200, Byte), Integer))
        Me.Aeronaves.FlatStyle = System.Windows.Forms.FlatStyle.Flat
        Me.Aeronaves.Font = New System.Drawing.Font("Century Gothic", 11.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Aeronaves.ForeColor = System.Drawing.Color.White
        Me.Aeronaves.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft
        Me.Aeronaves.Location = New System.Drawing.Point(3, 284)
        Me.Aeronaves.Name = "Aeronaves"
        Me.Aeronaves.Size = New System.Drawing.Size(217, 32)
        Me.Aeronaves.TabIndex = 7
        Me.Aeronaves.Text = "FALTAS"
        Me.Aeronaves.UseVisualStyleBackColor = False
        '
        'panel3
        '
        Me.panel3.BackColor = System.Drawing.Color.Red
        Me.panel3.Location = New System.Drawing.Point(0, 246)
        Me.panel3.Name = "panel3"
        Me.panel3.Size = New System.Drawing.Size(5, 32)
        Me.panel3.TabIndex = 6
        '
        'Pasajeros
        '
        Me.Pasajeros.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.Pasajeros.FlatAppearance.BorderSize = 0
        Me.Pasajeros.FlatAppearance.MouseOverBackColor = System.Drawing.Color.FromArgb(CType(CType(0, Byte), Integer), CType(CType(80, Byte), Integer), CType(CType(200, Byte), Integer))
        Me.Pasajeros.FlatStyle = System.Windows.Forms.FlatStyle.Flat
        Me.Pasajeros.Font = New System.Drawing.Font("Century Gothic", 11.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Pasajeros.ForeColor = System.Drawing.Color.White
        Me.Pasajeros.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft
        Me.Pasajeros.Location = New System.Drawing.Point(3, 246)
        Me.Pasajeros.Name = "Pasajeros"
        Me.Pasajeros.Size = New System.Drawing.Size(217, 32)
        Me.Pasajeros.TabIndex = 5
        Me.Pasajeros.Text = "LISTAS"
        Me.Pasajeros.UseVisualStyleBackColor = False
        '
        'panel2
        '
        Me.panel2.BackColor = System.Drawing.Color.Red
        Me.panel2.Location = New System.Drawing.Point(0, 208)
        Me.panel2.Name = "panel2"
        Me.panel2.Size = New System.Drawing.Size(5, 32)
        Me.panel2.TabIndex = 4
        '
        'Compania
        '
        Me.Compania.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.Compania.FlatAppearance.BorderSize = 0
        Me.Compania.FlatAppearance.MouseOverBackColor = System.Drawing.Color.FromArgb(CType(CType(0, Byte), Integer), CType(CType(80, Byte), Integer), CType(CType(200, Byte), Integer))
        Me.Compania.FlatStyle = System.Windows.Forms.FlatStyle.Flat
        Me.Compania.Font = New System.Drawing.Font("Century Gothic", 11.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Compania.ForeColor = System.Drawing.Color.White
        Me.Compania.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft
        Me.Compania.Location = New System.Drawing.Point(3, 208)
        Me.Compania.Name = "Compania"
        Me.Compania.Size = New System.Drawing.Size(217, 32)
        Me.Compania.TabIndex = 3
        Me.Compania.Text = "DOCENTES"
        Me.Compania.UseVisualStyleBackColor = False
        '
        'panel1
        '
        Me.panel1.BackColor = System.Drawing.Color.Red
        Me.panel1.Location = New System.Drawing.Point(0, 170)
        Me.panel1.Name = "panel1"
        Me.panel1.Size = New System.Drawing.Size(5, 32)
        Me.panel1.TabIndex = 2
        '
        'materias
        '
        Me.materias.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.materias.FlatAppearance.BorderSize = 0
        Me.materias.FlatAppearance.MouseOverBackColor = System.Drawing.Color.FromArgb(CType(CType(0, Byte), Integer), CType(CType(80, Byte), Integer), CType(CType(200, Byte), Integer))
        Me.materias.FlatStyle = System.Windows.Forms.FlatStyle.Flat
        Me.materias.Font = New System.Drawing.Font("Century Gothic", 11.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.materias.ForeColor = System.Drawing.Color.White
        Me.materias.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft
        Me.materias.Location = New System.Drawing.Point(3, 170)
        Me.materias.Name = "materias"
        Me.materias.Size = New System.Drawing.Size(217, 32)
        Me.materias.TabIndex = 1
        Me.materias.Text = "MATERIAS"
        Me.materias.TextAlign = System.Drawing.ContentAlignment.BottomCenter
        Me.materias.UseVisualStyleBackColor = False
        '
        'Timer1
        '
        '
        'Contenedor
        '
        Me.Contenedor.BackgroundColor = System.Drawing.Color.DarkBlue
        Me.Contenedor.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize
        Me.Contenedor.GridColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Contenedor.Location = New System.Drawing.Point(6, 6)
        Me.Contenedor.Name = "Contenedor"
        Me.Contenedor.Size = New System.Drawing.Size(1062, 594)
        Me.Contenedor.TabIndex = 0
        '
        'panelContenedor
        '
        Me.panelContenedor.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.panelContenedor.Controls.Add(Me.Contenedor)
        Me.panelContenedor.Dock = System.Windows.Forms.DockStyle.Fill
        Me.panelContenedor.Location = New System.Drawing.Point(220, 40)
        Me.panelContenedor.Name = "panelContenedor"
        Me.panelContenedor.Size = New System.Drawing.Size(1080, 610)
        Me.panelContenedor.TabIndex = 28
        '
        'Principal
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(1300, 650)
        Me.Controls.Add(Me.panelContenedor)
        Me.Controls.Add(Me.MenuVertical)
        Me.Controls.Add(Me.titleBar)
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None
        Me.Name = "Principal"
        Me.Text = "Principal"
        Me.titleBar.ResumeLayout(False)
        CType(Me.btnminimizar, System.ComponentModel.ISupportInitialize).EndInit()
        Me.MenuVertical.ResumeLayout(False)
        CType(Me.PictureBox8, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox7, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox6, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox5, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox4, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox2, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.pictureBox3, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.btnsalir, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.Contenedor, System.ComponentModel.ISupportInitialize).EndInit()
        Me.panelContenedor.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

    Friend WithEvents titleBar As Panel
    Private WithEvents btnminimizar As PictureBox
    Private WithEvents MenuVertical As Panel
    Private WithEvents pictureBox3 As PictureBox
    Private WithEvents btnsalir As PictureBox
    Private WithEvents panel7 As Panel
    Private WithEvents btnReportes As Button
    Private WithEvents panel6 As Panel
    Private WithEvents button6 As Button
    Private WithEvents panel5 As Panel
    Private WithEvents Tripulacion As Button
    Private WithEvents panel4 As Panel
    Private WithEvents Aeronaves As Button
    Private WithEvents panel3 As Panel
    Private WithEvents Pasajeros As Button
    Private WithEvents panel2 As Panel
    Private WithEvents Compania As Button
    Private WithEvents panel1 As Panel
    Private WithEvents materias As Button
    Friend WithEvents Timer1 As Timer
    Friend WithEvents Timer2 As Timer
    Private WithEvents PictureBox1 As PictureBox
    Private WithEvents PictureBox2 As PictureBox
    Private WithEvents PictureBox4 As PictureBox
    Private WithEvents PictureBox7 As PictureBox
    Private WithEvents PictureBox6 As PictureBox
    Private WithEvents PictureBox5 As PictureBox
    Private WithEvents PictureBox8 As PictureBox
    Friend WithEvents Contenedor As DataGridView
    Private WithEvents panelContenedor As Panel
End Class
