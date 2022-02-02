<?php
    require __DIR__ . "/../../vendor/autoload.php";

    use App\Entity\User;

    session_start();
    if (!isset($_POST['user_id']) && !is_numeric($_POST['user_id'])) {
        $_SESSION['error'] = 'Id invalido!';
        return;
    }

    (new User())->delete($_POST['user_id']);

    header('Location:../../index.php');