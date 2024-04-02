window.onload = function() {
    // Obtener el correo electrónico de la sesión y llenar el campo de entrada oculto
    var email = "<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>";
    document.getElementById('email').value = email;
};

