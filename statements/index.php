<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница заявлений</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/statements.css">
</head>
<body>
    <!--header-->
    <?php include("../inc/header.php"); ?>
    <!--end header-->

        <div class="container">
            <h1 class="h1">Страница заявлений</h1>
        </div>

    <div class="container">
        <!-- Вывод сообщений -->
        <?php
        session_start();
        if (isset($_SESSION['message'])) {
            echo '<div class="message">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']); // Удаляем сообщение после вывода
        }
        ?>

        <!-- PHP код для вывода заявлений пользователя -->
        <?php
        if (!isset($_SESSION['id_user'])) {
            echo '<p>Пожалуйста, авторизуйтесь для просмотра заявлений.</p>';
        } else {
            // Подключение к базе данных
            include("../functions/bdconnect.php");

            // Запрос к базе данных для получения заявлений пользователя
            $id_user = $_SESSION['id_user'];
            $query = "SELECT Users.name, Statements.number_car, Statements.description, Statements.adress, Statements.date,Statements.image, Status.status, Statements.id_statement, Statements.reason 
                      FROM Statements 
                      JOIN Users ON Statements.id_user = Users.id_user 
                      JOIN Status ON Statements.status = Status.id_status 
                      WHERE Statements.id_user = '$id_user'";
            $result = $connect->query($query);
            if ($result === false) {
                die('Ошибка SQL-запроса: ' . $connect->error);
            }

            if ($result->num_rows > 0) {
                echo '<table>';
                echo '<tr><th>Имя пользователя</th><th>Номер авто</th><th>Описание</th><th>Адрес</th><th>Дата и время</th><th>Фото</th><th>Статус</th><th>Причина отклонения</th><th>Действия</th></tr>';
                while($row = $result->fetch_assoc()) {
                    // Определяем класс строки в зависимости от статуса
                    $row_class = '';
                    $status = strtolower($row['status']); // Приводим статус к нижнему регистру
                    if ($status == 'подтверждено') {
                        $row_class = 'status-confirmed';
                    } elseif ($status == 'отклонено') {
                        $row_class = 'status-rejected';
                    }

                    echo '<tr class="' . $row_class . '">';
                    echo '<td data-label="Имя пользователя">' . $row['name'] . '</td>';
                    echo '<td data-label="Номер авто">' . $row['number_car'] . '</td>';
                    echo '<td data-label="Описание">' . $row['description'] . '</td>';
                    echo '<td data-label="Адрес">' . $row['adress'] . '</td>';
                    echo '<td data-label="Дата и время">' . $row['date'] . '</td>';
                    if (!empty($row['image'])){
                        echo '<td data-label="Фото">';
                        if (!empty($row['image'])) {
                            // Добавляем префикс ../images/ к пути изображения
                            $imagePathWithPrefix = '../images/' . $row['image'];
                            // Формируем полный путь для проверки существования файла
                            $imageFullPath = realpath(dirname(__FILE__) . '/' . $imagePathWithPrefix);
                        
                            // Проверка существования файла
                            if ($imageFullPath && file_exists($imageFullPath)) {
                                echo '<div class="photo-container"><img src="' . htmlspecialchars($imagePathWithPrefix) . '" alt="Фото нарушения" class="statement-photo"></div>';
                            } else {
                                echo '<p>Изображение не найдено</p>';
                            }
                        } else {
                            echo '<p>Фотография отсутствует</p>';
                        }
                        echo '</td>';};
                    echo '<td data-label="Статус">' . $row['status'] . '</td>';
                    // Вывод причины отклонения, если статус "отклонено"
                    echo '<td data-label="Причина отклонения">';
                    if ($status == 'отклонено' && !empty($row['reason'])) {
                        echo htmlspecialchars($row['reason']);
                    } else {
                        echo '-';
                    }
                    echo '</td>';
                    // Кнопки редактирования и удаления
                    echo '<td data-label="Действия">';
                    echo '<a href="edit_statement.php?id=' . $row['id_statement'] . '" class="edit-button">Редактировать</a>
                          <a href="delete_statement.php?id=' . $row['id_statement'] . '" class="delete-button" onclick="return confirm(\'Вы уверены, что хотите удалить это заявление?\')">Удалить</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>У вас нет заявлений.</p>';
            }
            $connect->close();
        }
        ?>
    </div>

    <!--footer-->
    <?php include("../inc/footer.php"); ?>
    <!--end footer-->
</body>
</html>