<?php
// ============================================================
// reset.php - DB初期化
// notices テーブルを削除して作り直し、アップロード画像も削除する
// ============================================================
require_once __DIR__ . "/../src/db.php";

// GET で開いた場合は誤操作防止のため何もしない
// TODO: POST 以外ならトップへ戻す: $_SERVER['REQUEST_METHOD'] を使用
if (false) {
    header("Location: index.php");
    exit;
}

// テーブルを削除して再作成
// TODO: テーブルを削除: DROP TABLE IF EXISTS notices を $pdo->exec() で実行
$sql = "";

// テーブルを再作成: createTables() を呼ぶ
createTables();

// アップロード画像を削除
// TODO: uploads 内のファイルを glob() で取得して foreach で回し、unlink() で削除
foreach ([] as $file) {
    if (is_file($file)) {
    }
}

// 完了メッセージ付きでトップへ戻す
header("Location: index.php?reset=1");
exit;
