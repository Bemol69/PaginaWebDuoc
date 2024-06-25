<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_champion_truck";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar pedido
    foreach ($_SESSION['carrito'] as $item) {
        $producto_id = $item['id'];
        $cantidad = $item['cantidad'];

        // Actualizar la cantidad en la base de datos
        $sql = "UPDATE productos SET cantidad = cantidad - $cantidad WHERE id = $producto_id";
        $conn->query($sql);
    }

    // Vaciar el carrito
    $_SESSION['carrito'] = [];

    echo "Pedido realizado con éxito.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - Food Champion Truck</title>
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

    <!-- Carrito de Compras -->
    <div class="container mt-5">
        <h1>Carrito de Compras</h1>
        <div class="bg-white p-4 rounded shadow-sm">
            <?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($_SESSION['carrito'] as $item): ?>
                            <tr>
                                <td><?php echo $item['nombre']; ?></td>
                                <td><?php echo $item['cantidad']; ?></td>
                                <td>$<?php echo number_format($item['precio'], 2); ?></td>
                                <td>$<?php echo number_format($item['cantidad'] * $item['precio'], 2); ?></td>
                            </tr>
                            <?php $total += $item['cantidad'] * $item['precio']; ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th>$<?php echo number_format($total, 2); ?></th>
                        </tr>
                    </tfoot>
                </table>
                <form action="ver_carrito.php" method="post">
                    <button type="submit" class="btn btn-success">Realizar Pedido</button>
                </form>
            <?php else: ?>
                <p>No hay productos en el carrito.</p>
            <?php endif; ?>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
