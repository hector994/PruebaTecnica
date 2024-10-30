<?php
include 'config.php';
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

// Leer registros
if ($action === 'read') {
    $search = $_GET['search'] ?? '';
    $sql = "SELECT * FROM products WHERE product_name LIKE ? OR id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['%' . $search . '%', $search]);
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
    exit();
}

// Crear registro
if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $product = $data['product'];
    $price = $data['price'];
    $stock = $data['stock'];

    $sql = "INSERT INTO products (product_name, price, stock) VALUES ('$product', '$price', $stock)";
    $conn->query($sql);
    echo json_encode(['status' => 'success']);
    exit();
}

// Actualizar registro
if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = json_decode(file_get_contents('php://input'), true);
    $product_name = $data['product_name'];
    $price = $data['price'];
    $stock = $data['stock'];

    // Usar prepared statement para actualizar el producto
    $stmt = $conn->prepare("UPDATE products SET product_name = ?, price = ?, stock = ? WHERE id = ?");
    $stmt->execute([$product_name, $price, $stock, $id]);

    echo json_encode(['status' => 'success']);
    exit();
}
// Eliminar registro
if ($action === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM products WHERE id=$id";
    $conn->query($sql);
    echo json_encode(['status' => 'success']);
    exit();
}


?>
