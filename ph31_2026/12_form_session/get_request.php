<?php

/**
 * 07_form_session/get_request.php
 * GETリクエストの送受信テスト
 */

// TODO: GETデータの取得
$queries = [];

// TODO: keyword チェック
$keyword = $queries[''] ?? '';
// TODO: category チェック
$category = $queries[''] ?? '';
// TODO: SERVERグローバル変数からリクエストURIを取得
$uri = $_SERVER['REQUEST_URI'] ?? '';
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GETリクエスト・ラボ | PHP Form & Session</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Outfit:wght@600;800&family=Noto+Sans+JP:wght@400;700;900&display=swap" rel="stylesheet">
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', 'Noto Sans JP', sans-serif;
        }

        .font-outfit {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-slate-50 text-slate-900 py-12 px-4">
    <main class="max-w-2xl mx-auto">
        <!-- Header -->
        <header class="text-center mb-12">
            <div class="inline-block px-3 py-1 mb-3 rounded-full bg-sky-100 text-sky-700 text-[10px] font-black uppercase tracking-[0.2em]">
                HTTP Request Method: GET
            </div>
            <h1 class="font-outfit text-4xl font-extrabold tracking-tight text-slate-900 leading-none">
                GET Request <span class="text-sky-600">Lab</span>
            </h1>
            <p class="text-slate-500 mt-4 text-sm leading-relaxed">
                URLの末尾に情報を付加して送信する <code>GET</code> メソッドの仕組みを体験しましょう。
            </p>
        </header>

        <!-- Main Card -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200 overflow-hidden border border-white">
            <!-- Form Section -->
            <div class="p-10 border-b border-slate-50">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-sky-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-sky-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-black tracking-tight">検索シミュレーター</h2>
                </div>

                <form action="" method="get" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="keyword" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">キーワード</label>
                            <!-- TODO: name=keyword -->
                            <input type="text" name="" id="keyword"
                                class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:border-sky-500 focus:ring-4 focus:ring-sky-50 transition-all text-sm outline-none font-bold"
                                placeholder="例：PHP 8.x"
                                value="<?= htmlspecialchars($keyword) ?>">
                        </div>
                        <div class="space-y-2">
                            <label for="category" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">カテゴリ</label>
                            <!-- TODO: name=category -->
                            <input type="text" name="" id="category"
                                class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:border-sky-500 focus:ring-4 focus:ring-sky-50 transition-all text-sm outline-none font-bold"
                                placeholder="例：プログラミング"
                                value="<?= htmlspecialchars($category) ?>">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-sky-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-sky-100 hover:bg-sky-700 active:scale-[0.98] transition-all text-sm">
                        GETリクエストを送信
                    </button>
                </form>
            </div>

            <!-- Result Section -->
            <div class="bg-slate-50 p-10">
                <?php if (empty($queries)): ?>
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-200 text-slate-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-slate-400">フォームを送信してデータを確認してください</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Received Data</h3>
                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-600 text-[10px] font-black">ACTIVE</span>
                        </div>

                        <div class="grid grid-cols-1 gap-3">
                            <?php foreach ($queries as $key => $value): ?>
                                <div class="bg-white p-4 rounded-2xl border border-slate-200 flex justify-between items-center shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <span class="w-2 h-2 rounded-full bg-sky-400"></span>
                                        <span class="text-xs font-mono font-bold text-slate-400"><?= htmlspecialchars($key) ?></span>
                                    </div>
                                    <span class="text-sm font-bold text-sky-700"><?= htmlspecialchars($value) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="mt-6 p-4 rounded-xl bg-sky-50 border border-sky-100">
                            <p class="text-[10px] font-bold text-sky-600 mb-1 uppercase tracking-wider">Generated URL</p>
                            <code class="text-[10px] text-sky-800 break-all leading-relaxed">
                                <?= htmlspecialchars($uri) ?>
                            </code>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>