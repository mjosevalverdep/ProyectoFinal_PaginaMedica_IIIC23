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

  // Insertar usuario en la base de datos
  $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, correo = ?, usuario = ? WHERE id = ?");
  $stmt->bind_param("ssssi", $nombre, $apellido, $correo, $usuario, $_POST['id']);

  if ($stmt->execute()) {
    // Registro exitoso
    $mensaje = "¡Registro exitoso!";
    // Redireccionamiento a adminUsuarios.php después de 0 segundos
    header("refresh:0;url=adminUsuarios.php");
  } else {
    // Error en el registro
    $mensaje = "Error en el registro: " . $stmt->error;
  }
  $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Editar Usuarios </title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>

</head>


<body>
<nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand mt-2 mt-lg-0" href="index.html">
                <img src="images/logo.png" height="100" alt="Logo ClinicaASA" loading="lazy" />
            </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="citas.html">Agendar citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ReservaCitas.html">Ver registro Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contactenos.html">Contacto</a>
                </li>
            </ul>
            </div>
          </div>
        </div>
      </nav>
      <br>

<!-- ... (otras partes del código) ... -->

<div id="contenido">
<?php
    $sql = "SELECT * FROM usuarios WHERE id = " . $_GET['fila_id'];
    $result = $conn->query($sql);
    $sql = "SELECT * FROM usuarios WHERE id = " . $_GET['fila_id'];
    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
      while ($row = $result->fetch_assoc()) {
    ?>   
    <div class="login-page bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <h3 class="mb-3">Editar de Usuarios</h3>
                        <div>
                        <button onclick="location.href='adminUsuarios.php'">Volver</button>
      </div>
    </div>
    <div class="bg-white shadow rounded">
                            <div class="row">
                                

                                    <div class="form-left h-100 py-5 px-5">
                                        
            <form method="post" action="adminEditarUsuario.php" class="row g-4">  
              <input type="hidden" id="id" name="id" required value="<?php echo $row['id']; ?>">                                      
              <div class="col-12">
                <div class="input-group">
                <label for="apellido">Nombre:</label> 
                <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                  <input type="text" id="nombre" name="nombre" required value="<?php echo $row['nombre']; ?>">
                  
                </div>
              </div>

              <div class="col-12">
                <div class="input-group">
                <label for="apellido">Apellido:</label> 
                  <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                  <input type="text" id="apellido" name="apellido" required value="<?php echo $row['apellido']; ?>">
                </div>
              </div>
              <div class="col-12">
                <div class="input-group">
                <label for="apellido">Correo electronico:</label> 
                  <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>                  
                  <input type="email" id="correo-registro" name="correo-registro" required value="<?php echo $row['correo']; ?>">
                </div>
              </div>
              <div class="col-12">
                <div class="input-group">
                <label for="apellido"> Nombre de usaurio:</label> 
                  <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                  <input type="text" id="usuario-registro" name="usuario-registro" required value="<?php echo $row['usuario']; ?>">
                </div>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary px-4 float-end mt-4">Editar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</body>

</html>
