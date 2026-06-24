<?php
require_once '../app.php';

$structureSections = [
    [
        'title' => 'Bootstrap / Config',
        'description' => 'アプリ全体の起点と設定をまとめるレイヤです。',
        'items' => [
            ['app.php', '定数定義、セッション開始、ライブラリ・モデル・コントローラ読み込み'],
            ['index.php', 'ルートアクセスを home/ にリダイレクト'],
            ['env.php / env.local.php / env.sample.php', 'DB 接続やアプリ設定の定義'],
        ],
    ],
    [
        'title' => 'Entry Points',
        'description' => 'URL ごとの入口ファイルです。各ファイルがコントローラや API 処理へ橋渡しします。',
        'items' => [
            ['about/', '公開 About ページ'],
            ['login/・register/', '認証系の画面と実行アクション'],
            ['home/・user/', 'ログイン後の画面、投稿、プロフィール系アクション'],
            ['api/', 'いいね・返信の JSON API'],
        ],
    ],
    [
        'title' => 'Application Layer',
        'description' => 'ドメインロジックと画面描画を担うアプリ本体です。',
        'items' => [
            ['app/controllers/', '画面遷移や入力処理を担当'],
            ['app/services/', '複数モデルをまたぐ整形処理を担当'],
            ['app/models/', 'users / tweets / likes / follows / replies を操作'],
            ['app/requests/', 'フォームバリデーションを担当'],
            ['app/views/', 'layout + 画面 view + 共通 components'],
        ],
    ],
    [
        'title' => 'Shared Library / Assets',
        'description' => '共通ユーティリティとフロント資産です。',
        'items' => [
            ['lib/', 'Database, Request, View, Sanitize, File, Csrf'],
            ['js/', '共通 UI、画像プレビュー、投稿 UI'],
            ['images/', '固定画像とアップロード画像'],
            ['svg/', 'ナビゲーションや UI アイコン'],
        ],
    ],
];

