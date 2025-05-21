<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявки с подтверждённым статусом</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <!--header-->
    <?php
    include("../inc/header.php");
    ?>
    <!--end header-->

    <?php
    // Подключение к базе данных
    include("../functions/bdconnect.php");

    // Получение и сортировка заявлений с подтверждённым статусом
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_asc';
    $order = 'Statements.date ASC';
    if ($sort == 'date_desc') {
        $order = 'Statements.date DESC';
    } elseif ($sort == 'name_asc') {
        $order = 'Users.name ASC';
    } elseif ($sort == 'name_desc') {
        $order = 'Users.name DESC';
    }

    // Обработка изменения статуса заявления
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_statement'])) {
        $statementId = $_POST['id_statement'];
        // Откат статуса заявления в статус "Новое"
        $newStatus = 1;

        // Подготовка SQL-запроса
        $updateStatement = mysqli_prepare($db, "UPDATE Statements SET status = ? WHERE id_statement = ?");
        if (!$updateStatement) {
            die('Ошибка подготовки запроса: ' . mysqli_error($db));
        }
        // Привязка параметров к подготовленному запросу
        mysqli_stmt_bind_param($updateStatement, 'ii', $newStatus, $statementId);
        // Выполнение подготовленного запроса
        mysqli_stmt_execute($updateStatement);
        // Закрытие подготовленного запроса
        mysqli_stmt_close($updateStatement);

        // Перенаправление для обновления страницы
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }

    // Получение заявлений со статусом "подтверждено"
    $statementsResult = mysqli_query($db, "
        SELECT Statements.id_statement, Users.name, Users.surname, Users.patronymic, Statements.description, Statements.number_car, Statements.adress, Statements.date, 'Подтверждено' as status
        FROM Users 
        INNER JOIN Statements ON Users.id_user = Statements.id_user
        WHERE Statements.status = 2
        ORDER BY $order
    ");

    // Проверка на ошибки выполнения запроса
    if (!$statementsResult) {
        die('Ошибка запроса: ' . mysqli_error($db));
    }
    // Получение результатов запроса
    $statements = mysqli_fetch_all($statementsResult, MYSQLI_ASSOC);
    // Освобождение памяти, занятой результатами запроса
    mysqli_free_result($statementsResult);
    ?><div class="admin-panel">
        <?php foreach ($statements as $statement): ?>
            <div class="statement" name="confirm.php">
                <div class="statement-header">
                    <?= htmlspecialchars($statement['name']) ?> <?= htmlspecialchars($statement['surname']) ?> <?= htmlspecialchars($statement['patronymic']) ?>
                </div>
                <div>Описание нарушения: <?= htmlspecialchars($statement['description']) ?></div>
                <div>Номер автомобиля: <?= htmlspecialchars($statement['number_car']) ?></div>
                <div>Адрес: <?= htmlspecialchars($statement['adress']) ?></div>
                <div>Дата: <?= htmlspecialchars($statement['date']) ?></div>
                <div>Статус: <?= htmlspecialchars($statement['status']) ?></div>
                <div class="actions">
                    <form method="post" onsubmit="setTimeout(refreshPage, 100);">
                        <input type="hidden" name="id_statement" value="<?= $statement['id_statement'] ?>">
                        <button type="submit" name="action" value="revert">Откатить в статус Новое</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
    </div>
    <!--end admin-->

    <!--footer-->
    <?php
    include("../inc/footer.php");
    ?>
    <!--end footer-->
</body>
</html>