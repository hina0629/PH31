<?php

/**
 * 06_function/data_check.php
 * PHPビルトイン関数の活用（データチェック・文字列操作）
 */

// テスト用データの取得（シミュレーター用）
$testValue = $_GET['v'] ?? '  Hello, PHP Tokyo!  ';

// 1. 変数・データチェック関数
// TODO: isset, empty, is_string, is_numeric, is_null関数を使用
$results['check'] = [
    'isset'    => false,
    'empty'    => false,
    'is_string' => false,
    'is_numeric' => false,
    'is_null'   => false,
];

// 2. 文字列操作（マルチバイト対応）
$rawString = $testValue;
$trimmedString = trim($rawString);

// TODO: strlen, mb_strlen, strtoupper, strtolower関数を使用
$results['string'] = [
    'raw' => $rawString,
    'strlen' => 0,
    'mb_strlen' => 0,
    'trimmed' => $trimmedString,
    'upper' => "",
    'lower' => "",
];

// 3. 部分文字列の抽出 (substr)
// TODO: substr, mb_substr関数を使用して、文字列の一部を抽出
$results['substr'] = [
    'substr_5' => "",   // 先頭から5文字
    'mb_substr_2' => "",  // 先頭から2文字（マルチバイト対応）
];

// 4. 置換・検索
// TODO: str_replace, mb_strpos関数を使用して、文字列の置換と検索を行う
$results['replace'] = [
    // 'replace' => str_replace('PHP', '🐘', $trimmedString),
    // 'pos' => mb_strpos($trimmedString, 'PHP'), // 文字の位置を検索
];

// 5. 数値操作
$isNumeric = $results['check']['is_numeric'];
$number = $isNumeric ? $testValue : 0;

