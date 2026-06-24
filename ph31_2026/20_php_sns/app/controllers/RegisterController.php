<?php

namespace App\Controllers;

use App\Models\AuthUser;
use App\Models\User;
use Lib\Csrf;
use Lib\Request;
use Lib\View;

class RegisterController
{
    public function index(): void
    {
        unset($_SESSION[APP_KEY]['regist']);
        header('Location: ' . BASE_URL . 'register/input.php');
        exit;
    }

    public function input(): void
    {
        $regist = $_SESSION[APP_KEY]['regist'] ?? [];
        $error  = $_SESSION[APP_KEY]['errors']['public'] ?? null;
        unset($_SESSION[APP_KEY]['errors']);

        View::render('register/input', ['regist' => $regist, 'error' => $error]);
    }

    public function add(): void
    {
        // POSTリクエストチェック
        if (!Request::isPost()) {
            header('Location: ' . BASE_URL . 'register/input.php');
            exit;
        }

        // CSRFトークンチェック
        if (!Csrf::verify()) {
            $_SESSION[APP_KEY]['errors']['public'] = '不正なリクエストです。';
            header('Location: ' . BASE_URL . 'register/input.php');
            exit;
        }

        // POSTデータのサニタイズ（csrf_token はここで除去）
        $posts = sanitize($_POST);
        unset($posts['csrf_token']);
        // POSTデータをセッションに保存
        $_SESSION[APP_KEY]['regist'] = $posts;

        // アカウント名重複チェック
        $user = new User();
        if (!empty($user->findForExists($posts)['id'])) {
            $_SESSION[APP_KEY]['errors']['public'] = 'このアカウント名は既に使用されています。';
            header('Location: ' . BASE_URL . 'register/input.php');
            exit;
        }

        // ユーザー登録
        $user_id   = $user->insert($posts);
        $auth_user = $user->find($user_id);

        // ユーザー登録失敗
        if (empty($auth_user['id'])) {
            header('Location: ' . BASE_URL . 'register/input.php');
            exit;
        }

        // セッションに認証ユーザーを保存
        AuthUser::set($auth_user);
        // リダイレクト
        header('Location: ' . BASE_URL . 'register/result.php');
        exit;
    }

    public function result(): void
    {
        unset($_SESSION[APP_KEY]['regist'], $_SESSION[APP_KEY]['errors']);
        View::render('register/result', []);
    }
}
