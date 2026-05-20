<?php
// テスト用ユーザーデータ
$testUser = [
    'name' => '田中 太郎',
    'role' => 'プレミアム会員',
    'avatar' => 'images/user-icon.svg'
];

// ナビゲーション項目
$navItems = [
    ['label' => 'ホーム', 'path' => '#'],
    ['label' => 'サービス一覧', 'path' => '#'],
    ['label' => 'お知らせ', 'path' => '#'],
    ['label' => 'お問い合わせ', 'path' => '#'],
];

// 認証フラグ（URLパラメータ ?auth=1 でログイン状態をシミュレート）
$isAuth = isset($_GET['auth']) && $_GET['auth'] === '1';

// ユーザーデータ（ログイン時のみ使用）
$user = $isAuth ? $testUser : null;
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ナビゲーション制御 | PHP Condition</title>
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased bg-slate-50 text-slate-900">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 nav-blur border-b border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-200">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-slate-900">PHP <span class="text-indigo-600">App</span></span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <?php foreach ($navItems as $item): ?>
                        <a href="<?= $item['path'] ?>" class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
                            <?= $item['label'] ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- Auth Section -->
                <div class="flex items-center gap-4">
                    <!-- TODO: コロン構文 if: isAuth で分岐 -->
                        <!-- Logged In -->
                        <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-bold text-slate-900"><?= $user['name'] ?></p>
                                <p class="text-[10px] text-indigo-500 font-medium uppercase"><?= $user['role'] ?></p>
                            </div>
                            <img src="<?= $user['avatar'] ?>" alt="User" class="w-9 h-9 rounded-full ring-2 ring-indigo-50 ring-offset-2">
                            <a href="?auth=0" class="text-xs font-bold text-slate-400 hover:text-rose-500 transition-colors">ログアウト</a>
                        </div>

                        <!-- Not Logged In -->
                        <div class="flex items-center gap-3">
                            <a href="?auth=1" class="text-sm font-semibold text-slate-600 hover:text-slate-900">ログイン</a>
                            <a href="?auth=1" class="text-sm font-bold bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 shadow-md shadow-indigo-100 transition-all">新規登録</a>
                        </div>

                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-32 pb-20 px-4">
        <div class="max-w-3xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                Current State: <?= $isAuth ? 'Authenticated' : 'Guest Mode' ?>
            </div>

            <h1 class="text-5xl font-black text-slate-900 tracking-tight mb-6">
                条件分岐による<br><span class="text-indigo-600">表示コンテンツの制御</span>
            </h1>

            <p class="text-lg text-slate-500 leading-relaxed mb-10">
                このサンプルでは、PHPの <code>if</code> 文を使用してユーザーのログイン状態（認証フラグ）を判定し、ヘッダー内のメニュー項目やボタンの出し分けを行っています。
            </p>

            <!-- Test Controls -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="?auth=1" class="flex items-center justify-between p-6 rounded-3xl bg-white border border-slate-200 hover:border-indigo-300 transition-all group shadow-sm">
                    <div class="text-left">
                        <p class="font-bold text-slate-900">ログイン状態</p>
                        <p class="text-xs text-slate-400">ユーザー情報を表示します</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </a>
                <a href="?auth=0" class="flex items-center justify-between p-6 rounded-3xl bg-white border border-slate-200 hover:border-slate-300 transition-all group shadow-sm">
                    <div class="text-left">
                        <p class="font-bold text-slate-900">ログアウト状態</p>
                        <p class="text-xs text-slate-400">ログイン・登録ボタンを表示します</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-slate-900 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </main>

    <footer class="text-center py-10 border-t border-slate-200 mx-10">
        <a href="../index.php" class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            ダッシュボードに戻る
        </a>
    </footer>
</body>

</html>