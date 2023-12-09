<?php
session_start();

// Elimina todas las variables de sesión
$_SESSION = array();

// Destruye la sesión
session_destroy();

// Mensaje para mostrar en el popup
echo '<script>alert("Se ha cerrado la sesión");</script>';

// Redirecciona a la página de inicio de sesión después del mensaje emergente
echo '<script>window.location.href = "loginUsuarios.html";</script>';
exit();
?>

