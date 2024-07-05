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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    $sql = "SELECT * FROM productos WHERE id = $producto_id";
    $result = $conn->query($sql);
    $producto = $result->fetch_assoc();

    if ($producto && $producto['cantidad'] >= $cantidad) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        $item = [
            'id' => $producto['id'],
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'cantidad' => $cantidad,
            'total' => $producto['precio'] * $cantidad
        ];

        $_SESSION['carrito'][] = $item;
    }
}

header('Location: ver_carrito.php');
?>

<?php
$conn->close();
?>
