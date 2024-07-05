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

$error_message = "";
$success_message = "";
$informe_compra = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['remove_item'])) {
        $index = $_POST['remove_item'];
        if (isset($_SESSION['carrito'][$index])) {
            unset($_SESSION['carrito'][$index]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar el array
        }
        header("Location: ver_carrito.php");
        exit;
    } elseif (isset($_POST['realizar_pedido'])) {
        // Validar formulario
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $metodo_pago = $_POST['metodo_pago'];

        if (empty($nombre) || empty($direccion) || empty($telefono) || empty($metodo_pago)) {
            $error_message = "Por favor, complete todos los campos del formulario.";
        } elseif (!preg_match("/^\+56\s?9\s?\d{4}\s?\d{4}$/", $telefono)) {
            $error_message = "El número de teléfono debe tener el formato chileno: +56 9 XXXX XXXX";
        } else {
            // Procesar pedido
            $total = 0;
            $detalles = "";
            foreach ($_SESSION['carrito'] as $item) {
                $producto_id = $item['id'];
                $cantidad = $item['cantidad'];
                $subtotal = $item['cantidad'] * $item['precio'];
                $total += $subtotal;

                // Actualizar la cantidad en la base de datos
                $sql = "UPDATE productos SET cantidad = cantidad - $cantidad WHERE id = $producto_id";
                $conn->query($sql);

                $detalles .= "{$item['nombre']} x {$cantidad} - $" . number_format($subtotal, 2) . "\n";
            }

            // Insertar informe de compra en la base de datos
            $fecha_hora = date("Y-m-d H:i:s");
            $sql = "INSERT INTO informes_compra (nombre, direccion, telefono, metodo_pago, total, fecha_hora, detalles) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssdss", $nombre, $direccion, $telefono, $metodo_pago, $total, $fecha_hora, $detalles);
            $stmt->execute();

            // Generar informe de compra
            $informe_compra = "
                <h2>Informe de Compra</h2>
                <p><strong>Fecha y hora:</strong> {$fecha_hora}</p>
                <p><strong>Nombre:</strong> {$nombre}</p>
                <p><strong>Dirección:</strong> {$direccion}</p>
                <p><strong>Teléfono:</strong> {$telefono}</p>
                <p><strong>Método de pago:</strong> {$metodo_pago}</p>
                <h3>Detalles de la compra:</h3>
                <pre>{$detalles}</pre>
                <p><strong>Total:</strong> $" . number_format($total, 2) . "</p>
            ";

            // Vaciar el carrito
            $_SESSION['carrito'] = [];

            // Guardar el mensaje de éxito e informe en la sesión
            $_SESSION['success_message'] = "Pedido realizado con éxito.";
            $_SESSION['informe_compra'] = $informe_compra;

            // Redirigir para evitar reenvío del formulario
            header("Location: ver_carrito.php?pedido_realizado=1");
            exit();
        }
    }
}

// Recuperar mensajes de la sesión
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : "";
$informe_compra = isset($_SESSION['informe_compra']) ? $_SESSION['informe_compra'] : "";

// Limpiar los mensajes de la sesión después de usarlos
unset($_SESSION['success_message']);
unset($_SESSION['informe_compra']);
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
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($_SESSION['carrito'] as $index => $item): ?>
                            <tr>
                                <td><?php echo $item['nombre']; ?></td>
                                <td><?php echo $item['cantidad']; ?></td>
                                <td>$<?php echo number_format($item['precio'], 2); ?></td>
                                <td>$<?php echo number_format($item['cantidad'] * $item['precio'], 2); ?></td>
                                <td>
                                    <form action="ver_carrito.php" method="post">
                                        <input type="hidden" name="remove_item" value="<?php echo $index; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">X</button>
                                    </form>
                                </td>
                            </tr>
                            <?php $total += $item['cantidad'] * $item['precio']; ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th>$<?php echo number_format($total, 2); ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>

                <h2 class="mt-4">Información de envío</h2>
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <form action="ver_carrito.php" method="post" id="formulario-compra">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono (formato: +56 9 XXXX XXXX)</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" pattern="\+56\s?9\s?\d{4}\s?\d{4}" required>
                    </div>
                    <div class="mb-3">
                        <label for="metodo_pago" class="form-label">Método de pago</label>
                        <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                            <option value="">Seleccione un método de pago</option>
                            <option value="Mercadopago">Mercadopago</option>
                            <option value="MACH">MACH</option>
                            <option value="Fpay">Fpay</option>
                            <option value="Flow">Flow</option>
                        </select>
                    </div>
                    <button type="submit" name="realizar_pedido" class="btn btn-success">Realizar Pedido</button>
                </form>
            <?php else: ?>
                <p>No hay productos en el carrito.</p>
            <?php endif; ?>
        </div>

        <?php if (!empty($success_message) || isset($_GET['pedido_realizado'])): ?>
            <div class="mt-4 alert alert-success">
                <h4 class="alert-heading">¡Compra realizada con éxito!</h4>
                <p><?php echo $success_message; ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($informe_compra)): ?>
            <div class="mt-5 bg-white p-4 rounded shadow-sm">
                <?php echo $informe_compra; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>