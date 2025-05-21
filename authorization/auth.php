<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/form.css">
</head>
<body>

    <!--header-->
    <?php
include("../inc/header.php");
?>
    <!--end header-->

<!--authorization form-->
<form action="test_user.php" method="post">
<?php
session_start();

if (isset($_SESSION['error'])) {
    echo "<div id='msg'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}
?>
      <div class="login-form">
         <div class="text">
            Вход
         </div>
         <div class="field">
            <input type="text" name="login" placeholder="Логин" required>
         </div>
         <div class="field">
            <input type="password" name="password"  placeholder="Пароль" minlength="6" required>
         </div>
         <button>Войти</button>
         <div class="link">
                Ещё не авторизованны?
            <a href="../register/reg.php">Регистрация</a>
         </div>
</div>
</form>
<!--end authorization form-->

                <!--footer-->
                <?php
include("../inc/footer.php");
?>
    <!--end footer-->
</body>
</html>