$routeGroups = [
    [
        'title' => 'Public Routes',
        'rows' => [
            ['GET', '/', 'index.php', '-', '公開', 'home/ へリダイレクト'],
            ['GET', 'about/', 'about/index.php', '-', '公開', '構成・ルーティング・DB 設計の説明ページ'],
            ['GET', 'register/', 'register/index.php', 'RegisterController::index()', '公開', 'register/input.php へ誘導'],
            ['GET', 'register/input.php', 'register/input.php', 'RegisterController::input()', '公開', '登録フォーム表示'],
            ['POST', 'register/add.php', 'register/add.php', 'RegisterController::add()', '公開', 'ユーザ登録実行'],
            ['GET', 'register/result.php', 'register/result.php', 'RegisterController::result()', '公開', '登録完了画面'],
            ['GET', 'login/', 'login/index.php', 'LoginController::index()', '公開', 'login/input.php へ誘導'],
            ['GET', 'login/input.php', 'login/input.php', 'LoginController::input()', '公開', 'ログインフォーム表示'],
            ['POST', 'login/auth.php', 'login/auth.php', 'LoginController::auth()', '公開', '認証してセッション保存'],
        ],
    ],
    [
        'title' => 'Home Routes',
        'rows' => [
            ['GET', 'home/', 'home/index.php', 'HomeController::index()', '要ログイン', 'tab=public / followers を切り替え'],
            ['GET', 'home/detail.php?id={tweetId}', 'home/detail.php', 'HomeController::detail()', '要ログイン', '投稿詳細と返信一覧'],
            ['GET', 'home/search.php?keyword={keyword}', 'home/search.php', 'HomeController::search()', '要ログイン', 'ハッシュタグ・本文検索'],
            ['GET', 'home/garally.php', 'home/garally.php', 'HomeController::garally()', '要ログイン', '画像付き投稿の一覧'],
            ['GET', 'home/user_tweets.php?id={userId}', 'home/user_tweets.php', 'HomeController::user_tweets()', '要ログイン', '指定ユーザの投稿一覧'],
            ['POST', 'home/add.php', 'home/add.php', 'HomeController::add()', '要ログイン', '投稿作成'],
            ['POST', 'home/delete.php', 'home/delete.php', 'HomeController::delete()', '要ログイン', '投稿削除'],
        ],
    ],
    [
        'title' => 'User Routes',
        'rows' => [
            ['GET', 'user/?id={userId}', 'user/index.php', 'UserController::index()', '要ログイン', 'プロフィールと投稿一覧'],
            ['GET', 'user/edit.php', 'user/edit.php', 'UserController::edit()', '要ログイン', 'プロフィール編集'],
            ['POST', 'user/update.php', 'user/update.php', 'UserController::update()', '要ログイン', '表示名・自己紹介を更新'],
            ['GET', 'user/logout.php', 'user/logout.php', 'UserController::logout()', '要ログイン', 'ログアウトして login/ へ遷移'],
            ['POST', 'user/follow.php', 'user/follow.php', 'UserController::follow()', '要ログイン', 'フォロー切り替え'],
            ['POST', 'user/unfollow.php', 'user/unfollow.php', 'UserController::unfollow()', '要ログイン', 'アンフォロー切り替え'],
            ['GET', 'user/following.php?id={userId}', 'user/following.php', 'UserController::following()', '要ログイン', 'フォロー中一覧'],
            ['GET', 'user/followers.php?id={userId}', 'user/followers.php', 'UserController::followers()', '要ログイン', 'フォロワー一覧'],
            ['POST', 'user/upload_profile_image.php', 'user/upload_profile_image.php', 'UserController::uploadProfileImage()', '要ログイン', 'プロフィール画像アップロード'],
        ],
    ],
    [
        'title' => 'JSON API',
        'rows' => [
            ['POST', 'api/like/update.php', 'api/like/update.php', 'Like model direct call', '要ログイン', 'いいねをトグルして JSON を返す'],
            ['POST', 'api/reply/add.php', 'api/reply/add.php', 'Reply model direct call', '要ログイン', '返信を作成して JSON を返す'],
        ],
    ],
];

$dbTables = [
    [
        'name' => 'users',
        'purpose' => 'ユーザの認証情報とプロフィール情報を保持します。',
        'columns' => [
            ['id', 'BIGINT', 'PK', 'ユーザID'],
            ['account_name', 'VARCHAR(255)', 'UNIQUE / NOT NULL', 'ログインに使うアカウント名'],
            ['email', 'VARCHAR(255)', 'UNIQUE / NOT NULL', 'メールアドレス'],
            ['display_name', 'VARCHAR(255)', 'NOT NULL', '画面表示名'],
            ['password', 'VARCHAR(255)', 'NOT NULL', 'パスワードハッシュ'],
            ['profile', 'TEXT', 'NULL', '自己紹介'],
            ['profile_image', 'TEXT', 'NULL', 'プロフィール画像パス'],
            ['created_at', 'DATETIME', 'DEFAULT CURRENT_TIMESTAMP', '作成日時'],
            ['updated_at', 'DATETIME', 'AUTO UPDATE 想定', '更新日時'],
        ],
        'relations' => '1 user : N tweets / replies / follows / likes',
    ],
    [
        'name' => 'tweets',
        'purpose' => '投稿本文と添付画像を保持します。',
        'columns' => [
            ['id', 'BIGINT', 'PK', '投稿ID'],
            ['user_id', 'BIGINT', 'FK -> users.id', '投稿者ユーザID'],
            ['message', 'TEXT', 'NOT NULL', '投稿本文'],
            ['image_path', 'TEXT', 'NULL', '添付画像パス'],
            ['created_at', 'DATETIME', 'DEFAULT CURRENT_TIMESTAMP', '投稿日時'],
            ['updated_at', 'DATETIME', 'AUTO UPDATE 想定', '更新日時'],
        ],
        'relations' => '1 tweet : N likes / replies',
    ],
    [
        'name' => 'replies',
        'purpose' => '投稿への返信を保持します。',
        'columns' => [
            ['id', 'BIGINT', 'PK', '返信ID'],
            ['tweet_id', 'BIGINT', 'FK -> tweets.id', '対象投稿ID'],
            ['user_id', 'BIGINT', 'FK -> users.id', '返信者ユーザID'],
            ['message', 'TEXT', 'NOT NULL', '返信本文'],
            ['created_at', 'DATETIME', 'DEFAULT CURRENT_TIMESTAMP', '返信日時'],
        ],
        'relations' => 'tweet と user の中間にぶら下がる明細',
    ],
    [
        'name' => 'likes',
        'purpose' => 'ユーザが投稿に付けたいいねを保持します。',
        'columns' => [
            ['id', 'BIGINT', 'PK', 'いいねID'],
            ['tweet_id', 'BIGINT', 'FK -> tweets.id', '対象投稿ID'],
            ['user_id', 'BIGINT', 'FK -> users.id', 'いいねしたユーザID'],
            ['created_at', 'DATETIME', 'DEFAULT CURRENT_TIMESTAMP', '作成日時'],
        ],
        'relations' => 'user と tweet の多対多を表す中間テーブル',
    ],
    [
        'name' => 'follows',
        'purpose' => 'ユーザ同士のフォロー関係を保持します。',
        'columns' => [
            ['follower_id', 'BIGINT', 'FK -> users.id', 'フォローする側のユーザID'],
            ['followee_id', 'BIGINT', 'FK -> users.id', 'フォローされる側のユーザID'],
            ['created_at', 'DATETIME', 'DEFAULT CURRENT_TIMESTAMP', 'フォロー日時'],
        ],
        'relations' => 'user と user の自己参照多対多',
    ],
];

