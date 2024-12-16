<?php
header('Content-Type: application/json');
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Проверяем, существует ли email
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Email already registered"
        ]);
    } else {
        // Вставляем нового пользователя
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode([
                "status" => "success",
                "message" => "User registered successfully"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Registration failed"
            ]);
        }
    }

    $conn->close();
}
?>
