<?php
require_once '../../app.php';

use Lib\Database;

header('Content-Type: application/json; charset=utf-8');

// ログインチェック
if (empty($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => '未認証']);
    exit;
}

// データの保存だからPOSTリクエスト以外は受け付けない
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => '無効なリクエストメソッドです。']);
    exit;
}

// JSONデータの取得
// PHPが読み書きできるようにJSONから配列に変換
$input = json_decode(file_get_contents('php://input'), true);
// isset() データが存在するか確認するやつ
// データがあれば数字に変換して、なければ null を入れる
$targetCalories = isset($input['target_calories']) ? (int)$input['target_calories'] : null;

// null だったり 0 より小さかったらエラーメッセージを表示
if ($targetCalories === null || $targetCalories < 0) {
    echo json_encode(['status' => 'error', 'message' => '不正な数値です。']);
    exit;
}

$userId = (int) $_SESSION['user']['id'];
// Databaseクラスのデータベースに接続するやつ
// DBを操作するためのオブジェクトをもらう
$pdo    = Database::getInstance();

try {
    $sql = 'UPDATE users SET target_calories = :target_calories WHERE id = :id';
    // SQLの骨組みを作って準備させる。穴あきSQL
    $stmt = $pdo->prepare($sql);
    // 穴に値をはめ込む
    $stmt->execute([
        ':target_calories' => $targetCalories,
        ':id' => $userId
    ]);
    // なぜこんなことをするのか？
    // 例えば、
    // $sql = "UPDATE users SET target_calories = " . $targetCalories . " WHERE id = " . $userId;
    // こうだった場合に、1200; DROP TABLE users; -- と入力されたらユーザーテーブルが消されちゃう
    // けど、これをやることで
    // 「このSQLは、users テーブルを UPDATE するだけの命令だ」と確定させることができる
    // もしSQL文を入力されてもただのおかしな文字列と認識してくれるからテーブルは消されない
    
    // ステータスはOKと保存した数値を情報として乗せ、配列をJSONに変換し、呼び出し元であるブラウザに送信
    echo json_encode(['status' => 'ok', 'target_calories' => $targetCalories]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'データベース更新エラーが発生しました。']);
}
