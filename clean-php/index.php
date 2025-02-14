<?php
require_once __DIR__ . '/src/users.php';

header("Content-Type: application/json");
$method = $_SERVER['REQUEST_METHOD'];
$path = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

if ($path[0] === 'users') {
    switch ($method) {
        case 'POST': // Создать пользователя
            $data = json_decode(file_get_contents("php://input"), true);
            if (createUser($data['username'], $data['password'])) {
                echo json_encode(["message" => "User created"]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Failed to create user"]);
            }
            break;

        case 'GET': // Получить список всех пользователей или одного пользователя
            if (isset($path[1])) {
                $user = getUser($path[1]);
                if ($user) {
                    echo json_encode($user);
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "User not found"]);
                }
            } else {
                echo json_encode(getAllUsers());
            }
            break;

        case 'PATCH': // Обновить пользователя
            if (isset($path[1])) {
                $data = json_decode(file_get_contents("php://input"), true);
                if (updateUser($path[1], $data['username'], $data['password'])) {
                    echo json_encode(["message" => "User updated"]);
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Failed to update user"]);
                }
            }
            break;

        case 'DELETE': // Удалить пользователя
            if (isset($path[1]) && deleteUser($path[1])) {
                echo json_encode(["message" => "User deleted"]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Failed to delete user"]);
            }
            break;
    }
} elseif ($path[0] === 'auth' && $method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $userId = authenticateUser($data['username'], $data['password']);
    if ($userId) {
        echo json_encode(["message" => "Authentication successful", "user_id" => $userId]);
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Invalid credentials"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "Not found"]);
}