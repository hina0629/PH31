<?php
// TODO: セッション開始
session_start();

// Contactクラス読み込み
require __DIR__ . '/../src/Contact.php';

// TODO: POSTデータ受け取り
$name  = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$body  = $_POST['body'] ?? '';

// TODO: セッションデータ保存
$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['body'] = $body;

// Contactクラスのインスタンス化
$contact = new Contact();

// バリデーション
$error = $contact->validate($name, $email, $body);
if ($error) {
    $_SESSION['error'] = $error;
    header("Location: ./");
    exit;
}

// TODO: メール送信: send() : $name, $email, $body
$result = $contact->send($name, $email, $body);

if ($result === true) {
    // TODO: 結果画面へリダイレクト: result.php
    header("Location: ./result.php");
} else {
    $_SESSION['error'] = "送信に失敗しました: {$result}";
    header("Location: ./");
}
exit;