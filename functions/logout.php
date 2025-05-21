<?php
session_start(); // Начинаем сессию
session_unset(); // Очищаем все переменные сессии
session_destroy(); // Уничтожаем сессию
header('Location: ../index.php'); // Перенаправляем пользователя на главную страницу
exit();
?>