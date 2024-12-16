<?php
header('Content-Type: application/json');
include 'db.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    echo json_encode(["status" => "success", "data" => $products]);
} else {
    echo json_encode(["status" => "success", "data" => []]); // Если товаров нет, возвращаем пустой массив
}

$conn->close();
?>
