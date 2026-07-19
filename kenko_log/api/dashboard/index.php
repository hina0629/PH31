<?php
require_once '../../app.php';

use Lib\Database;

header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => '未認証']);
    exit;
}

$userId = (int) $_SESSION['user']['id'];
$pdo    = Database::getInstance();

function fetchOne(PDO $pdo, string $sql, array $params = []): ?array
{
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}

function fetchAll(PDO $pdo, string $sql, array $params = []): array
{
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// DBから target_calories をとってくる
$userRow = fetchOne($pdo, 'SELECT target_calories FROM users WHERE id = :id', [':id' => $userId]);

// ここで配列のキーを参照している（箱の中をいじっている）から null にならないように対策
// null だとそもそも存在しないのにその中から特定のものを取り出そうとしているから怒られる
// null だった場合、1000を入れてエラー回避
$targetCalories = $userRow ? (int)$userRow['target_calories'] : 1000;
// SQLで target_calories を単体で取り出しているのになぜ箱の中をいじる必要があるのか？
// phpが受け取るデータはこうなる
// [
//     'target_calories' => 1000
// ]
// から、このままだと$data['user']の中身は
// $data = [
//     'user' => [
//         'name' => 'テストユーザー', // セッションから
//         'target_calories' => [ 
//             'target_calories' => 1000 
//         ]
//     ]
// ];
// 二重になってしまう。だから $targetCalories に取り出された値（1000とか）を入れないといけない

$data = [
    'status' => 'ok',
    'user'   => [
        'name' => $_SESSION['user']['name'],
        'target_calories' => $targetCalories
    ],
    'latest_health' => fetchOne(
        $pdo,
        'SELECT * FROM health_records WHERE user_id = :user_id ORDER BY recorded_at DESC LIMIT 1',
        [':user_id' => $userId]
    ),
    'latest_sleep' => fetchOne(
        $pdo,
        'SELECT * FROM sleep_records WHERE user_id = :user_id ORDER BY sleep_date DESC LIMIT 1',
        [':user_id' => $userId]
    ),
    'exercise_summary' => fetchOne(
        $pdo,
        'SELECT COUNT(*) AS record_count,
                COALESCE(SUM(duration_minutes), 0) AS total_minutes,
                COALESCE(SUM(calories_burned), 0) AS total_calories
         FROM exercise_records WHERE user_id = :user_id',
        [':user_id' => $userId]
    ),
    'meal_summary' => fetchOne(
        $pdo,
        'SELECT COUNT(*) AS record_count,
                COALESCE(SUM(calories), 0) AS total_calories
         FROM meal_records WHERE user_id = :user_id',
        [':user_id' => $userId]
    ),
    'recent_exercises' => fetchAll(
        $pdo,
        'SELECT * FROM exercise_records WHERE user_id = :user_id ORDER BY exercise_date DESC, id DESC LIMIT 5',
        [':user_id' => $userId]
    ),
    'recent_meals' => fetchAll(
        $pdo,
        'SELECT * FROM meal_records WHERE user_id = :user_id ORDER BY meal_date DESC, id DESC LIMIT 5',
        [':user_id' => $userId]
    ),
];

// JSONで出力
echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
