<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_champion_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nuestros Productos - Food Champion Truck</title>
  <link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.html">Food Champion Truck</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.html">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ubicacion.html">Dónde Encontrarnos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sobre_nosotros.html">Sobre Nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contactanos.html">Contactanos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="nuestros_productos.php">Nuestros Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="reseña.html">Reseñas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ver_carrito.php">Carrito</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Productos -->
  <div class="container mt-5">
    <h1>Nuestros Productos</h1>
    <div class="row">
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="col-md-4">
          <div class="card mb-4">
            <img src="<?php echo $row['imagen']; ?>" class="card-img-top" alt="<?php echo $row['nombre']; ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
              <p class="card-text"><?php echo $row['descripcion']; ?></p>
              <p class="card-text">Precio: $<?php echo $row['precio']; ?></p>
              <p class="card-text">Cantidad disponible: <?php echo $row['cantidad']; ?></p>
              <form action="carrito.php" method="post">
                <input type="hidden" name="producto_id" value="<?php echo $row['id']; ?>">
                <div class="form-group">
                  <label for="cantidad">Cantidad</label>
                  <input type="number" name="cantidad" class="form-control" min="1" max="<?php echo $row['cantidad']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Agregar al Carrito</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-light py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <p>&copy; 2024 Food Champion Truck. Todos los derechos reservados.</p>
          <p>Creadores: Juan Castro - Julio Muñoz - Bryan Piña</p>
        </div>
        <div class="col-md-6 text-end">
          <p>Síguenos en redes sociales:</p>
          <ul class="list-inline">
            <li class="list-inline-item"><a href="https://www.facebook.com"><img src="imagenes/facebook.png" alt="Facebook" style="width: 30px; height: 30px;"></a></li>
            <li class="list-inline-item"><a href="https://twitter.com"><img src="imagenes/twitter.png" alt="Twitter" style="width: 30px; height: 30px;"></a></li>
            <li class="list-inline-item"><a href="https://www.instagram.com"><img src="imagenes/instagram.png" alt="Instagram" style="width: 30px; height: 30px;"></a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>