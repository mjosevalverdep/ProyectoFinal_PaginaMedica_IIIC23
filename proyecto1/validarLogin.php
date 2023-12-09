<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $servername = "localhost";
    $username = "Proyecto";
    $password = "Proyecto";
    $dbname = "usuarios";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        $usuarioRegistrado = $stmt->fetch();

        if ($usuarioRegistrado && password_verify($contrasena, $usuarioRegistrado['contraseña'])) {
            $_SESSION['usuario'] = $usuarioRegistrado['usuario'];
            echo '<script>alert("¡Bienvenid@! Registro Exitoso");</script>';
            echo '<script>window.location.href = "index.html";</script>';
            exit();
        } else {
            // Usuario o contraseña incorrectos
            echo '<script>alert("Usuario o contraseña incorrectos");</script>';
            // Redirecciona de nuevo al formulario de inicio de sesión
            echo '<script>window.location.href = "loginUsuarios.html";</script>';
            exit();
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>
