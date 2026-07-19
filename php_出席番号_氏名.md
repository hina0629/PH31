# Kenko Log 未完成箇所調査レポート

## 提出者

- 学籍番号:40868
- 氏名:兒玉晃奈
- 調査日:2026/06/24



## 調査した項目一覧
1. [No.1: DB 接続情報](#no1-db-接続情報)
2. [No.2: トップページのキャッチコピー](#no2-トップページのキャッチコピー)
3. [No.3: クレジットで「2022」部分を今年で表示](#no3-クレジットで2022部分を今年で表示)
4. [No.4: 心拍数(bpm)表示](#no4心拍数bpm表示)
5. [No.5: 健康管理の記録の追加](#no5健康管理の記録の追加)
6. [No.6: 健康管理の編集画面表示](#no6-健康管理の編集画面表示)
7. [No.7: 健康管理のCSVダウンロード](#no7-健康管理のcsvダウンロード)
8. [No.8: アクティビティ種別の表示](#no8アクティビティ種別の表示)
9. [No.9: アクティビティの記録追加](#no9アクティビティの記録追加)
10. [No.10: 食事種別表示](#no10食事種別表示)
11. [No.11: 睡眠データ削除](#no11睡眠データ削除)
12. [No.12: ログアウト処理](#no12ログアウト処理)
13. [No.13: 認証状態による出し分け](#no13認証状態による出し分け)
14. [No.14: 古い入力値の復元](#no14古い入力値の復元)
15. [No.15: Gemini API キー](#no15gemini-api-キー)
16. [No.16: CSRF トークン](#no16csrf-トークン)
17. [No.17: パスワードをハッシュ化して保存する](#no17-パスワードをハッシュ化して保存する)
18. [No.18: const url = ''](#no18-const-url--)
19. [No.19: ログアウトした後にもトップページにあなたの健康データが出る](#no19-ログアウトした後にもトップページにあなたの健康データが出る)
20. [No.20: どのアカウントでログインしても値が同じ](#no20-どのアカウントでログインしても値が同じ)
21. [No.21: ログイン後に「ログイン」「新規登録」が表示されている](#no21-ログイン後にログイン新規登録が表示されている)

## No1. DB 接続情報 
#### 症状
データベースに接続できない

#### 確認したファイル
- env.php
- admin/create_database.php

#### 原因
実行環境に合わせてDB 接続情報を設定し、DBを構築する必要がある

#### 修正内容
- DB接続設定

```php
const DB_CONNECTION = 'mysql';
const DB_HOST = '127.0.0.1';
const DB_NAME = 'health_log';
const DB_USER = 'root';
const DB_PASS = '';
const DB_PORT = '3306';
const DB_CHARSET = 'utf8mb4';
```

### 動作確認
- データベース初期化画面で、セットアップを実行し「セットアップ完了」と表示
- DBクライアントでDB作成確認

## No2. トップページのキャッチコピー
#### 症状
トップページ左側にキャッチコピーが表示されない。

#### 確認したファイル
- ./index.php
- components/top/hero_left.php

#### 原因
`index.php` で `components/top/hero_left.php` が読み込まれていない。

#### 修正内容
PHPで include

```php
<?php include "components/top/hero_left.php" ?>
```

#### 動作確認
- トップページのヒーローセクションにキャッチコピーが表示された。
---

## No3. クレジットで「2022」部分を今年で表示
#### 症状
フッターのクレジットの年数が「2020 - 2022」固定になっている。

#### 確認したファイル
- components/footer.php

#### 原因
HTMLに直接「2022」と書いてあるから。

#### 修正内容
年数を自動取得する`$year`を作ってHTML上で表示

```php
$year = date('Y');
<span>&copy; 2020 - <?= $year ?> <?= SITE_TITLE ?>. All rights reserved.</span>
```

#### 動作確認
- フッターのクレジット年数が「2020-2026」と表示された

---

#### 動作確認
- トップページのヒーローセクションにキャッチコピーが表示された。
---

## No4.心拍数(bpm)表示
#### 症状
健康記録の一覧表で心拍数が表示されていない。

#### 確認したファイル
- health/index.php

#### 原因
とってきたデータを表示させてなかったから

#### 修正内容
とってきたデータを表示させた

```php
<td class="px-5 py-4"><?= htmlspecialchars($row['heart_rate']) ?></td>
```

#### 動作確認
- 心拍数が表示された

---

## No5.健康管理の記録の追加 
#### 症状
健康記録の追加時に、存在しないテーブル名 xxxx へ INSERT しようとして SQL エラーになる。

#### 確認したファイル
- health/insert.php

#### 原因
SQLでテーブル名が間違っている

#### 修正内容
テーブル名を正しいものに修正

```php
$sql = "INSERT INTO health_records(user_id, weight, heart_rate, systolic, diastolic, recorded_at) 
        VALUES (:user_id, :weight, :heart_rate, :systolic, :diastolic, :recorded_at)";
```

#### 動作確認
- 健康記録が追加できた

---

## No6. 健康管理の編集画面表示
#### 症状
編集対象の id を GET パラメータから取得していないため、編集画面で「該当する記録が見つかりません。」になる。

#### 確認したファイル
- health/edit.php

#### 原因
編集対象の id を GET パラメータから取得していないから

#### 修正内容
編集対象の id を GET パラメータから取得

```php
$id = $_GET['id'];
function find(int $id, int $userId) {
    // 処理
}
```

#### 動作確認
- 編集画面で選択した健康データが表示され、編集ができる

---

## No7. 健康管理のCSVダウンロード
#### 症状
CSV ダウンロード用の SQL が空のため、健康記録 CSV のダウンロード処理が失敗する。

#### 確認したファイル
- api/health/csv/index.php

#### 原因
CSV ダウンロード用の SQL が空だから

#### 修正内容
SQL をかいた

```php
$sql = "SELECT * FROM health_records WHERE user_id = :user_id";
```

#### 動作確認
- CSVファイルがダウンロードできた

---

## No8.アクティビティ種別の表示 
#### 症状
アクティビティ一覧の「種類」列で Warning が出る。

#### 確認したファイル
- activity/index.php

#### 原因
空の配列キーを参照しているため

#### 修正内容
空の配列の中に`exercise_type`をいれた

```php
<?= htmlspecialchars($row['exercise_type']) ?>
```

#### 動作確認
- アクティビティ一覧の「種類」がしっかりと表示されている

---

## No9.アクティビティの記録追加 
#### 症状
アクティビティ記録を追加しようとすると、「不正なリクエストです」と出る

#### 確認したファイル
- activity/add.php

#### 原因
`form`タグの`method`が空になっている

#### 修正内容
`form`タグの`method`の中身を`POST`にした

```html
<form action="activity/insert.php" method="POST" class="space-y-6">
```

#### 動作確認
- アクティビティ記録の追加ができた

---

## No10.食事種別表示
#### 症状
食事記録一覧の種類列が TODO: 食事の種別を表示 のままで、実データが表示されない。

#### 確認したファイル
- `	meal/index.php`

#### 原因
HTMLのなかに`TODO: 食事の種別を表示`と書かれていてデータの表示ができていないため

#### 修正内容
データを表示させた

```php
<?= htmlspecialchars($row['meal_type']) ?>
```

#### 動作確認
- 食事記録一覧の種類列が表示された

---

## No11.睡眠データ削除
#### 症状
睡眠の編集画面でデータ削除すると、Fatal error になる。

#### 確認したファイル
- `sleep/delete.php`

#### 原因
`execute()`に渡されている配列が空のため

#### 修正内容
`execute()`に`id`と`user_id`を渡した

```php
$stmt->execute([
        ':id' => $id,
        ':user_id' => $_SESSION['user']['id'],
    ]);
```

#### 動作確認
- 睡眠の記録が削除できた

---

## No12.ログアウト処理
#### 症状
メニューからログアウトしても、完全にログアウトできない。

#### 確認したファイル
- `logout/index.php`

#### 原因
もとからできてました

#### 修正内容
なし

```php

```

#### 動作確認
- 

---

## No13.認証状態による出し分け
#### 症状
ログイン済み用ナビは $auth_user がある場合だけ表示されるようにする。未ログイン用ナビは常に include されるため、メニューが表示される。

#### 確認したファイル
- `components/nav.php`

#### 原因
ログインされている場合やされてない場合などの条件分岐が書かれていない

#### 修正内容
条件分岐で表示されるメニューを切り替えた

```php
<?php if ($auth_user) { ?>
    <!-- TODO: $auth_user が存在する場合のナビゲーション項目を表示 -->
    <?php include BASE_DIR . 'components/user_nav.php'; ?>
<?php } else { ?>
    <!-- CTAボタン -->
    <?php include BASE_DIR . 'components/public_nav.php'; ?>
<?php } ?>
```

#### 動作確認
- ログインしているときとしていない時で表示されるメニューが変わった

---

## No14.古い入力値の復元 
#### 症状
メールアドレスが復元されない。

#### 確認したファイル
- `login/index.php`

#### 原因
ログイン失敗時のセッションを復元していないため

#### 修正内容
ログイン失敗時のセッションを復元した

```php
$old = $_SESSION['login_old'] ?? ['email' => ''];
```

#### 動作確認
- ログインに失敗したときに前回入力してたメールが復元された

---

## No15.Gemini API キー
#### 症状
Google AI Studio で Gemini API キーを発行して、健康管理の AI 分析の動作確認を行う。

#### 確認したファイル
- `env.php`

#### 原因
APIキーを書いていない

#### 修正内容
GeminiAPIキーを`env.php`に書いた

```php
const GEMINI_API_KEY = '自分のAPIキー';
```

#### 動作確認
- AI分析ができるようになった

---

## No16.CSRF トークン
#### 症状
ユーザ登録すると「不正なリクエストです。」というエラーになる。

#### 確認したファイル
- `register/input.php`

#### 原因
`input`タグの`value`が空だからCSRFトークンの中身が送られていなくて不一致になってしまっている

#### 修正内容
`value`にCSRFトークンの中身を入れた

```php
<?= htmlspecialchars($_SESSION['csrf_token']) ?>
```

#### 動作確認
- 「不正なリクエストです」というエラーが出なくなった

---

## No.17 パスワードをハッシュ化して保存する
#### 症状
ユーザ登録で SQL エラーになる。

#### 確認したファイル
- `register/store.php`

#### 原因
password_hash がないため 

#### 修正内容
パスワードをハッシュ化したものを`$posts['password_hash']`として保存した

```php
$posts['password_hash'] = password_hash($posts['password'], PASSWORD_DEFAULT);
```

#### 動作確認
- ユーザー登録ができた

---

## No.18 const url = ''
#### 症状
アクティビティグラフのグラフデータを取得できない。

#### 確認したファイル
- `js/activity_chart.js`

#### 原因
アクティビティグラフ用 API の URL が空のため

#### 修正内容
API の URL を書いた

```php
const url = 'api/activity/get';
```

#### 動作確認
- アクティビティグラフが表示された

---

## No.19 ログアウトした後にもトップページにあなたの健康データが出る
#### 症状
ログアウトしていてもトップページにあなたの健康データが表示される

#### 確認したファイル
- `./index.php`

#### 原因
「ログインしていたら」などの条件がついていないから

#### 修正内容
if文でセッションにユーザーが存在しているかの条件分を追加

```php
<?php if (isset($_SESSION['user'])) { ?>
    <?php include "components/top/hero_right.php" ?>
<?php } ?>
```

#### 動作確認
- トップページをログアウト状態で開くとあなたの健康データが表示されず、ログインした状態で開くと表示された

---

## No.20 どのアカウントでログインしても値が同じ
#### 症状
どのアカウントでログインしても、トップページのあなたの健康データの値が同じ

#### 確認したファイル
- `components/top/hero_right.php`

#### 原因
数字がそのまま書かれているから

#### 修正内容
DBから持ってきたデータを表示させた

```php
use Lib\Database;

$userId = (int) $_SESSION['user']['id'];

$pdo    = Database::getInstance();

$sql = 'SELECT COALESCE(SUM(calories_burned), 0) AS today_calories 
        FROM exercise_records 
        WHERE user_id = :user_id AND exercise_date = CURRENT_DATE';

$stmt = $pdo->prepare($sql);

$stmt->execute([':user_id' => $userId]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

$todayCalories = $row['today_calories'];


$sql = 'SELECT sleep_duration_minutes, sleep_quality 
        FROM sleep_records 
        WHERE user_id = :user_id AND sleep_date = CURRENT_DATE 
        LIMIT 1';

$stmt = $pdo->prepare($sql);

$stmt->execute([':user_id' => $userId]);

$sleep = $stmt->fetch(PDO::FETCH_ASSOC);

if ($sleep) {
    $totalMinutes = (int) $sleep['sleep_duration_minutes'];
    $hours        = floor($totalMinutes / 60);
    $minutes      = $totalMinutes % 60;
} else {
    $hours = "-";
    $minutes = "-";
}


$sql = 'SELECT meal_type, food_name 
        FROM meal_records 
        WHERE user_id = :user_id AND meal_date = CURRENT_DATE 
        ORDER BY id DESC 
        LIMIT 1';

$stmt = $pdo->prepare($sql);

$stmt->execute([':user_id' => $userId]);

$latestMeal = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$latestMeal) {
    $latestMeal = [
        'meal_type' => '-',
        'food_name' => '-' 
    ];
}

$mealLabels = [
    'breakfast' => '朝食',
    'lunch'     => '昼食',
    'dinner'    => '夕食',
    'snack'     => '間食',
    '-'         => '-' 
];
```

```html
<p class="mb-1 text-xs font-medium opacity-80">今日のアクティビティ</p>
<p class="text-4xl font-bold tracking-tight"><?= htmlentities($todayCalories) ?> Kcal</p>

<p class="text-xs text-slate-400">睡眠時間</p>
<p class="mt-1 text-lg font-bold text-slate-800"><?= htmlspecialchars($hours) ?><span class="text-sm font-medium">h</span> <?= htmlspecialchars($minutes) ?><span class="text-sm font-medium">m</span></p>

<p class="text-xs text-slate-400">消費カロリー</p>
<p class="mt-1 text-lg font-bold text-slate-800"><?= htmlspecialchars($todayCalories) ?><span class="text-smfont-medium">kcal</span></p>

<p class="text-xs font-semibold text-slate-700"><?= htmlspecialchars($mealLabels[$latestMeal['meal_type']]) ?></p>
<p class="text-xs text-slate-400"><?= htmlspecialchars($latestMeal['food_name']) ?></p>
```

#### 動作確認
- データベースに登録した通りの内容が表示された

---

## No.21 ログイン後に「ログイン」「新規登録」が表示されている
#### 症状
ログインした後も`hero_left.php`の中に「ログイン」と「新規登録」が残っているのが気持ち悪い

#### 確認したファイル
- `components/top/hero_left.php`

#### 原因
「ログインされていない」という条件がないから

#### 修正内容
セッションにユーザー情報がなければという条件を付け足した

```php
<?php if (!isset($_SESSION['user'])) { ?>
    <div class="flex flex-col gap-3 sm:flex-row justify-center">
        <a href="register/"
            class="inline-flex items-center justify-center gap-2 rounded-lg kenko-gradient
            px-8 py-3.5 text-sm font-bold text-white shadow-md shadow-sky-200
            transition hover:opacity-90 hover:shadow-lg hover:shadow-sky-300">
            ユーザ登録
        </a>
        <a href="login/"
            class="inline-flex items-center justify-center gap-2 rounded-lg border border-sky-200
            bg-white px-8 py-3.5 text-sm font-bold text-sky-700 shadow-sm
            transition hover:border-sky-300 hover:bg-sky-50">
            ログイン
        </a>
    </div>
<?php } ?>
```

#### 動作確認
- ログイン状態では、`hero_left.php`の中に「ログイン」「新規登録」は表示されなくなった

---

## No.22 目標消費カロリーを設定
#### 症状
消費カロリーの目標を設定するところがない

#### 確認したファイル
- `dashboard/index.php`

#### 原因
そもそも実装されていない

#### 修正内容
マイページに目標消費カロリーを設定する機能を実装

DBに目標消費カロリーを保存するカラムを追加する`add_target_calories_column.php`を新たに作った
```php
require_once __DIR__ . '/../app.php';

use Lib\Database;

try {
    $pdo = Database::getInstance();
    
    // カラムが存在するか確認
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'target_calories'");
    $columnExists = $stmt->fetch();
    
    if (!$columnExists) {
        // カラムを追加
        $pdo->exec("ALTER TABLE users ADD COLUMN target_calories INT DEFAULT 1000 AFTER password_hash");
        echo "Success: 'target_calories' column added to 'users' table.\n";
    } else {
        echo "Info: 'target_calories' column already exists.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

データを取得するためのAPIを修正
```php
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
```

目標消費カロリーを保存するためのAPI`api/dashboard/update_target.php`を新たに追加
```php
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
```

`dashboard/index.php`に目標消費カロリーの入力フォームを追加
```html
<!-- 目標消費カロリー設定パネル -->
<div class="rounded-xl border border-orange-100 bg-white p-5 shadow-sm flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div class="flex items-center gap-4">
        <div class="h-10 w-10 rounded-lg bg-orange-50 flex items-center justify-center text-lg">🔥</div>
        <div>
            <h2 class="text-sm font-bold text-slate-700">目標消費カロリー</h2>
            <p class="text-xs text-slate-400">現在設定されている1日の目標消費カロリーです</p>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <input type="number" id="input-target-calories" class="w-28 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-bold text-slate-800 focus:border-orange-500 focus:bg-white focus:outline-none" min="0" placeholder="1000">
        <span class="text-sm font-bold text-slate-500">Kcal</span>
        <button id="btn-save-target" class="ml-2 inline-flex items-center justify-center rounded-lg bg-orange-500 px-4 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-orange-600">
            目標を保存
        </button>
    </div>
</div>
```

`js/dashboard.js`に非同期で保存APIへ送信し、成功したらダッシュボードをリロードする処理を追加
```javascript
function renderStats(data) {
    const h = data.latest_health;

    ・・・

    el('dashboard-title').textContent = `${data.user.name}さんの健康ダッシュボード`;

    // data.user: 送られてきたデータの中のユーザー情報
    // data.user.target_calories: 目標消費カロリー
    // この二つが未定義でないかを判別
    // これだけ、data -> user -> target_calories と2階層になっているから if が必要
    // api/dashboard から受け取ったデータを画面にセットする
    if (data.user && data.user.target_calories !== undefined) {
        // el(): document.getElementById
        el('input-target-calories').value = data.user.target_calories;
    }
}

// 目標消費カロリーの保存処理
el('btn-save-target').addEventListener('click', async () => {
    const targetVal = el('input-target-calories').value;
    const targetCalories = parseInt(targetVal);

    if (isNaN(targetCalories) || targetCalories < 0) {
        alert('正しい目標消費カロリーを入力してください。');
        return;
    }

    try {
        const response = await fetch('api/dashboard/update_target.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ target_calories: targetCalories })
        });

        if (!response.ok) throw new Error();

        const resData = await response.json();
        if (resData.status === 'ok') {
            alert('目標消費カロリーを更新しました！');
            loadDashboard();
        } else {
            alert(resData.message || '更新に失敗しました。');
        }
    } catch (e) {
        alert('通信エラーが発生しました。');
    }
});
```

#### 動作確認
- 目標消費カロリーが設定できた

---

## No.
#### 症状


#### 確認したファイル
- ``

#### 原因


#### 修正内容


```php

```

#### 動作確認
- 

---

## No.
#### 症状


#### 確認したファイル
- ``

#### 原因


#### 修正内容


```php

```

#### 動作確認
- 

---

## No.
#### 症状


#### 確認したファイル
- ``

#### 原因


#### 修正内容


```php

```

#### 動作確認
- 

---
























## AI 利用について

- AI を利用したか:
- 利用した内容:
- 自分で確認した内容:

## 現状の問題点
- 
- 

## まとめ