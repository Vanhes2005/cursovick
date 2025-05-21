<?php
session_start();
include("../functions/bdconnect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $connect->prepare("SELECT id_user, password, role FROM Users WHERE login=?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if ($user['password'] === $password) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['login'] = $login;
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'user') {
                header("Location: ../index.php");
                exit;
            } elseif ($user['role'] == 'admin') {
                header("Location: ../administration/index2.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "Пароль неверный!";
            header("Location: auth.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Пользователь с таким логином не найден!";
        header("Location: auth.php");
        exit;
    }
    $stmt->close();
}
$connect->close();
?>