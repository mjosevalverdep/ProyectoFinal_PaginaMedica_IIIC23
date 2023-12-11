<?php
include "config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_usuario = $_POST['usuario'];
    $login_contrasena = $_POST['contrasena'];

    try {
        $conn = new PDO("mysql:host=$servidor;port=$puerto;dbname=$base_de_datos", $usuario, $contrasena);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
        $stmt->bindParam(':usuario', $login_usuario);
        $stmt->execute();

        $usuarioRegistrado = $stmt->fetch();

        if ($usuarioRegistrado && password_verify($login_contrasena, $usuarioRegistrado['contraseña'])) {
            $_SESSION['usuario'] = $usuarioRegistrado['usuario'];
            $_SESSION['correo'] = $usuarioRegistrado['correo'];
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
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
