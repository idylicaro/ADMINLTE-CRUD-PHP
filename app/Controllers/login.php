<?php

    require __DIR__ . "/../../vendor/autoload.php";

    use App\Entity\User;

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = new User;

        if (!isset($_POST['email']) || empty($_POST['email'])){
            $_SESSION['error-register'] = 'Email necessário!';
            header('Location: ../../login.php');
            return;
        }
        $user->email = htmlspecialchars(stripslashes(filter_input( INPUT_POST,'email', FILTER_SANITIZE_EMAIL)));
        if (!isset($_POST['password'])){
            $_SESSION['error-register'] = 'Senha necessário';
            header('Location: ../../login.php');
            return;
        }
        $user->password = htmlspecialchars(stripslashes(filter_input( INPUT_POST,'password', FILTER_SANITIZE_STRING)));

        $user = $user->login();
        if ($user){

            unset($_SESSION['error-register']);
            unset($_SESSION['error']);
            $_SESSION['success'] = "active";

            $_SESSION['id'] = $user->id;
            $_SESSION['email'] = $user->email;
            $_SESSION['name'] = $user->name;
            header('Location: ../../index.php');
        }else{
            $_SESSION['error'] = 'Email ou senha inválido!';
            header('Location: ../../login.php');
        }

    }else{
        header('Location: 404');
    }

