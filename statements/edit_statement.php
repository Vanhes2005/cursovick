<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html><?php
session_start();
if (!isset($_SESSION['id_user'])) {
    die('Пожалуйста, авторизуйтесь для редактирования заявления.');
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

    // Если статус "подтверждён" (2) или "отклонён" (3), запрещаем редактирование
    if ($status == 2 || $status == 3) {
        $_SESSION['message'] = 'Невозможно редактировать заявление с подтверждённым или отклонённым статусом.';
        header("Location: index.php"); // Перенаправляем на index.php
        exit();
    } else {
        // Если форма отправлена
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $number_car = $_POST['number_car'];
            $description = $_POST['description'];
            $adress = $_POST['adress'];

            // Обновляем заявление с обновлением даты и времени
            $query = "UPDATE Statements SET number_car='$number_car', description='$description', adress='$adress', date=NOW() WHERE id_statement='$id' AND id_user='$id_user'";
            if ($connect->query($query) === TRUE) {
                $_SESSION['message'] = 'Заявление успешно обновлено!';
            } else {
                $_SESSION['message'] = 'Ошибка: ' . $connect->error;
            }
            header("Location: index.php"); // Перенаправляем на index.php после обновления
            exit();
        } else {
            // Получаем данные заявления для редактирования
            $query = "SELECT * FROM Statements WHERE id_statement='$id' AND id_user='$id_user'";
            $result = $connect->query($query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Выводим форму редактирования
                echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Редактирование заявления</title>
                    <link rel="stylesheet" href="../assets/css/index.css">
                </head>
                <body>
                    <div class="container">
                        <h2>Редактирование заявления</h2>';
                if (isset($_SESSION['message'])) {
                    echo '<div class="message">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);
                }
                echo '<form action="edit_statement.php?id=' . $id . '" method="POST">
                            <label for="number_car">Номер авто:</label>
                            <input type="text" id="number_car" name="number_car" value="' . $row['number_car'] . '" required>
                            <label for="description">Описание:</label>
                            <textarea id="description" name="description" required>' . $row['description'] . '</textarea>
                            <label for="adress">Адрес:</label>
                            <input type="text" id="adress" name="adress" value="' . $row['adress'] . '" required>
                            <button type="submit" class="save-button">Сохранить изменения</button>
                        </form>
                    </div>
                </body>
                </html>';
            } else {
                $_SESSION['message'] = 'Заявление не найдено.';
                header("Location: index.php");
                exit();
            }
        }
    }
} else {
    $_SESSION['message'] = 'Заявление не найдено.';
    header("Location: index.php");
    exit();
}

$connect->close();
?>