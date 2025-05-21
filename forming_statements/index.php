<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/form.css">
    
</head>
<body>
    <!--header-->
    <?php
include("../inc/header.php");
?>
    <!--end header-->

<!--statements form-->
<form action="save_statements.php" method="post" enctype="multipart/form-data">
<?php
session_start();

if (isset($_SESSION['error'])) {
    echo "<div id='msg'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}
?>
      <div class="login-form">
         <div class="text">
Формирование заявления
         </div>
         <div class="field">
            <input type="text" name="car_number" placeholder="Государсвенный регистрационный номер авто" required>
         </div>
         <div class="field">
            <input type="text" name="description"  placeholder="Описание нарушения" required>
         </div>
         <div class="field">
            <input type="text" name="adress"  placeholder="Примерное место" required>
         </div>
         <div class="field">
            <label for="file"></label>
            <input type="file" name="file" id="file" required>
         </div>
         <button>Отправить</button>
         </div>
</form>
<!--end statements form-->

           <!--footer-->
           <?php
include("../inc/footer.php");
?>
    <!--end footer-->
</body>
</html>