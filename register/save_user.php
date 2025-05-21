<?php
session_start();

// Подключение к базе данных
include("../functions/bdconnect.php");

// Проверка существования логина
$stmt = $connect->prepare('SELECT login FROM Users WHERE login = ?');
$stmt->bind_param('s', $_POST['login']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows) {
   $_SESSION['error'] = 'Пользователь с таким логином существует';
   header("Location: reg.php");
   exit;
}

// Вставка данных пользователя
$stmt = $connect->prepare("INSERT INTO Users (name, email, login, password, phone, role) VALUES (?, ?, ?, ?, ?, 'user')");
$stmt->bind_param("sssss", $_POST['name'], $_POST['email'], $_POST['login'], $_POST['password'], $_POST['phone']);

if ($stmt->execute()) {
   header("Location: ../index.php");
   exit;
} else {
   echo "Ошибка при регистрации: " . $stmt->error;
}
$stmt->close();
$connect->close();
?>