<?php
include("config.php");
session_start();

if (!isset($_SESSION['usuario']) && !isset($_SESSION['correo'])) {
  header('Location: loginUsuarios.html');
  exit;
}

$conn = new mysqli($servidor, $usuario, $contrasena, $base_de_datos, $puerto);

if ($conn->connect_error) {
  die("Error de conexion");
}

$citaId = isset($_GET['fila_id']) ? $_GET['fila_id'] : '';

if ($citaId == '') {

  header("Location: adminCitas.php");
  exit;
} else {
  $sql = "SELECT * FROM citas WHERE id = $citaId";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $cita = $result->fetch_assoc();
  } else {
    header("Location: adminCitas.php");
    exit;
  }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Citas </title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
  <script src=""></script>
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
            <a class="nav-link" href="ReservaCitas.php">Ver registro Citas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contactenos.html">Contacto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cerrar_sesion.php">Cerrar sesion</a>
          </li>
        </div>
      </div>
    </div>
  </nav>
  <section>
    <div class="container my-5">
      <div class="row">
        <div class="admin-usuarios">
          <h1>Administración de citas</h1>
          <div>
            <button onclick="location.href='ReservaCitas.php'">Volver </button>
          </div>
        </div>
        <div class="col-lg-10 offset-lg-1">
          <h3 class="my-3">Modificar Cita</h3>
          <form id="appointmentForm" method="POST" action="editar_cita.php">
            <input value="<?php echo $cita['id']; ?>" type="hidden" id="cita_id" name="cita_id">

            <div class="mb-3">
              <label for="fullName" class="form-label">Nombre Completo</label>
              <input value="<?php echo $cita['nombre_completo']; ?>" type="text" id="fullName" name="nombre_completo" class="form-control" placeholder="Ingrese su nombre completo" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Correo Electrónico</label>
              <input value="<?php echo $cita['correo_electronico']; ?>" type="email" id="email" name="correo_electronico" class="form-control" placeholder="Ingrese su correo electrónico" required>
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">Número de Teléfono</label>
              <input value="<?php echo $cita['numero_telefono']; ?>" type="tel" id="phone" name="numero_telefono" class="form-control" placeholder="Ingrese su número de teléfono" required>
            </div>
            <div class="mb-3">
              <label for="specialty" class="form-label">Especialidad Médica</label>
              <select id="specialty" name="especialidad_medica" class="form-select" required>
                <option value="cardiology" <?php echo $cita['especialidad_medica'] == 'cardiology' ? 'selected' : ''; ?>>Cardiología</option>
                <option value="dermatology" <?php echo $cita['especialidad_medica'] == 'dermatology' ? 'selected' : ''; ?>>Dermatología</option>
                <option value="orthopedics" <?php echo $cita['especialidad_medica'] == 'orthopedics' ? 'selected' : ''; ?>>Ortopedia</option>
                <option value="neurology" <?php echo $cita['especialidad_medica'] == 'neurology' ? 'selected' : ''; ?>>Neurología</option>
                <option value="gastroenterology" <?php echo $cita['especialidad_medica'] == 'gastroenterology' ? 'selected' : ''; ?>>Gastroenterología</option>
              </select>
            </div>
            <?php echo $cita['especialidad_medica']; ?>
            <div class="mb-3">
              <label for="preferredDate" class="form-label">Fecha Preferida</label>
              <input value="<?php echo $cita['fecha_preferida']; ?>" type="date" id="preferredDate" name="fecha_preferida" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="preferredTime" class="form-label">Hora Preferida</label>
              <input value="<?php echo $cita['hora_preferida']; ?>" type="time" id="preferredTime" name="hora_preferida" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Modificar Cita</button>
          </form>
          <div class="alert alert-success mt-3" role="alert" style="display:none;">
            ¡La cita se ha modificado con éxito!
          </div>
        </div>

      </div>
    </div>

    </div>
  </section>

  <footer>
    <p>&copy; 2023 Citas Médicas</p>
  </footer>
</body>

</html>