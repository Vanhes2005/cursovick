<?php
session_start();
?>
<div class="header">
        <a href="../index.php">Нарушения.ПДД</a>
        <?php
        if (isset($_SESSION['role']) && $_SESSION['role']=='admin') {
            echo '<a href="../administration/index.php" class="btn">Админ панель</a>';
        }
        if (isset($_SESSION['id_user'])) {
            // Пользователь авторизован, показываем кнопку выхода
            echo '<a href="../functions/logout.php" class="btn">Выход из кабинета</a>';
        } else {
            // Пользователь не авторизован, показываем кнопки входа и регистрации
            echo '<a href="../register/reg.php" class="btn">Регистрация</a>';
            echo '<a href="../authorization/auth.php" class="btn">Вход</a>';
        }
        ?>
    </div>