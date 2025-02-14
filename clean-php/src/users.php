<?php
require_once __DIR__ . '/config.php';

// Создать пользователя
function createUser($username, $password): bool
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    return $stmt->execute([$username, password_hash($password, PASSWORD_BCRYPT)]);
}

// Получить пользователя по ID
function getUser($id) : string|array
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Получить всех пользователей
function getAllUsers(): array
{
    global $pdo;
    $stmt = $pdo->query("SELECT id, username FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Обновить пользователя
function updateUser($id, $username, $password): bool
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
    return $stmt->execute([$username, password_hash($password, PASSWORD_BCRYPT), $id]);
}

// Удалить пользователя
function deleteUser($id): bool
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$id]);
}

// Авторизация
function authenticateUser($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user && password_verify($password, $user['password']) ? $user['id'] : false;
}