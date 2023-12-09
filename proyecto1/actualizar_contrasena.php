<?php
$servername = "localhost";
$username = "Proyecto";
$password = "Proyecto";
$dbname = "usuarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_GET['correo']; 
    $nueva_contrasena = $_POST['nueva_contrasena']; 
    $confirmar_contrasena = $_POST['confirmar_contrasena']; 
    if ($nueva_contrasena !== $confirmar_contrasena) {
        // Las contraseñas no coinciden
        echo '<script>alert("No coinciden las contraseñas ingresadas.");</script>';
        // Redirecciona a la página de cambiar contraseña con el correo en GET
        echo '<script>window.location.href = "cambiar_contrasena.php?correo=' . urlencode($correo) . '";</script>';
        exit();
    } elseif (strlen($nueva_contrasena) < 8) {
        // La contraseña es menor a 8 caracteres
        echo '<script>alert("La contraseña debe tener al menos 8 caracteres.");</script>';
        // Redirecciona a la página de cambiar contraseña con el correo en GET
        echo '<script>window.location.href = "cambiar_contrasena.php?correo=' . urlencode($correo) . '";</script>';
        exit();
    } else {
        // Contraseñas coinciden y tienen más de 8 caracteres, actualizar en la base de datos
        $hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

        $sql = "UPDATE usuarios SET contraseña = '$hashed_password' WHERE correo = '$correo'";
        $result = $conn->query($sql);

        if ($result) {
            // Contraseña actualizada exitosamente
            echo '<script>alert("Se ha cambiado la contraseña con éxito.");</script>';
            echo '<script>window.location.href = "loginUsuarios.html";</script>';
            exit();
        } else {
            // Error al cambiar la contraseña
            echo '<script>alert("Hubo un error al cambiar la contraseña.");</script>';
            // Redirecciona o maneja el error de alguna manera
        }
    }
}

$conn->close();
?>
