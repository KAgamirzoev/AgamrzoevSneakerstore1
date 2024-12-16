<?php
header('Content-Type: application/json');
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Проверяем, существует ли пользователь
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Успешный вход
            echo json_encode([
                "status" => "success",
                "message" => "Login successful",
                "username" => $row['username'], // Добавляем имя пользователя
                "email" => $row['email']       // Добавляем email
            ]);
        } else {
            // Неверный пароль
            echo json_encode([
                "status" => "error",
                "message" => "Invalid password"
            ]);
        }
    } else {
        // Пользователь не найден
        echo json_encode([
            "status" => "error",
            "message" => "User not found"
        ]);
    }
    $conn->close();
}
?>
