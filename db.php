<?php
$servername = "localhost";
$username = "root"; // Стандартный пользователь для XAMPP
$password = ""; // Пустой пароль
$dbname = "sneakerstore"; // Новое название базы данных

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
