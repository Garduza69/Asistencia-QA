// Crea un elemento video para mostrar la cámara
const video = document.createElement("video");

// Nuestro canvas
const canvasElement = document.getElementById("qr-canvas");
const canvas = canvasElement.getContext("2d");

// Div donde llegará nuestro canvas
const btnScanQR = document.getElementById("btn-scan-qr");

// Lectura desactivada
let scanning = false;

// Función para encender la cámara y escanear el código QR
const encenderCamara = () => {
  navigator.mediaDevices
    .getUserMedia({ video: { facingMode: "environment" } })
    .then(function (stream) {
      scanning = true;
      btnScanQR.hidden = true;
      canvasElement.hidden = false;
      video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
      video.srcObject = stream;
      video.play();
      tick();
      scan();
    });
};

// Función para apagar la cámara
const cerrarCamara = () => {
  video.srcObject.getTracks().forEach((track) => {
    track.stop();
  });
  canvasElement.hidden = true;
  btnScanQR.hidden = false;
};

// Función para procesar el escaneo del código QR
function tick() {
  canvasElement.height = video.videoHeight;
  canvasElement.width = video.videoWidth;
  canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);

  scanning && requestAnimationFrame(tick);
}

// Función para realizar el escaneo del código QR
function scan() {
  try {
    qrcode.decode();
  } catch (e) {
    setTimeout(scan, 300);
  }
}

// Callback cuando se lee el código QR
qrcode.callback = (token) => {
  if (respuesta) {
    registrarAsistencia(token); // Llama a la función para registrar la asistencia
  }
};

// Función para registrar la asistencia utilizando scan.php
function registrarAsistencia(token) {
  // Realizar solicitud AJAX a scan.php
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'scan.php?token=' + token, true);
  xhr.onload = function() {
    if (xhr.status === 200) {
      // La solicitud se completó correctamente
      var response = xhr.responseText;
      if (response === 'success') {
        // Mostrar mensaje de éxito utilizando SweetAlert2
        Swal.fire('Registro de asistencia exitoso');
      } else {
        // Mostrar mensaje de error utilizando SweetAlert2
        Swal.fire('Error', 'No se pudo registrar la asistencia', 'error');
      }
    } else {
      // La solicitud falló
      console.error('Error al realizar la solicitud');
    }
  };
  xhr.send();
}

// Evento para mostrar la cámara sin el botón 
window.addEventListener('load', (e) => {
  encenderCamara();
});






