<?php
include 'db_config.php'; // Подключение к базе данных

$user_id = $_POST['user_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

// Проверка наличия товара в корзине
$check = $conn->prepare("SELECT * FROM cart_items WHERE user_id = ? AND product_id = ?");
$check->bind_param("ii", $user_id, $product_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    // Увеличение количества
    $update = $conn->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
    $update->bind_param("iii", $quantity, $user_id, $product_id);
    $update->execute();
} else {
    // Добавление нового товара в корзину
    $insert = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $insert->bind_param("iii", $user_id, $product_id, $quantity);
    $insert->execute();
}

echo json_encode(['status' => 'success']);
?>
