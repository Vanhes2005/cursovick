<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Регистрация</title>
   <link rel="stylesheet" href="../assets/css/index.css">
   <link rel="stylesheet" href="../assets/css/form.css">
</head>

<body>

    <!--header-->
    <?php
include("../inc/header.php");
?>
    <!--end header-->

   <!--registration-->

   <form action="save_user.php" method="post">
      <div class="login-form">
         <div class="text">
            Регистрация
         </div>
         <div class="field">
            <input type="text" name="login" placeholder="Логин" required>
         </div>
         <?php


            if (isset($_SESSION['error'])) {
               // вывод сообщения в браузер
               echo "<div id='msg'>" . $_SESSION['error'] . "</div>";
               unset($_SESSION['error']);
            }
            ?>
         <div class="field">
            <input type="password" name="password"  placeholder="Пароль" minlength="6" required>
         </div>
         <div class="field">
            <input type="text" name="name"  placeholder="ФИО" pattern="[А-Яа-яЁё ]+" title="Можно использовать только символы кириллицы и пробелы" required>
         </div>
         <div class="field">
            <input type="tel" name="phone" placeholder="Номер телефона" pattern="[\+]\d{1}\s[\(]\d{3}[\)]\s\d{3}[\-]\d{2}[\-]\d{2}" minlength="18" maxlength="18" title="Номер телефона должен соответсвовать формату: +7 (999) 999-99-99" required>
         </div>
         <div class="field">
            <input type="email" name="email" placeholder="email" required>
         </div>
         <button>Зарегистрироваться</button>
         <div class="link">
            Уже зарегистрированны?
            <a href="../authorization/auth.php">Войти</a>
         </div>
      </div>
   </form>
   <!--end registration-->

       <!--footer-->
       <?php
include("../inc/footer.php");
?>
    <!--end footer-->
</body>

</html>