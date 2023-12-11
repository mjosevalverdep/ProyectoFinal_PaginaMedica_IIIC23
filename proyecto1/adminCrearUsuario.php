<?php
include("config.php");


$conn = new mysqli($servidor, $usuario, $contrasena, $base_de_datos, $puerto);

if ($conn->connect_error) {
    die("Error de conexion");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitización y validación de datos
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conn, $_POST['apellido']);
    $correo = filter_var($_POST['correo-registro'], FILTER_SANITIZE_EMAIL);
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario-registro']);
    $contrasena = $_POST['contrasena-registro']; // Aquí la contraseña no es sanada porque se usará password_hash

    // Verifica si la contraseña cumple con ciertos criterios (ejemplo: al menos 8 caracteres)
    if (strlen($contrasena) < 8) {
        die("La contraseña debe tener al menos 8 caracteres.");
    }

    // Hashing de la contraseña
    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, correo, usuario, contraseña) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $apellido, $correo, $usuario, $contrasenaHash);

    if ($stmt->execute()) {
        // Registro exitoso
        $mensaje = "¡Registro exitoso!";
        // Redireccionamiento a adminUsuarios.php después de 3 segundos
        header("refresh:3;url=adminUsuarios.php");
    } else {
        // Error en el registro
        $mensaje = "Error en el registro: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Crear usaurios </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/script.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

</head>


<body>
    <header>
        <nav>
            <div class="logo">
                <img src="images/logo.png" alt="ClinicaASA">
            </div>
            <ul class="menu">
                <nav>
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="citas.html">Agendar Citas</a></li>
                    <li><a href="ReservaCitas.php">Ver registro Citas</a></li>
                    <li><a href="loginUsuarios.html">Mi Cuenta</a></li>
                    <li><a href="contactenos.html">Contacto</a></li>
            </ul>
        </nav>
        </nav>
    </header>

    <section>
        <div class="login-page bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 d-flex">
                        <h3 class="mb-3">Registrar de Usuarios</h3>
                        <div>
                            <button onclick="location.href='adminUsuarios.php'">Volver</button>
                        </div>
                    </div>
                    <div class="bg-white shadow rounded">
                        <div class="row">
                            <div class="form-left h-100 py-5 px-5">
                                <form action="adminCrearUsuario.php" method="post" class="row g-4">
                                    <div class="col-12">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese su nombre" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                            <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Ingrese su apellido" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                            <input type="text" id="correo-registro" name="correo-registro" class="form-control" placeholder="Correo electronico" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="bi bi-person-fill"></i>
                                            </div>
                                            <input type="text" id="usuario-registro" name="usuario-registro" class="form-control" placeholder="Ingrese Username" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                            <input type="password" id="contrasena-registro" name="contrasena-registro" class="form-control" placeholder="Ingrese contraseña" required>
                                        </div>
                                    </div>
                                    <div class="col-12">

                                        <button type="submit" class="btn btn-primary px-4 float-end mt-4">Registrar</button>
                                    </div>
                                </form>
                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </section>

</body>

</html>