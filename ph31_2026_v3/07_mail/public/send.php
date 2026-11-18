<?php
// TODO: セッション開始

// Contactクラス読み込み
require __DIR__ . '/../src/Contact.php';

// TODO: POSTデータ受け取り
$name  = "";
$email = "";
$body  = "";

// TODO: セッションデータ保存
$_SESSION['name'];
$_SESSION['email'];
$_SESSION['body'];

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
$result = false;

if ($result === true) {
    // TODO: 結果画面へリダイレクト: result.php
} else {
    $_SESSION['error'] = "送信に失敗しました: {$result}";
    header("Location: ./");
}
exit;