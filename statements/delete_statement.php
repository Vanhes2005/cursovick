<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    die('Пожалуйста, авторизуйтесь для удаления заявления.');
}

include("../functions/bdconnect.php");

$id = $_GET['id']; // ID заявления
$id_user = $_SESSION['id_user']; // ID пользователя

// Проверяем статус заявления
$status_query = "SELECT status FROM Statements WHERE id_statement='$id' AND id_user='$id_user'";
$status_result = $connect->query($status_query);

if ($status_result->num_rows > 0) {
    $status_row = $status_result->fetch_assoc();
    $status = $status_row['status'];

    // Если статус "подтверждён" (2) или "отклонён" (3), запрещаем удаление
    if ($status == 2 || $status == 3) {
        $_SESSION['message'] = 'Невозможно удалить заявление с подтверждённым или отклонённым статусом.';
    } else {
        // Удаляем заявление
        $query = "DELETE FROM Statements WHERE id_statement='$id' AND id_user='$id_user'";
        if ($connect->query($query) === TRUE) {
            $_SESSION['message'] = 'Заявление успешно удалено!';
        } else {
            $_SESSION['message'] = 'Ошибка: ' . $connect->error;
        }
    }
} else {
    $_SESSION['message'] = 'Заявление не найдено.';
}

$connect->close();
header("Location: index.php"); // Перенаправляем обратно на страницу заявлений
exit();
?>