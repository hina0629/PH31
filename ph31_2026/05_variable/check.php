<?php

/**
 * データ型の確認とデバッグ
 */

// TODO: 型の変数
// 文字列
$v1 = null;
// 整数
$v2 = null;
// 浮動小数点
$v3 = null;
// ブール
$v4 = null;
// NULL
$v5 = null;
// Array
$v6 = null;

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>型チェック | PHP基礎</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-900 py-12 px-4">
    <main class="max-w-3xl mx-auto pb-20">

        <header class="text-center mb-12">
            <div class="inline-block px-3 py-1 mb-3 rounded-full bg-rose-100 text-rose-700 text-xs font-bold uppercase tracking-widest">
                Debug
            </div>
            <h2 class="text-4xl font-extrabold tracking-tight mb-2">
                <span class="text-rose-600">型チェック</span>とデバッグ
            </h2>
            <p class="text-slate-500"><code class="bg-slate-100 text-rose-600 px-2 py-0.5 rounded-md text-sm font-mono">var_dump()</code> で変数の中身と型を確認しましょう。</p>
        </header>

        <!-- Section 1: 基本的な型の確認 -->
        <section class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 mb-8">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-rose-600">
                <span class="w-8 h-8 bg-rose-500 text-white rounded-lg flex items-center justify-center text-sm font-mono font-bold">1</span>
                基本的な型の確認
            </h2>
            <div class="space-y-4 font-mono text-sm">
                <div>
                    <p class="text-slate-400 mb-2">$v1 = <span class="text-amber-600">"100"</span>; <span class="text-slate-300">// string</span></p>
                    <pre class="bg-slate-900 text-emerald-400 p-4 rounded-2xl"><?php var_dump($v1); ?></pre>
                </div>
                <div>
                    <p class="text-slate-400 mb-2">$v2 = <span class="text-blue-600">100</span>; <span class="text-slate-300">// int</span></p>
                    <pre class="bg-slate-900 text-emerald-400 p-4 rounded-2xl"><?php var_dump($v2); ?></pre>
                </div>
                <div>
                    <p class="text-slate-400 mb-2">$v3 = <span class="text-purple-600">100.0</span>; <span class="text-slate-300">// float</span></p>
                    <pre class="bg-slate-900 text-emerald-400 p-4 rounded-2xl"><?php var_dump($v3); ?></pre>
                </div>
            </div>
        </section>

        <!-- Section 2: 比較演算と型の挙動 -->
        <section class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 mb-8">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-blue-600">
                <span class="w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center text-sm font-mono font-bold">2</span>
                比較演算と型の挙動
            </h2>
            <div class="space-y-3 font-mono text-sm">
                <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                    <span class="text-slate-500">"100" <span class="text-blue-600 font-bold">==</span> 100 &nbsp;<span class="text-slate-400 font-sans text-xs">// 値の比較</span></span>
                    <span class="font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-3 py-1 rounded-lg"><?php var_dump($v1 == $v2); ?></span>
                </div>
                <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                    <span class="text-slate-500">"100" <span class="text-rose-600 font-bold">===</span> 100 &nbsp;<span class="text-slate-400 font-sans text-xs">// 型まで比較</span></span>
                    <span class="font-bold text-rose-600 bg-rose-50 border border-rose-100 px-3 py-1 rounded-lg"><?php var_dump($v1 === $v2); ?></span>
                </div>
            </div>
            <p class="mt-4 text-xs text-slate-400 leading-relaxed">
                <code class="bg-slate-100 px-1 rounded">==</code> は値だけ比較するため <code class="bg-slate-100 px-1 rounded">"100"</code> と <code class="bg-slate-100 px-1 rounded">100</code> は一致します。
                <code class="bg-slate-100 px-1 rounded">===</code> は型も含めて比較するため不一致になります。
            </p>
        </section>

        <!-- Section 3: 自動型変換（型ジャグリング） -->
        <section class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-amber-600">
                <span class="w-8 h-8 bg-amber-500 text-white rounded-lg flex items-center justify-center text-sm font-mono font-bold">3</span>
                自動型変換（型ジャグリング）
            </h2>
            <div class="font-mono text-sm">
                <p class="text-slate-400 mb-2">$v1 + 50 &nbsp;<span class="text-slate-300 font-sans text-xs">// "100" (string) + 50 (int)</span></p>
                <pre class="bg-slate-900 text-amber-400 p-4 rounded-2xl"><?php var_dump($v1 + 50); ?></pre>
            </div>
            <p class="mt-4 text-xs text-slate-400 leading-relaxed">
                文字列 <code class="bg-slate-100 px-1 rounded">"100"</code> に数値を足すと、PHPは自動的に文字列を数値として解釈します。
                これを<strong class="text-slate-600">型ジャグリング (Type Juggling)</strong> と呼びます。
            </p>
        </section>

        <footer class="mt-12 text-center">
            <a href="../index.php" class="text-sm font-bold text-slate-400 hover:text-rose-600 transition-colors inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                ダッシュボードに戻る
            </a>
        </footer>

    </main>
</body>

</html>