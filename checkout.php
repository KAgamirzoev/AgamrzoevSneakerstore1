<?php
include 'db_config.php'; // Подключение к базе данных

$user_id = $_POST['user_id'];

// Расчёт общей стоимости заказа
$total_query = $conn->prepare("SELECT SUM(p.price * c.quantity) AS total FROM cart_items c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$total_query->bind_param("i", $user_id);
$total_query->execute();
$total_result = $total_query->get_result();
$total_row = $total_result->fetch_assoc();
$total_price = $total_row['total'];

// Создание заказа
$order_insert = $conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
$order_insert->bind_param("id", $user_id, $total_price);
$order_insert->execute();
$order_id = $conn->insert_id;

// Перенос товаров из корзины в элементы заказа
$items_query = $conn->prepare("SELECT product_id, quantity FROM cart_items WHERE user_id = ?");
$items_query->bind_param("i", $user_id);
$items_query->execute();
$items_result = $items_query->get_result();

while ($row = $items_result->fetch_assoc()) {
    $insert_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) SELECT ?, product_id, quantity, price FROM products WHERE id = ?");
    $insert_item->bind_param("ii", $order_id, $row['product_id']);
    $insert_item->execute();
}

// Очистка корзины
$clear_cart = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
$clear_cart->bind_param("i", $user_id);
$clear_cart->execute();

echo json_encode(['status' => 'success', 'order_id' => $order_id]);
?>
