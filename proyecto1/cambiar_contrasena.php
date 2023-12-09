<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['correo'])) {
    $correo = $_GET['correo']; 
} else {
    // Si el correo no está presente, redirige a la página de olvido de contraseña
    header("Location: olvido_contrasena.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña - ClinicaASuAlcance</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <section class="container mt-5">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <form action="actualizar_contrasena.php?correo=<?php echo urlencode($correo); ?>" method="POST">
                    <div class="mb-3">
                        <label for="nueva_contrasena" class="form-label">Nueva contraseña:</label>
                        <input type="password" id="nueva_contrasena" name="nueva_contrasena" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmar_contrasena" class="form-label">Confirmar nueva contraseña:</label>
                        <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
                </form>
            </div>
        </div>
    </section>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
