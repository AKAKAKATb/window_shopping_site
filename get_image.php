<?php
require_once('db_connect.php');
header('Access-Control-Allow-Origin: *');  // Разрешает запросы с любых источников (можно заменить на конкретный домен, например, http://127.0.0.1:5500)
header('Access-Control-Allow-Methods: GET');  // Разрешенные методы
header('Access-Control-Allow-Headers: Content-Type');

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$id_image = $_GET['id_image'];

$stmt = $conn->prepare("SELECT image FROM shipment_report WHERE id_image = ?");
$stmt->bind_param("i", $id_image);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($image);

// Проверяем, существует ли изображение с таким id
if ($stmt->num_rows == 1) {
    $stmt->fetch();

    // Заголовки для отправки изображения
    header("Content-Type: image/jpeg"); // или другой тип в зависимости от формата (например, image/png, image/gif)
    header("Content-Disposition: inline; filename=\"$id_image\"");

    // Отправляем изображение клиенту
    echo $image;
} else {
    echo "Изображение не найдено!";
}

$stmt->close();
$conn->close();
?>