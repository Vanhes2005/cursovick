<?php
$connect = new mysqli("MySQL-8.0", "root", "", "PDD_2");
if ($connect->connect_error) {
    die('Ошибка подключения: ' . $connect->connect_error);
}
?>