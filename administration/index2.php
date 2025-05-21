<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link rel="stylesheet" href="../assets/css/index.css">
        <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

    <!--header-->
    <?php
    include("../inc/header.php");
    ?>
    <!--end header-->

    <!--info-block-->
    <div class="info-block">
        <div class="info-block-header">
            <h2>Сообщите о нарушении</h2>
        </div>
        <div class="info-block-content">
            <p>Если вы стали свидетелем нарушения правил дорожного движения, ДТП или других инцидентов, связанных с транспортными средствами, пожалуйста, сообщите нам. Ваше сообщение поможет улучшить безопасность на дорогах и может спасти жизни.</p>
            <p>Мы предоставляем простую форму для быстрого сообщения о происшествиях, а также контактную информацию для связи с нашими операторами. Ваша конфиденциальность гарантирована.</p>
            <?php if (isset($_SESSION['id_user'])): ?>
            <p><a href="../forming_statements/index.php">Сообщить о нарушении</a></p>
            <?php else: ?>
            <p><a href="../forming_statements/index.php">Сообщить о нарушении</a></p>
            <?php endif; ?>
            <!-- Проверка авторизации пользователя -->
            <?php if (isset($_SESSION['id_user'])): ?>
            <!-- Кнопка для перехода к заявлениям -->
            <a href="../statements/index.php" class="button">Перейти к заявлениям</a>
            <?php endif; ?>
        </div>
    </div>
    <!--end info-block-->

    <!--footer-->
    <?php
    include("../inc/footer.php");
    ?>
    <!--end footer-->
</body>

</html>