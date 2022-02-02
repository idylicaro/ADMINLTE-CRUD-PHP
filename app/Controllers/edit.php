<?php

    require __DIR__ . "/../../vendor/autoload.php";

    use App\Entity\User;

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = new User;

        $user->id = htmlspecialchars(stripslashes(filter_input( INPUT_POST,'id', FILTER_SANITIZE_NUMBER_INT )));

        if (!isset($_POST['name']) || empty($_POST['name'])){
            $_SESSION['error-register'] = 'Nome invalido ou vazio!';
            header('Location: ../../edit.php');
            return;
        }
        $user->name = htmlspecialchars(stripslashes(filter_input( INPUT_POST,'name', FILTER_SANITIZE_STRING )));
        if (!isset($_POST['email']) || empty($_POST['email'])){
            $_SESSION['error-register'] = 'Email invalido ou vazio!';
            header('Location: ../../edit.php');
            return;
        }
        $user->email = htmlspecialchars(stripslashes(filter_input( INPUT_POST,'email', FILTER_SANITIZE_EMAIL)));
        if (!isset($_POST['password']) || empty($_POST['password'])){
            $_SESSION['error-register'] = 'Password invalido ou vazio ou confirmação de senha invalida!';
            header('Location: ../../edit.php');
            return;
        }
        $user->password = htmlspecialchars(stripslashes(filter_input( INPUT_POST,'password', FILTER_SANITIZE_STRING)));
        $user->update();

        unset($_SESSION['error-register']);

        header('Location: ../../index.php');

    }else{
        header('Location: 404');
    }