<?php

    require __DIR__ . "/../../vendor/autoload.php";

    use App\Entity\User;

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = new User;
        if (!isset($_POST['name']) || empty($_POST['name'])){
            $_SESSION['error-register'] = 'Nome invalido ou vazio!';
            header('Location: ../../new.php');
            return;
        }
        $user->name = htmlspecialchars(stripslashes(filter_input( INPUT_POST,'name', FILTER_SANITIZE_STRING )));
        if (!isset($_POST['email']) || empty($_POST['email'])){
            $_SESSION['error-register'] = 'Email invalido ou vazio!';
            header('Location: ../../new.php');
            return;
        }
        $user->email = htmlspecialchars(stripslashes(filter_input( INPUT_POST,'email', FILTER_SANITIZE_EMAIL)));
        if (!isset($_POST['password']) || empty($_POST['email'])){
            $_SESSION['error-register'] = 'Password invalido ou vazio!';
            header('Location: ../../new.php');
            return;
        }
        $user->password = htmlspecialchars(stripslashes(filter_input( INPUT_POST,'password', FILTER_SANITIZE_STRING)));
        $user->save();

        unset($_SESSION['error-register']);

        header('Location: ../../index.php');

    }else{
        header('Location: 404');
    }
