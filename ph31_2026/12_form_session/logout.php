<?php

/**
 * 07_form_session/logout.php
 * セッションを破棄してログアウトする
 */

// セッションの開始
session_start();

// セッション変数の破棄
// TODO: セッション変数の破棄: unset() authUser, message, status
if (isset($_SESSION['authUser'])) {
    unset($_SESSION['authUser']);
}

// ログインページへリダイレクト
header('Location: post_request.php');
exit;