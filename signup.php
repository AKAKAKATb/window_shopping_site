<?php
require_once('db_connect.php');
header('Access-Control-Allow-Origin: *');  // Разрешает запросы с любых источников (можно заменить на конкретный домен, например, http://127.0.0.1:5500)
header('Access-Control-Allow-Methods: POST');  // Разрешенные методы
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');  // Указываем, что ответ в формате JSON


$data = json_decode(file_get_contents("php://input"));

$new_username = $data->new_username;
$new_password = password_hash($data->new_password, PASSWORD_BCRYPT);  // Хэшируем пароль
$new_full_name = $data->new_full_name;
$new_rh = $data->new_rh;


$stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
$stmt->bind_param("s", $new_username);  // Привязка параметра: 's' означает строку
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
   echo json_encode(['status' => 'error', 'message' => 'Пользователь с таким логином уже существует']);
   $stmt->close();
   $conn->close();
   exit;
}

$stmt = $conn->prepare("INSERT INTO users (username, password, full_name, rh_factor) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $new_username, $new_password, $new_full_name, $new_rh);  // Привязка параметров

if ($stmt->execute()) {
   setcookie('username', $new_username, time() + 604800, '/');
   setcookie('password', $new_password, time() + 604800, '/');
   echo json_encode(['status' => 'success', 'message' => 'Пользователь успешно зарегистрирован']);
} else {
   echo json_encode(['status' => 'error', 'message' => 'Ошибка при добавлении пользователя: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>