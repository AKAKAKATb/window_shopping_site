<?php
require_once('db_connect.php');
header('Access-Control-Allow-Origin: *');  // Разрешает запросы с любых источников (можно заменить на конкретный домен, например, http://127.0.0.1:5500)
header('Access-Control-Allow-Methods: POST');  // Разрешенные методы
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"));

$username = $data->username;
$start = $data->start;
$end = $data->end;

if($start == ''){
    $start = '1900-01-01 01:01:01';
} 
if ($end == ''){
    $end = date(format: 'Y-m-d H:i:s');
}


$stmt = $conn->prepare("SELECT id_user FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($id_user);  // Связываем результат запроса с переменной
$stmt->fetch(); // Извлекаем строку результата
$stmt->close();

// Подготовка и выполнение запроса
$stmt = $conn->prepare("SELECT id_order, prods_weight, price, order_time FROM orders WHERE id_user = ? AND order_time > ? AND order_time < ? ");
$stmt->bind_param("iss", $id_user, $start, $end); // связываем параметр с переменной
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// Массив для хранения результатов
$orders = [];

while ($row = $result->fetch_assoc()) {

    $stmt = $conn->prepare(
        "SELECT products.prod_name, amount 
        FROM order_items JOIN products 
        ON order_items.id_product=products.id_product AND order_items.id_order = ?");
    $stmt->bind_param("i", $row['id_order']);
    $stmt->execute();
    $stmt->bind_result($product_name, $product_quantity);

    $product_list = [];

    while ($stmt->fetch()) {
        // Формируем строку вида 'product name' x 'product quantity'
        $product_list[] =   $product_name . " x " . $product_quantity ;
    }

    $stmt->close();

    // Преобразуем массив в строку с разделением через " | "
    $product_string = implode(" | ", $product_list);

    $stmt = $conn->prepare(
        "SELECT tr_companies.tc_name 
        FROM orders JOIN tr_companies 
        ON orders.id_tc = tr_companies.id_tc AND id_order = ?");
    $stmt->bind_param("i", $row['id_order']);
    $stmt->execute();
    $stmt->bind_result($tc_name);  // Связываем результат запроса с переменной
    $stmt->fetch(); // Извлекаем строку результата
    $stmt->close();

    $orders[] = [
        'order_id' => $row['id_order'],
        'prods_name' => $product_string,
        'tc_name' => $tc_name,
        'prods_weight' => $row['prods_weight'],
        'price' => $row['price'],
        'order_time' => $row['order_time']
    ];
}

echo json_encode($orders);


$conn->close();
?>