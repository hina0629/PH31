<?php
require_once '../../app.php';

use App\Models\AuthUser;
use App\Models\Reply;
use App\Models\User;

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
$tweet_id = isset($body['tweet_id']) ? (int) $body['tweet_id'] : 0;
$message  = isset($body['message'])  ? trim($body['message'])  : '';

if (!$tweet_id || $message === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Bad Request'], JSON_UNESCAPED_UNICODE);
    exit;
}

$reply = new Reply();
$id = $reply->insert($tweet_id, (int) $auth_user['id'], $message);

if (!$id) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error'], JSON_UNESCAPED_UNICODE);
    exit;
}

$data = $reply->findById($id);
if (!$data) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error'], JSON_UNESCAPED_UNICODE);
    exit;
}

$data['profile_image_url'] = User::profileImage($data['profile_image']);
$data['reply_count'] = $reply->count($tweet_id);

echo json_encode($data, JSON_UNESCAPED_UNICODE);