$recommendedIndexes = [
    ['users', 'UNIQUE(account_name), UNIQUE(email)', '認証と重複防止'],
    ['tweets', 'INDEX(user_id), INDEX(created_at)', 'プロフィール表示とタイムライン表示'],
    ['replies', 'INDEX(tweet_id), INDEX(user_id)', '投稿詳細と返信一覧'],
    ['likes', 'UNIQUE(tweet_id, user_id), INDEX(tweet_id)', '重複いいね防止と件数集計'],
    ['follows', 'UNIQUE(follower_id, followee_id), INDEX(follower_id), INDEX(followee_id)', '重複フォロー防止とフォロー一覧'],
];
?>

<!DOCTYPE html>
<html lang="ja">

<?php include COMPONENT_DIR . 'head.php'; ?>

<body class="bg-white text-slate-900 antialiased min-h-screen">
    <?php include COMPONENT_DIR . 'public_nav.php'; ?>

    <main class="max-w-6xl mx-auto px-6 py-10">
        <section class="mb-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-500">About Project</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">ファイル構成・ルーティング・DB 設計</h1>
                    <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-500">
                        この SNS アプリの現在の実装を基準に、プロジェクト構成を整理し直したページです。
                        情報量が多いため、<span class="font-semibold text-slate-700">ファイル構成</span>・<span class="font-semibold text-slate-700">ルーティング</span>・<span class="font-semibold text-slate-700">DB 設計</span>をタブで切り替えられるようにしています。
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-3 text-xs">
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3">
                        <p class="text-slate-400">Views</p>
                        <p class="mt-1 text-xl font-bold text-slate-800">17+</p>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3">
                        <p class="text-slate-400">Routes</p>
                        <p class="mt-1 text-xl font-bold text-slate-800">20+</p>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3">
                        <p class="text-slate-400">Tables</p>
                        <p class="mt-1 text-xl font-bold text-slate-800">5</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-8 rounded-3xl border border-slate-100 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-4 py-4 sm:px-6">
                <div class="flex flex-wrap gap-2" role="tablist" aria-label="About tabs">
                    <button type="button" class="about-tab-btn rounded-full bg-sky-500 px-4 py-2 text-sm font-semibold text-white" data-tab-target="structure" aria-selected="true">
                        ファイル構成
                    </button>
                    <button type="button" class="about-tab-btn rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600" data-tab-target="routing" aria-selected="false">
                        ルーティング
                    </button>
                    <button type="button" class="about-tab-btn rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600" data-tab-target="database" aria-selected="false">
                        DB 設計
                    </button>
                </div>
            </div>

            <div class="p-4 sm:p-6">
                <section class="about-tab-panel" data-tab-panel="structure">
                    <div class="mb-6 rounded-2xl border border-slate-100 bg-slate-50 px-5 py-4">
                        <h2 class="text-base font-bold text-slate-800">プロジェクトツリー</h2>
                        <p class="mt-1 text-sm text-slate-500">エントリポイント、アプリ層、共通ライブラリ、フロント資産に分かれています。</p>
                        <pre class="mt-4 overflow-x-auto rounded-2xl bg-slate-900 px-4 py-4 text-xs leading-6 text-slate-100">20_php_sns/
