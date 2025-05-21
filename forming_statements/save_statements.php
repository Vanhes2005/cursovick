<?php
// Файл save_statements.php

session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['id_user'])) {
    // Если нет, то перенаправляем на страницу авторизации
    header('Location: ../authorization/auth.php');
    exit();
}

include("../functions/bdconnect.php");

// Получаем данные из формы
$id_user = $_SESSION['id_user'];
$number_car = $connect->real_escape_string($_POST['car_number']);
$description = $connect->real_escape_string($_POST['description']);
$adress = $connect->real_escape_string($_POST['adress']);

// Проверка и загрузка файла изображения
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $allowed = array("jpg" => "image/jpeg", "jpeg" => "image/jpeg", "png" => "image/png", "gif" => "image/gif");
    $filename = $_FILES['file']['name'];
    $filetype = $_FILES['file']['type'];
    $filesize = $_FILES['file']['size'];

    // Проверка расширения файла
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!array_key_exists($ext, $allowed)) die("Ошибка: Недопустимый формат файла.");

    // Проверка размера файла - 5МБ максимум
    $maxsize = 5 * 1024 * 1024;
    if ($filesize > $maxsize) die("Ошибка: Размер файла слишком большой.");

    // Проверка MIME-типа файла
    if (in_array($filetype, $allowed)) {
        // Убедимся, что папка существует
        if (!is_dir('../images')) {
            mkdir('../images', 0777, true);
        }

        // Сохраняем файл в папку images
        move_uploaded_file($_FILES['file']['tmp_name'], "../images/" . $filename);
        echo "Ваш файл был успешно загружен.";
    } else {
        echo "Ошибка: Недопустимый формат файла.";
    }
} else {
    echo "Ошибка: Файл не был загружен.";
}

// Получаем статус по умолчанию из таблицы Status
$status_query = "SELECT id_status FROM Status WHERE id_status = 1";
$status_result = $connect->query($status_query);

if ($status_result->num_rows > 0) {
    $status_row = $status_result->fetch_assoc();
    $status = $status_row['id_status'];
} else {
    // Если статус не найден, устанавливаем значение по умолчанию
    $status = 1;
}

// Текущая дата и время
$current_date = date("Y-m-d H:i:s");

// Запрос на вставку данных
$insert_query = "INSERT INTO Statements (id_user, number_car, description, adress, date, status, image) VALUES ('$id_user', '$number_car', '$description', '$adress', '$current_date', '$status', '$filename')";

// Выполняем запрос
if ($connect->query($insert_query) === TRUE) {
    header('Location: ../statements/index.php');
    exit();
} else {
    echo "Error: " . $insert_query . "<br>" . $connect->error;
}

// Закрываем соединение
$connect->close();
?>