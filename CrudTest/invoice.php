<?php
include 'config.php';
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$products = $data['products'];
$total = $data['total'];


// Definir user_id para las ventas (en este caso, el usuario 'normalUser')
$normalUserId = 1; // Suponiendo que el ID del usuario normal es 2, cámbialo según corresponda

// Iniciar transacción
$conn->beginTransaction();

try {
    // Crear factura
    $stmt = $conn->prepare("INSERT INTO invoices (user_id, total, invoice_date) VALUES (?, ?, NOW())");
    $stmt->execute([$normalUserId, $total]);
    $invoiceId = $conn->lastInsertId(); // Obtener el ID de la factura creada

    foreach ($products as $product) {
        // Insertar detalles de la factura
        $stmt = $conn->prepare("INSERT INTO invoice_details (invoice_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?)");
        $stmt->execute([$invoiceId, $product['id'], $product['quantity'], $product['price']]);

        // Actualizar el stock del producto
        $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $stmt->execute([$product['quantity'], $product['id']]);
    }

    // Confirmar transacción
    $conn->commit();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);

} catch (Exception $e) {
    // Revertir transacción en caso de error y enviar el mensaje exacto del error
    $conn->rollBack();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$data = json_decode(file_get_contents("php://input"), true);
var_dump($data); // Verificar datos recibidos

?>
