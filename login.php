<?php
require_once('db_connect.php');
header('Access-Control-Allow-Origin: *');  // Разрешает запросы с любых источников (можно заменить на конкретный домен, например, http://127.0.0.1:5500)
header('Access-Control-Allow-Methods: POST');  // Разрешенные методы
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');


$response = ['status' => 'error', 'message' => 'Неверный логин или пароль!'];
$data = json_decode(file_get_contents("php://input"));

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$username = $data->username;
$password = $data->password;  // Хэшируем пароль

if (empty($username) || empty($password)) {
    $response = ['status' => 'error', 'message' => 'Пустые данные при входе в аккаунт.'];

} else{
    // Проверка пользователя в базе данных (простейший пример)
    $stmt = $conn->prepare("SELECT id_user, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Если пользователь найден, проверяем пароль
        $stmt->bind_result($id_user, $username, $stored_hash);
        $stmt->fetch();

        // Проверка пароля
        if (password_verify($password, $stored_hash)) {
            // Успешный вход, можно установить сессию
            setcookie('username', $username, time() + 604800, '/');
            setcookie('password', $password, time() + 604800, '/');
            $response = ['status' => 'success', 'message' => 'Добро пожаловать, ' . $id_user . '.'];
        }
    }
}
echo json_encode($response);

$stmt->close();
$conn->close();
?>