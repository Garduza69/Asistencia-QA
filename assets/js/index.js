//Contador de códigos QR leídos
let contadorCodigos = 0;

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
    contadorCodigos++; // Incrementar el contador

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
      // Mostrar mensaje de éxito o de error utilizando SweetAlert2
      if (data.trim() === 'Registro de asistencia exitoso.') {
        Swal.fire({
          title: 'Éxito',
          text: data.trim(),
          icon: 'success',
          customClass: 'custom-swal',
          showCancelButton: true,
          confirmButtonText: 'Seguir leyendo códigos QR',
          cancelButtonText: 'cerrar clase',
          showCloseButton: true,
          footer: `<span>Códigos QR leídos: ${contadorCodigos}</span>`

        }).then((result) => {
          if (result.isConfirmed) {
            encenderCamara();
          } else {
            ejecutarFaltasPHP(); // Ejecutar faltas.php
          }
        });
      } else {
        Swal.fire('Error', data.trim(), 'error');
        Swal.fire({
          title: 'Error',
          text: data.trim(),
          icon: 'error',
          customClass: 'custom-swal',
          showCancelButton: true,
          confirmButtonText: 'Seguir leyendo códigos QR',
          cancelButtonText: 'Cerrar clase',
          showCloseButton: true,
          footer: `<span>Códigos QR leídos: ${contadorCodigos}</span>`

        }).then((result) => {
          if (result.isConfirmed) {
            encenderCamara();
          } else {
            ejecutarFaltasPHP(); // Ejecutar faltas.php
          }
        });
      }
    })
    .catch(error => {
      // Mostrar mensaje de error utilizando SweetAlert2
      Swal.fire('Error', 'No se pudo registrar la asistencia', 'error');
      // Capturar y mostrar cualquier error de red
      console.error('Error al realizar la solicitud:', error);
    });

}

// Función para ejecutar faltas.php
function ejecutarFaltasPHP() {
  fetch('faltas.php')
    .then(response => {
      if (!response.ok) {
        throw new Error('Error al ejecutar faltas.php');
      }
      // Redirigir a la página docente.html una vez que se complete la ejecución de faltas.php
      window.location.href = 'docente.html';
    })
    .catch(error => {
      console.error('Error al ejecutar faltas.php:', error);
    });
}

// Evento para mostrar la cámara sin el botón 
window.addEventListener('load', (e) => {
  encenderCamara();
});

// evento que evita que el navegador guarde el caché
window.addEventListener('pageshow', function(event) {
  window.history.pushState(null, null, document.URL);
});

//Evento que ejecuta la función de faltas cuando el usuario retrocede la página desde el navegador o con el botón del celular
window.addEventListener('popstate', function(event) {
  ejecutarFaltasPHP();
});






