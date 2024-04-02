//crea elemento
const video = document.createElement("video");

//nuestro camvas
const canvasElement = document.getElementById("qr-canvas");
const canvas = canvasElement.getContext("2d");

//div donde llegara nuestro canvas
const btnScanQR = document.getElementById("btn-scan-qr");

//lectura desactivada
let scanning = false;

//funcion para encender la camara
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

//funciones para levantar las funiones de encendido de la camara
function tick() {
  canvasElement.height = video.videoHeight;
  canvasElement.width = video.videoWidth;
  canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);

  scanning && requestAnimationFrame(tick);
}

function scan() {
  try {
    qrcode.decode();
  } catch (e) {
    setTimeout(scan, 300);
  }
}

//apagara la camara
const cerrarCamara = () => {
  video.srcObject.getTracks().forEach((track) => {
    track.stop();
  });
  canvasElement.hidden = true;
  btnScanQR.hidden = false;
};

const activarSonido = () => {
  var audio = document.getElementById('audioScaner');
  audio.play();
}

//callback cuando termina de leer el codigo QR
qrcode.callback = (token) => {
  if (token) {
    console.log(token);
    Swal.fire(token)
    activarSonido();
    //encenderCamara();    
    cerrarCamara();
    registrarAsistencia(token);    

  }
};

// Función para registrar la asistencia utilizando scan.php
function registrarAsistencia(token) {
  // Realizar solicitud fetch a scan.php
  fetch('scan.php?token=' + token)
    .then(response => {
      if (!response.ok) {
        throw new Error('Error al realizar la solicitud');
      }
      return response.text();
    })
    
    .then(data => {
      if (data === 'success') {
        // Redirigir a otra página en caso de éxito
      } else {
        // Mostrar mensaje de error utilizando SweetAlert2
        Swal.fire('Error', 'No se pudo registrar la asistencia', 'error');
      }
    })
    .catch(error => {
      // Capturar y mostrar cualquier error de red
      console.error('Error al realizar la solicitud:', error);
    });
    console.log("Este es el token: "+token);
}

//evento para mostrar la camara sin el boton 
window.addEventListener('load', (e) => {
  encenderCamara();
})