├─ app.php
├─ env.php / env.local.php / env.sample.php
├─ about/
│  └─ index.php
├─ login/
│  ├─ index.php
│  ├─ input.php
│  └─ auth.php
├─ register/
│  ├─ index.php
│  ├─ input.php
│  ├─ add.php
│  └─ result.php
├─ home/
│  ├─ index.php
│  ├─ detail.php
│  ├─ search.php
│  ├─ garally.php
│  ├─ add.php
│  ├─ delete.php
│  └─ user_tweets.php
├─ user/
│  ├─ index.php
│  ├─ edit.php
│  ├─ update.php
│  ├─ follow.php / unfollow.php
│  ├─ following.php / followers.php
│  ├─ upload_profile_image.php
│  └─ logout.php
├─ api/
│  ├─ like/update.php
│  └─ reply/add.php
├─ app/
│  ├─ controllers/
│  ├─ models/
│  ├─ requests/
│  ├─ services/
│  └─ views/
├─ lib/
├─ js/
├─ images/
└─ svg/</pre>
                    </div>

                    <div class="grid gap-4 lg:grid-cols-2">
                        <?php foreach ($structureSections as $section) : ?>
                            <article class="rounded-2xl border border-slate-100 bg-white p-5">
                                <h3 class="text-base font-bold text-slate-800"><?= h($section['title']) ?></h3>
                                <p class="mt-1 text-sm text-slate-500"><?= h($section['description']) ?></p>
                                <ul class="mt-4 space-y-3 text-sm">
                                    <?php foreach ($section['items'] as [$path, $description]) : ?>
                                        <li class="rounded-2xl bg-slate-50 px-4 py-3">
                                            <p class="font-mono text-sky-700"><?= h($path) ?></p>
                                            <p class="mt-1 text-slate-500"><?= h($description) ?></p>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-6 rounded-2xl border border-slate-100 bg-white p-5">
                        <h3 class="text-base font-bold text-slate-800">リクエストの流れ</h3>
                        <div class="mt-4 grid gap-3 md:grid-cols-5">
                            <div class="rounded-2xl bg-slate-50 px-4 py-4 text-sm">
                                <p class="font-semibold text-slate-700">1. Entry Point</p>
                                <p class="mt-1 text-slate-500">`home/index.php` などの入口ファイルを実行</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 px-4 py-4 text-sm">
                                <p class="font-semibold text-slate-700">2. Controller</p>
                                <p class="mt-1 text-slate-500">入力確認、認証、リダイレクト判断</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 px-4 py-4 text-sm">
                                <p class="font-semibold text-slate-700">3. Service</p>
                                <p class="mt-1 text-slate-500">TweetService が投稿や返信を整形</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 px-4 py-4 text-sm">
                                <p class="font-semibold text-slate-700">4. Model</p>
                                <p class="mt-1 text-slate-500">PDO で DB から取得・更新</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 px-4 py-4 text-sm">
                                <p class="font-semibold text-slate-700">5. View</p>
                                <p class="mt-1 text-slate-500">layout.view.php と各 view で描画</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="about-tab-panel hidden" data-tab-panel="routing">
                    <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-800">
                        ルーティングはフレームワークのルータではなく、<span class="font-semibold">各 PHP ファイルが直接エントリポイント</span>になる構成です。
                        入口ファイルで `require_once '../app.php'` を行い、その後コントローラの対応アクションを呼び出します。
                    </div>

                    <div class="space-y-6">
                        <?php foreach ($routeGroups as $group) : ?>
                            <section>
                                <div class="mb-3 flex items-center justify-between">
                                    <h2 class="text-base font-bold text-slate-800"><?= h($group['title']) ?></h2>
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500"><?= count($group['rows']) ?> routes</span>
                                </div>
                                <div class="overflow-x-auto rounded-2xl border border-slate-100">
                                    <table class="min-w-full text-sm">
                                        <thead class="bg-slate-50 text-left text-slate-600">
                                            <tr class="border-b border-slate-100">
                                                <th class="px-4 py-3 font-semibold">Method</th>
                                                <th class="px-4 py-3 font-semibold">Path</th>
                                                <th class="px-4 py-3 font-semibold">Entry File</th>
                                                <th class="px-4 py-3 font-semibold">Action</th>
                                                <th class="px-4 py-3 font-semibold">Auth</th>
                                                <th class="px-4 py-3 font-semibold">Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 bg-white text-slate-600">
                                            <?php foreach ($group['rows'] as [$method, $path, $file, $action, $auth, $note]) : ?>
                                                <?php
                                                $methodClass = $method === 'GET'
                                                    ? 'bg-emerald-100 text-emerald-700'
                                                    : 'bg-sky-100 text-sky-700';
                                                $authClass = $auth === '公開'
                                                    ? 'bg-slate-100 text-slate-600'
                                                    : 'bg-rose-100 text-rose-700';
                                                ?>
                                                <tr class="hover:bg-slate-50">
                                                    <td class="px-4 py-3">
                                                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold <?= $methodClass ?>"><?= h($method) ?></span>
                                                    </td>
                                                    <td class="px-4 py-3 font-mono text-sky-700"><?= h($path) ?></td>
                                                    <td class="px-4 py-3 font-mono text-slate-500"><?= h($file) ?></td>
                                                    <td class="px-4 py-3 font-mono text-slate-700"><?= h($action) ?></td>
                                                    <td class="px-4 py-3">
                                                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold <?= $authClass ?>"><?= h($auth) ?></span>
                                                    </td>
                                                    <td class="px-4 py-3 text-slate-500"><?= h($note) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        <?php endforeach; ?>
                    </div>
                </section>

                <section class="about-tab-panel hidden" data-tab-panel="database">
                    <div class="grid gap-4 lg:grid-cols-[1.1fr_0.9fr]">
                        <div class="rounded-2xl border border-slate-100 bg-white p-5">
                            <h2 class="text-base font-bold text-slate-800">ER の考え方</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                このプロジェクトには `docs/schema.sql` が見当たらなかったため、
                                <span class="font-semibold text-slate-700">モデル・SQL・JOIN</span> で使われている実装を元に DB 設計を再構成しています。
                            </p>
                            <div class="mt-4 rounded-2xl bg-slate-900 px-4 py-4 text-xs leading-6 text-slate-100">
                                users 1 ── N tweets<br>
                                users 1 ── N replies<br>
                                users N ── N tweets (likes)<br>
                                users N ── N users (follows)<br>
                                tweets 1 ── N replies<br>
                                tweets 1 ── N likes
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                            <h2 class="text-base font-bold text-slate-800">実装上のポイント</h2>
                            <ul class="mt-3 space-y-3 text-sm text-slate-600">
                                <li class="rounded-2xl bg-white px-4 py-3">タイムライン取得では `tweets` を起点に `users`・`likes`・`replies` を JOIN しています。</li>
                                <li class="rounded-2xl bg-white px-4 py-3">プロフィール画面では `tweets` 件数、`follows` 件数、`followers` 件数を個別に集計します。</li>
                                <li class="rounded-2xl bg-white px-4 py-3">`likes` と `follows` は中間テーブルなので、重複防止の複合 UNIQUE が実用上重要です。</li>
                                <li class="rounded-2xl bg-white px-4 py-3">画像パスは DB に文字列で保存し、実ファイルは `images/` 配下に配置しています。</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6 space-y-6">
                        <?php foreach ($dbTables as $table) : ?>
                            <section class="rounded-2xl border border-slate-100 bg-white p-5">
                                <div class="flex flex-col gap-2 border-b border-slate-100 pb-4 sm:flex-row sm:items-end sm:justify-between">
                                    <div>
                                        <h3 class="font-mono text-lg font-bold text-sky-700"><?= h($table['name']) ?></h3>
                                        <p class="mt-1 text-sm text-slate-500"><?= h($table['purpose']) ?></p>
                                    </div>
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500"><?= h($table['relations']) ?></span>
                                </div>

                                <div class="mt-4 overflow-x-auto rounded-2xl border border-slate-100">
                                    <table class="min-w-full text-sm">
                                        <thead class="bg-slate-50 text-left text-slate-600">
                                            <tr class="border-b border-slate-100">
                                                <th class="px-4 py-3 font-semibold">Column</th>
                                                <th class="px-4 py-3 font-semibold">Type</th>
                                                <th class="px-4 py-3 font-semibold">Constraint</th>
                                                <th class="px-4 py-3 font-semibold">Description</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            <?php foreach ($table['columns'] as [$column, $type, $constraint, $description]) : ?>
                                                <tr class="hover:bg-slate-50">
                                                    <td class="px-4 py-3 font-mono text-sky-700"><?= h($column) ?></td>
                                                    <td class="px-4 py-3 font-mono text-slate-500"><?= h($type) ?></td>
                                                    <td class="px-4 py-3 text-slate-500"><?= h($constraint) ?></td>
                                                    <td class="px-4 py-3 text-slate-500"><?= h($description) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-6 rounded-2xl border border-slate-100 bg-white p-5">
                        <h3 class="text-base font-bold text-slate-800">推奨インデックス</h3>
                        <div class="mt-4 overflow-x-auto rounded-2xl border border-slate-100">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-50 text-left text-slate-600">
                                    <tr class="border-b border-slate-100">
                                        <th class="px-4 py-3 font-semibold">Table</th>
                                        <th class="px-4 py-3 font-semibold">Index / Constraint</th>
                                        <th class="px-4 py-3 font-semibold">Reason</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 bg-white">
                                    <?php foreach ($recommendedIndexes as [$table, $index, $reason]) : ?>
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-4 py-3 font-mono text-sky-700"><?= h($table) ?></td>
                                            <td class="px-4 py-3 font-mono text-slate-500"><?= h($index) ?></td>
                                            <td class="px-4 py-3 text-slate-500"><?= h($reason) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.about-tab-btn');
            const panels = document.querySelectorAll('.about-tab-panel');

            buttons.forEach((button) => {
                button.addEventListener('click', function () {
                    const target = button.dataset.tabTarget;

                    buttons.forEach((item) => {
                        const active = item === button;
                        item.setAttribute('aria-selected', active ? 'true' : 'false');
                        item.classList.toggle('bg-sky-500', active);
                        item.classList.toggle('text-white', active);
                        item.classList.toggle('bg-slate-100', !active);
                        item.classList.toggle('text-slate-600', !active);
                    });

                    panels.forEach((panel) => {
                        panel.classList.toggle('hidden', panel.dataset.tabPanel !== target);
                    });
                });
            });
        });
    </script>
</body>

</html>
