<?php

/**
 * 07_form_session/post_receive.php
 * POSTデータを受け取り、認証検証を行ってからリダイレクトする
 */

// TODO: セッションの開始
session_start();

// テストユーザー情報 (本来はデータベース等で管理します)
const TEST_USER = [
    'name' => '東京 太郎',
    'email' => 'user@example.com',
    'password' => 'password123'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO: POST を var_dump() で確認したら、コメントアウト
    // var_dump($_POST);
    // exit;

    // TODO: POSTの email を取得
    $email = htmlspecialchars($_POST['email']);
    // TODO: POSTの password を取得
    $password = htmlspecialchars($_POST['password']);

    // TODO: 入力データの保持 (復元用): previous_post セッションに保存
    $_SESSION['previous_post'] = [ 'email' => $email ];

    // 認証検証
    if ($email === TEST_USER['email'] && $password === TEST_USER['password']) {
        // 認証成功
        $_SESSION['status'] = 'success';
        $_SESSION['authUser'] = TEST_USER;
        $_SESSION['message'] = 'ログインに成功しました。';

        // TODO: 成功時はパスワードを保持しない: unset() 
        unset($_SESSION['previous_post']['password']);

        // TODO: 認証が成功したら、get_request.php にリダイレクト
        // header('Location: get_request.php');
        // exit;
    } else {
        // 認証失敗
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'メールアドレスまたはパスワードが正しくありません。';
    }
}

// post_request.php にリダイレクト
header('Location: post_request.php');
exit;