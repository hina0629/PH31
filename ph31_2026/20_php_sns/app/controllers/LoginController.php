<?php

namespace App\Controllers;

use App\Models\AuthUser;
use App\Models\User;
use Lib\Csrf;
use Lib\Request;
use Lib\View;

class LoginController
{
    public function index()
    {
        if (isset($_SESSION['signin'])) {
            unset($_SESSION['signin']);
        }
        header('Location: ' . BASE_URL . 'login/input.php');
        exit;
    }

    public function input()
    {
        $form  = $_SESSION['signin'] ?? null;
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        View::render('login/input', ['form' => $form, 'error' => $error]);
    }

    public function auth()
    {
        if (!Request::isPost()) {
            header('Location: ' . BASE_URL . 'login/input.php');
            exit;
        }

        if (!Csrf::verify()) {
            $_SESSION['error'] = '不正なリクエストです。';
            header('Location: ' . BASE_URL . 'login/input.php');
            exit;
        }

        $account_name = $_POST['account_name'];
        $password = $_POST['password'];

        $_SESSION['signin'] = ['account_name' => $account_name];

        $user      = new User();
        $auth_user = $user->auth($account_name, $password);

        if (empty($auth_user['id'])) {
            $_SESSION['error'] = 'アカウント名またはパスワードが間違っています。';
            header('Location: ' . BASE_URL . 'login/input.php');
            exit;
        }

        AuthUser::set($auth_user);
        header('Location: ' . BASE_URL . 'home/');
        exit;
    }
}
