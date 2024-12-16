<?php
header('Content-Type: application/json');

// Подключение к базе данных
include 'db.php';

// Проверка на наличие входящих данных
$data = json_decode(file_get_contents('php://input'), true);

if (empty($data)) {
    echo json_encode(["status" => "error", "message" => "Empty order data"]);
    exit();
}

// Проход по всем товарам и добавление их в базу
$response = [];
foreach ($data as $product) {
    if (isset($product['id'], $product['brand'], $product['model'], $product['price'], $product['image'])) {
        $id = $product['id'];
        $brand = $product['brand'];
        $model = $product['model'];
        $price = $product['price'];
        $image = $product['image'];

        // SQL-запрос на добавление заказа
        $stmt = $conn->prepare("INSERT INTO orders (product_id, brand, model, price, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issds", $id, $brand, $model, $price, $image);
        if ($stmt->execute()) {
            $response[] = ["id" => $id, "status" => "success"];
        } else {
            $response[] = ["id" => $id, "status" => "error", "message" => $stmt->error];
        }
    } else {
        $response[] = ["status" => "error", "message" => "Invalid product data"];
    }
}

echo json_encode(["status" => "success", "orders" => $response]);
?>
