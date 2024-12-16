<?php
header('Content-Type: application/json');
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $new_price = $_POST['new_price'];

    $sql = "UPDATE products SET price = '$new_price' WHERE id = '$product_id'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Price updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
