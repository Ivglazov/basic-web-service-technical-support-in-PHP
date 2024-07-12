<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "help";

// Соединение с базой данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
  die("Ошибка соединения: " . $conn->connect_error);
}
?>