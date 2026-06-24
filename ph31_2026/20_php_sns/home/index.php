<?php
// 共通ファイル app.php を読み込み
require_once '../app.php';

use App\Controllers\HomeController;

$controller = new HomeController();
// HomeController の index() アクションを実行
$controller->index();