// TODO: number_format, ceil, floor, round関数を使用して、数値のフォーマットと丸め処理
$results['number'] = [
    'raw' => $number,
    'format' => "",
    'ceil' => 0,
    'floor' => 0,
    'round' => 0,
];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPビルトイン関数ラボ | PHP Function</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-900 py-4 px-4">
    <main class="max-w-5xl mx-auto">
        <!-- Header -->
        <header class="p-4 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="inline-block px-3 py-1 mb-3 rounded-full bg-emerald-100 text-emerald-700 text-sm font-black uppercase tracking-[0.2em]">
                    Standard Library Exploration
                </div>
                <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 leading-none">
                    Built-in <span class="text-emerald-600">Functions</span>
                </h1>
            </div>
            <a href="../index.php" class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                ダッシュボード
            </a>
        </header>

        <!-- Test Input UI -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 mb-2 flex flex-col md:flex-row items-center gap-2">
            <div class="grow w-full">
                <h2 class="text-lg font-bold mb-1 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    データ検証
                </h2>
                <code class="block w-full bg-slate-50 px-4 py-3 rounded-xl border border-slate-100 text-indigo-600 font-bold">
                    <?= htmlspecialchars($testValue) ?>
                </code>
            </div>
            <div class="flex gap-2 shrink-0">
                <a href="?v=こんにちは" class="px-4 py-2 bg-slate-100 rounded-xl text-xs font-bold hover:bg-slate-200 transition-colors">文字列1</a>
                <a href="?v=東京都新宿区" class="px-4 py-2 bg-slate-100 rounded-xl text-xs font-bold hover:bg-slate-200 transition-colors">文字列2</a>
                <a href="?v=12345" class="px-4 py-2 bg-slate-100 rounded-xl text-xs font-bold hover:bg-slate-200 transition-colors">数値1</a>
                <a href="?v=12800.5" class="px-4 py-2 bg-slate-100 rounded-xl text-xs font-bold hover:bg-slate-200 transition-colors">数値2</a>
                <a href="?v=" class="px-4 py-2 bg-slate-100 rounded-xl text-xs font-bold hover:bg-slate-200 transition-colors">空文字</a>
                <a href="data_check.php" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition-colors">リセット</a>
            </div>
        </div>

        <!-- Functions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

            <!-- Variable Checks -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200">
                <h2 class="text-lg font-bold mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    データ検証
                </h2>
                <div class="space-y-3">
                    <?php foreach ($results['check'] as $func => $val): ?>
                        <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <code class="text-xs font-bold text-slate-500"><?= $func ?>()</code>
                            <span class="text-xs font-black uppercase tracking-tighter <?= $val ? 'text-emerald-600' : 'text-slate-300' ?>">
                                <?= $val ? 'true' : 'false' ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- String Lengths -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200">
                <h2 class="text-lg font-bold mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 12h10m-10 5h10"></path>
                    </svg>
                    文字列の長さ
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-sky-50 p-4 rounded-2xl border border-sky-100">
                        <p class="text-sm font-black text-sky-400 uppercase tracking-widest mb-1">strlen (バイト数)</p>
                        <p class="text-3xl font-black text-sky-700"><?= $results['string']['strlen'] ?></p>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-2xl border border-indigo-100">
                        <p class="text-sm font-black text-indigo-400 uppercase tracking-widest mb-1">mb_strlen (文字数)</p>
                        <p class="text-3xl font-black text-indigo-700"><?= $results['string']['mb_strlen'] ?></p>
                    </div>
                </div>
                <p class="mt-4 text-sm text-slate-400 leading-relaxed italic">
                    ※日本語などのマルチバイト文字を正確に数えるには <code>mb_strlen</code> を使用します。
                </p>
            </div>

            <!-- String Transformation -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200">
                <h2 class="text-lg font-bold mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    変換・抽出
                </h2>
                <div class="space-y-4">
                    <div>
                        <span class="text-sm font-black text-slate-400 uppercase block mb-2">mb_substr(0, 2) - 2文字抽出</span>
                        <code class="text-sm font-bold bg-slate-100 px-3 py-1 rounded-lg text-slate-700"><?= htmlspecialchars($results['substr']['mb_substr_2']) ?></code>
                    </div>
                    <div>
                        <span class="text-sm font-black text-slate-400 uppercase block mb-2">str_replace('PHP', '🐘', ...)</span>
                        <code class="text-sm font-bold bg-slate-100 px-3 py-1 rounded-lg text-slate-700"><?= htmlspecialchars($results['replace']['replace']) ?></code>
                    </div>
                    <div>
                        <span class="text-sm font-black text-slate-400 uppercase block mb-2">trim() - 前後の空白除去</span>
                        <code class="text-sm font-bold bg-slate-100 px-3 py-1 rounded-lg text-slate-700"><?= htmlspecialchars($results['string']['trimmed']) ?></code>
                    </div>
                </div>
            </div>

            <!-- Numbers -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200">
                <h2 class="text-lg font-bold mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    数値操作
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-sm text-slate-500">元データ</span>
                        <span class="font-bold"><?= $results['number']['raw'] ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <?php if ($isNumeric): ?>
                            <span class="font-bold">数値です</span>
                        <?php else: ?>
                            <span class="font-bold text-rose-600">数値ではありません</span>
                        <?php endif; ?>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-rose-50 rounded-2xl border border-rose-100">
                        <span class="text-xs font-bold text-rose-600">number_format()</span>
                        <span class="text-xl font-black text-rose-700">&yen;<?= $results['number']['format'] ?></span>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="text-center p-2 bg-slate-50 rounded-xl border border-slate-100">
                            <p class="text-[8px] font-black text-slate-400 uppercase">ceil</p>
                            <p class="text-sm font-bold"><?= $results['number']['ceil'] ?></p>
                        </div>
                        <div class="text-center p-2 bg-slate-50 rounded-xl border border-slate-100">
                            <p class="text-[8px] font-black text-slate-400 uppercase">floor</p>
                            <p class="text-sm font-bold"><?= $results['number']['floor'] ?></p>
                        </div>
                        <div class="text-center p-2 bg-slate-50 rounded-xl border border-slate-100">
                            <p class="text-[8px] font-black text-slate-400 uppercase">round</p>
                            <p class="text-sm font-bold"><?= $results['number']['round'] ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <footer class="mt-16 text-center text-slate-400 text-sm">
            <p>&copy; 2026 Built-in Function Lab. 実践的なPHP関数の学習サンプル。</p>
        </footer>
    </main>
</body>

</html>