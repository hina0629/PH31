<?php
require_once '../../app.php';

use App\Models\AuthUser;
use App\Models\Like;

header('Content-Type: application/json');

// 認証チェック
$auth_user = AuthUser::get();
if (!$auth_user) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized'], JSON_UNESCAPED_UNICODE);
    exit;
}

// POST のみ受け付け
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed'], JSON_UNESCAPED_UNICODE);
    exit;
}

$body = json_decode(file_get_contents('php://input'), true);
$tweet_id = isset($body['tweet_id']) ? (int) $body['tweet_id'] : null;

if (!$tweet_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Bad Request'], JSON_UNESCAPED_UNICODE);
    exit;
}

$user_id = (int) $auth_user['id'];
$like = new Like();

// いいねをトグル
$like->update($tweet_id, $user_id);

// トグル後の状態を返す
$like_count = (int) $like->count($tweet_id);
$liked = $like->fetch($tweet_id, $user_id);
// 連想配列に格納
$data = ['like_count' => $like_count, 'liked' => $liked];
// TODO: json_encode() で $data をJSON文字列に変換して $json に代入
// オプション: JSON_UNESCAPED_UNICODE
$json = '';
// JSON出力
echo $json;
