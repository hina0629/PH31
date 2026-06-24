<?php
// 設定ファイルを読み込み
require_once "env.php";

// セッション開始
session_start();
session_regenerate_id(true);

// アプリケーションのルートディレクトリパス
const BASE_DIR = __DIR__;
// app/ ディレクトリパス
const APP_DIR = __DIR__ . "/app/";

// app/models/ ディレクトリパス
const MODEL_DIR = APP_DIR . "models/";
// app/controllers/ ディレクトリパス
const CONTROLLER_DIR = APP_DIR . "controllers/";
// app/services/ ディレクトリパス
const SERVICE_DIR = APP_DIR . "services/";
// app/requests/ ディレクトリパス
const REQUEST_DIR = APP_DIR . "requests/";
// app/views/ ディレクトリパス
const VIEW_DIR = APP_DIR . "views/";
// app/views/components/ ディレクトリパス
const COMPONENT_DIR = VIEW_DIR . "/components/";

// lib/ ディレクトリパス
const LIB_DIR = __DIR__ . "/lib/";

// image base path
const IMAGE_BASE = "images/";
// upload image base path
const UPLOADS_BASE = "images/uploads/";
// profile image base path
const PROFILE_BASE = "images/profile/";
// upload image dir
const UPLOADS_DIR = __DIR__ . UPLOADS_BASE;
// profile image dir
const PROFILE_DIR = __DIR__ . PROFILE_BASE;

// ライブラリ読み込み
require_once LIB_DIR . 'Database.php';
require_once LIB_DIR . 'Sanitize.php';
require_once LIB_DIR . 'File.php';
require_once LIB_DIR . 'Request.php';
require_once LIB_DIR . 'View.php';
require_once LIB_DIR . 'Csrf.php';

// モデルクラスの読み込み
require_once APP_DIR . 'models/User.php';
require_once APP_DIR . 'models/Tweet.php';
require_once APP_DIR . 'models/Like.php';
require_once APP_DIR . 'models/Follow.php';
require_once APP_DIR . 'models/Reply.php';
require_once APP_DIR . 'models/AuthUser.php';

// サービスクラスの読み込み
require_once APP_DIR . 'services/TweetService.php';

// リクエストクラスの読み込み
require_once REQUEST_DIR . 'UserUpdateRequest.php';

// コントローラークラスの読み込み
require_once APP_DIR . 'controllers/AuthenticatedController.php';
require_once APP_DIR . 'controllers/LoginController.php';
require_once APP_DIR . 'controllers/HomeController.php';
require_once APP_DIR . 'controllers/UserController.php';
require_once APP_DIR . 'controllers/RegisterController.php';


// ベースURLの定義
if (!defined('BASE_URL')) define('BASE_URL', getBaseUrl());

// BASE_URL を定義（常にルートからの相対パス）
function getBaseUrl()
{
    $documentRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
    $directory = str_replace('\\', '/', __DIR__);
    $basePath = str_replace($documentRoot, '', $directory);
    return rtrim($basePath, '/') . '/';
}
