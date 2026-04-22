<?php

/**
 * 変数定義
 */

// TODO: 変数 name : 文字列

// TODO: 変数 level : 整数

// TODO: 変数 exp_rate : 小数点を含む数値

// TODO: 変数 is_active : 真偽値 (true/false)

// TODO: 変数 last_login : null (値なし)

// TODO: 変数 items : 配列 (複数のアイテムを格納)

// TODO: 変数 status : 連想配列 (キーと値のペアでステータスを格納)
// 例: "hp" => 100, "mp" => 50, "job" => "戦士"
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>データ型デモ | PHP基礎</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-900 py-12 px-4">
    <main class="max-w-3xl mx-auto pb-20">

        <header class="text-center mb-12">
            <div class="inline-block px-3 py-1 mb-3 rounded-full bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-widest">
                Variable
            </div>
            <h2 class="text-4xl font-extrabold tracking-tight mb-2">
                <span class="text-amber-600">データ型</span>の基本
            </h2>
            <p class="text-slate-500">PHPで扱える変数の型をプレイヤーデータで確認しましょう。</p>
        </header>

        <!-- 基本型 -->
        <section class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 mb-8">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-amber-600">
                <span class="w-8 h-8 bg-amber-500 text-white rounded-lg flex items-center justify-center text-sm font-mono font-bold">1</span>
                基本型 (Scalar Types)
            </h2>
            <dl class="space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-slate-50">
                    <dt class="text-sm font-bold text-slate-400 uppercase tracking-wider">名前 <span class="text-amber-400">string</span></dt>
                    <dd class="text-sm font-mono font-bold">"<?= $name ?>"</dd>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-slate-50">
                    <dt class="text-sm font-bold text-slate-400 uppercase tracking-wider">レベル <span class="text-blue-400">int</span></dt>
                    <dd class="text-sm font-mono font-bold"><?= $level ?></dd>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-slate-50">
                    <dt class="text-sm font-bold text-slate-400 uppercase tracking-wider">経験値倍率 <span class="text-purple-400">float</span></dt>
                    <dd class="text-sm font-mono font-bold"><?= $exp_rate ?></dd>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-slate-50">
                    <dt class="text-sm font-bold text-slate-400 uppercase tracking-wider">ステータス <span class="text-rose-400">bool</span></dt>
                    <dd class="text-sm font-mono font-bold <?= $is_active ? 'text-emerald-600' : 'text-slate-400' ?>">
                        <?= $is_active ? 'true (アクティブ)' : 'false (非アクティブ)' ?>
                    </dd>
                </div>
                <div class="flex justify-between items-center py-3">
                    <dt class="text-sm font-bold text-slate-400 uppercase tracking-wider">最終ログイン <span class="text-slate-400">null</span></dt>
                    <dd class="text-sm font-mono font-bold text-slate-400">null</dd>
                </div>
            </dl>
        </section>

        <!-- 配列型 -->
        <section class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 mb-8">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-emerald-600">
                <span class="w-8 h-8 bg-emerald-500 text-white rounded-lg flex items-center justify-center text-sm font-mono font-bold">2</span>
                配列型 (array)
            </h2>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">所持アイテム</p>
            <div class="flex flex-wrap gap-2">
                <?php foreach ($items as $i => $item): ?>
                    <span class="flex items-center gap-2 bg-emerald-50 border border-emerald-100 px-4 py-2 rounded-xl text-sm font-bold text-emerald-700">
                        <span class="text-xs text-emerald-400 font-mono">[<?= $i ?>]</span>
                        <?= $item ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- 連想配列 -->
        <section class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-indigo-600">
                <span class="w-8 h-8 bg-indigo-500 text-white rounded-lg flex items-center justify-center text-sm font-mono font-bold">3</span>
                連想配列 (associative array)
            </h2>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">詳細ステータス</p>
            <dl class="space-y-3">
                <?php if (!empty($status)): ?>
                    <?php foreach ($status as $key => $value): ?>
                        <div class="flex justify-between items-center py-3 border-b border-slate-50">
                            <dt class="text-sm font-mono text-indigo-400">"<?= $key ?>"</dt>
                            <dd class="text-sm font-mono font-bold"><?= $value ?></dd>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </dl>
        </section>

        <footer class="mt-12 text-center">
            <a href="../index.php" class="text-sm font-bold text-slate-400 hover:text-amber-600 transition-colors inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                ダッシュボードに戻る
            </a>
        </footer>

    </main>
</body>

</html>