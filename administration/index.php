<!DOCTYPE html>
<html style="height:100%; margin: 0;" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        /* Стили для изображений */
        .statement-photo {
            max-width: 400px;
            max-height: 400px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            margin-top: 10px;
        }
        /* Стили для сообщения об ошибке */
        .error-message {
            padding: 10px;
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #c62828;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
    <script>
        function refreshPage() {
            location.reload();
        }

        function validateForm(form) {
            // Если выбрано "Отклонить" и причина не указана
            if (form.action.value === 'reject' && form.reject_reason.value.trim() === '') {
                alert('Пожалуйста, укажите причину отклонения.');
                return false; // Блокируем отправку формы
            }
            return true; // Разрешаем отправку формы
        }
    </script>
</head>
<body>
    <!--header-->
    <?php
    include("../inc/header.php");
    ?>
    <!--end header-->

    <!--admin-->
    <div style="min-height: 100%; margin-bottom: -50px;">
    <?php
    session_start(); // Начинаем сессию
    // Вывод сообщений об ошибках
    if (isset($_SESSION['error'])) {
        echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']); // Удаляем сообщение после вывода
    }
    ?>
    <form method="get" id="sortForm">
        <label for="sort">Сортировать по:</label>
        <select name="sort" id="sort" onchange="document.getElementById('sortForm').submit();">
            <option value="date_asc" <?= isset($_GET['sort']) && $_GET['sort'] == 'date_asc' ? 'selected' : '' ?>>Дата (по старшинству)</option>
            <option value="date_desc" <?= isset($_GET['sort']) && $_GET['sort'] == 'date_desc' ? 'selected' : '' ?>>Дата (по новизне)</option>
            <option value="name_asc" <?= isset($_GET['sort']) && $_GET['sort'] == 'name_asc' ? 'selected' : '' ?>>Имя (по алфавиту)</option>
            <option value="name_desc" <?= isset($_GET['sort']) && $_GET['sort'] == 'name_desc' ? 'selected' : '' ?>>Имя (в обратном алфавите)</option>
        </select>
    </form>

    <nav>
        <ul>
            <li><a href="confirm.php">Заявки с подтверждённым статусом</a></li>
            <li><a href="cancel.php">Заявки с отклонённым статусом</a></li>
        </ul>
    </nav>

    <?php
    // Подключение к базе данных
    include("../functions/bdconnect.php");

    // Обработка изменения статуса заявления
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_statement'])) {
        $statementId = $_POST['id_statement'];
        $newStatus = $_POST['action'] === 'approve' ? 2 : 3;
        $rejectReason = $_POST['action'] === 'reject' ? $_POST['reject_reason'] : null;

        // Проверка на стороне сервера: если заявка отклонена, причина должна быть указана
        if ($newStatus == 3 && empty($rejectReason)) {
            $_SESSION['error'] = 'Ошибка: Укажите причину отклонения.'; // Сохраняем ошибку в сессии
            header("Location: " . $_SERVER['REQUEST_URI']); // Перенаправляем на ту же страницу
            exit();
        }

        // Подготовка SQL-запроса
        $updateStatement = mysqli_prepare($db, "UPDATE Statements SET status = ?, reason = ? WHERE id_statement = ?");
        if (!$updateStatement) {
            die('Ошибка подготовки запроса: ' . mysqli_error($db));
        }
        // Привязка параметров к подготовленному запросу
        mysqli_stmt_bind_param($updateStatement, 'isi', $newStatus, $rejectReason, $statementId);
        // Выполнение подготовленного запроса
        mysqli_stmt_execute($updateStatement);
        // Закрытие подготовленного запроса
        mysqli_stmt_close($updateStatement);

        // Перенаправление для обновления страницы
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }

    // Получение и сортировка заявлений
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_asc';
    $order = 'Statements.date ASC';
    if ($sort == 'date_desc') {
        $order = 'Statements.date DESC';
    } elseif ($sort == 'name_asc') {
        $order = 'Users.name ASC';
    } elseif ($sort == 'name_desc') {
        $order = 'Users.name DESC';
    }

    // Получение заявлений со статусом "новое"
    $statementsResult = mysqli_query($connect, "
        SELECT Statements.id_statement, Users.name, Statements.description, Statements.number_car, Statements.adress, Statements.date, Status.status, Statements.image
        FROM Users 
        INNER JOIN Statements ON Users.id_user = Statements.id_user
        INNER JOIN Status ON Statements.status = Status.id_status
        WHERE Statements.status = 1
        ORDER BY $order
    ");

    // Проверка на ошибки выполнения запроса
    if (!$statementsResult) {
        die('Ошибка запроса: ' . mysqli_error($connect));
    }
    // Получение результатов запроса
    $statements = mysqli_fetch_all($statementsResult, MYSQLI_ASSOC);
    // Освобождение памяти, занятой результатами запроса
    mysqli_free_result($statementsResult);
    ?><div class="admin-panel">
<?php foreach ($statements as $statement): ?>
    <div class="statement">
        <div class="statement-header">
            <?= htmlspecialchars($statement['name']) ?>
        </div>
        <div>Описание нарушения: <?= htmlspecialchars($statement['description']) ?></div>
        <div>Номер автомобиля: <?= htmlspecialchars($statement['number_car']) ?></div>
        <div>Адрес: <?= htmlspecialchars($statement['adress']) ?></div>
        <div>Дата: <?= htmlspecialchars($statement['date']) ?></div>
        <div>Статус: <?= htmlspecialchars($statement['status']) ?></div>
        <!-- Вывод фотографии -->
        <?php if (!empty($statement['image'])): ?>
            <div class="photo-container">
                <?php
                // Добавляем префикс ../images/ к пути изображения
                $imagePathWithPrefix = '../images/' . $statement['image'];
                // Формируем полный путь для проверки существования файла
                $imageFullPath = realpath(dirname(__FILE__) . '/' . $imagePathWithPrefix);

                // Отладочные сообщения
                echo "<!-- Путь к изображению: $imagePathWithPrefix -->\n";
                echo "<!-- Полный путь к изображению: $imageFullPath -->\n";

                // Проверка существования файла
                if ($imageFullPath && file_exists($imageFullPath)) {
                    echo '<img src="' . htmlspecialchars($imagePathWithPrefix) . '" alt="Фото нарушения" class="statement-photo">';
                } else {
                    echo '<p>Изображение не найдено: ' . htmlspecialchars($imagePathWithPrefix) . '</p>';
                }
                ?>
            </div>
        <?php else: ?>
            <p>Фотография отсутствует.</p>
        <?php endif; ?>
        <div class="actions">
            <form method="post" onsubmit="return validateForm(this);">
                <input type="hidden" name="id_statement" value="<?= $statement['id_statement'] ?>">
                <button type="submit" name="action" value="approve">Подтвердить</button>
                <button type="submit" name="action" value="reject">Отклонить</button>
                <input type="text" name="reject_reason" placeholder="Укажите причину отклонения">
            </form>
        </div>
    </div>
<?php endforeach; ?>
    </div>
    <div style="height:120px;"></div>
    </div>
    <!--end admin-->

    <!--footer-->
    <footer style="height: 50px;" class="footer">
        <p><a href="../index.php">Нарушения.ПДД</a></p>
        <?php if (isset($_SESSION['id_user'])): ?>
        <p><a href="../forming_statements/index.php">Сообщить о нарушении</a></p>
        <?php else: ?>
            <p><a href="../forming_statements/index.php">Сообщить о нарушении</a></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['id_user'])): ?>
        <p><a href="../statements/index.php" class="button">Перейти к заявлениям</a></p>
        <?php endif; ?>
        <p><a href="https://mail.google.com/mail/u/0/#inbox?compose=CllgCJqXxVnXdsHrKPrGtxzsBvTmjJndpxRtWVdVQBXlkWwQXczZgfwqlRfBRzXgRjHZfFQZlzL">ivanbarbotkin5@gmail.com</a></p>
    </footer>
    <!--end footer-->
</body>
</html>