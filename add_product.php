<?php
header('Content-Type: application/json');
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $sql = "INSERT INTO products (brand, model, price, image) VALUES ('$brand', '$model', '$price', '$image')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Product added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
