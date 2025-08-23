<?php
require_once('db_connect.php');
header('Access-Control-Allow-Origin: *');  // Разрешает запросы с любых источников (можно заменить на конкретный домен, например, http://127.0.0.1:5500)
header('Access-Control-Allow-Methods: POST');  // Разрешенные методы
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');
date_default_timezone_set('Europe/Moscow');

$response = ['status' => 'error', 'message' => 'Не удалось совершить заказ.'];
$data = json_decode(file_get_contents("php://input"), true);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$username = $data['username'];
$cart = $data['cart'];

$stmt = $conn->prepare("SELECT id_user FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id_user);  // Связываем результат запроса с переменной
$stmt->fetch(); // Извлекаем строку результата

//$id_user
$id_tc = $data['id_tc'];
$prods_name = "";
$prods_weight = 0;
$price = $data['price'];
$order_time = date('Y-m-d H:i:s'); // Текущее время в формате 'ГГГГ-ММ-ДД ЧЧ:ММ:СС'


// Проходим по массиву и добавляем имена продуктов в строку
foreach ($cart as $item) {
    $prods_name .= $item['name'] . ", ";  // Добавляем имя и запятую
    $prods_weight += $item["quantity"] * $item["weight"];
}
// Убираем последнюю запятую и пробел
$prods_name = rtrim($prods_name, ", ");

$stmt = $conn->prepare("INSERT INTO orders (id_user, id_tc, prods_name, prods_weight, price, order_time) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iisiis", $id_user, $id_tc, $prods_name, $prods_weight, $price, $order_time);
if($stmt->execute()){
    $response = ['status' => 'success', 'message' => 'Заказ успешно совершен.' . $order_time];
    $last_id_order = $conn->insert_id;
} else {
    $response = ['status' => 'error', 'message' => 'Ошибка добавления в orders.'];
}

foreach ($cart as $item) {
    $stmt = $conn->prepare("INSERT INTO order_items (id_order, id_product, amount) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $last_id_order, $item['id'], $item['quantity']);
    if($stmt->execute()){
        $response = ['status' => 'success', 'message' => 'Заказ успешно совершен.'];
    } else {
        $response = ['status' => 'error', 'message' => 'Ошибка добавления в order_items.'];
    }
}

echo json_encode($response);

$stmt->close();
$conn->close();
?>