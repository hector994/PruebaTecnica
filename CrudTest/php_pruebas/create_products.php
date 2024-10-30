<?php
include 'config.php'; // Asegúrate de que la ruta sea correcta

try {
    // Productos de prueba
    $products = [
        ['name' => 'Producto A', 'price' => 10.50, 'stock' => 100],
        ['name' => 'Producto B', 'price' => 15.75, 'stock' => 50],
        ['name' => 'Producto C', 'price' => 7.25, 'stock' => 200],
        ['name' => 'Producto D', 'price' => 22.00, 'stock' => 30],
        ['name' => 'Producto E', 'price' => 18.00, 'stock' => 70],
    ];

    // Usar prepared statement para insertar productos
    $stmt = $conn->prepare("INSERT INTO products (product_name, price, stock) VALUES (?, ?, ?)");

    // Insertar cada producto
    foreach ($products as $product) {
        $stmt->execute([$product['name'], $product['price'], $product['stock']]);
    }

    echo "Productos creados con éxito.";
} catch (PDOException $e) {
    echo "Error al crear productos: " . $e->getMessage();
}
?>
