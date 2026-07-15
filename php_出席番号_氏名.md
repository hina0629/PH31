# Kenko Log 未完成箇所調査レポート

## 提出者

- 学籍番号:40868
- 氏名:兒玉晃奈
- 調査日:2026/06/24



## 調査した項目一覧
1. No.1: DB 接続情報 
2. No.2: トップページのキャッチコピー
3. No.3: クレジットで「2022」部分を今年で表示
4. No.4: 心拍数(bpm)表示
5. No.5: 健康管理の記録の追加
6. No.6: 健康管理の編集画面表示
7. No.7: 健康管理のCSVダウンロード
8. No.8: アクティビティ種別の表示 
9. No.9: アクティビティの記録追加 
10. No.10: 食事種別表示
11. No.11: 睡眠データ削除
12. No.12: ログアウト処理
13. No.13: 認証状態による出し分け
14. No.14: 古い入力値の復元 
15. No.15: Gemini API キー
16. No.16: CSRF トークン
17. No.17: パスワードをハッシュ化して保存する
18. No.18: const url = ''
19. No.19: ログアウトした後にもトップページにあなたの健康データが出る
20. No.20: どのアカウントでログインしても値が同じ

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