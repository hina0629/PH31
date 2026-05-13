<?php
$title = 'PHP基礎：ファイル分離（require / include）';
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>解説：ファイル分離 | require / include</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-slate-50 text-slate-800 leading-relaxed antialiased">

    <?php include('../components/nav.php'); ?>

    <main class="max-w-4xl mx-auto px-6 py-12">
        <header class="mb-12">
            <div class="inline-block px-3 py-1 rounded-full bg-violet-100 text-violet-700 text-xs font-bold uppercase tracking-wider mb-4">
                Lesson 02 – Extra
            </div>
            <h2 class="text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">ファイル分離の基本</h2>
            <p class="text-lg text-slate-600"><code>require</code> と <code>include</code> を使ってPHPファイルを分割する方法を学びます。コードを分けることで「変更が1ヶ所で済む」「再利用できる」というメリットが生まれます。</p>
        </header>

        <!-- Section 1: なぜファイルを分けるのか -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-violet-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">1</span>
                なぜファイルを分けるのか
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="text-2xl mb-3">🔁</div>
                    <h4 class="font-bold text-slate-900 mb-2">再利用</h4>
                    <p class="text-sm text-slate-600">ヘッダー・フッターなどを1つのファイルにまとめ、複数ページから読み込む。</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="text-2xl mb-3">✏️</div>
                    <h4 class="font-bold text-slate-900 mb-2">保守性</h4>
                    <p class="text-sm text-slate-600">税率や設定の変更は <code>config.php</code> の1行だけ修正すれば全体に反映。</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="text-2xl mb-3">🧩</div>
                    <h4 class="font-bold text-slate-900 mb-2">可読性</h4>
                    <p class="text-sm text-slate-600">役割ごとにファイルを分けると、どこに何が書いてあるかわかりやすい。</p>
                </div>
            </div>

            <div class="code-block">
                <pre><code><span class="hl-comment">// ❌ 分けない場合 — 全ページに同じコードをコピペ</span>
<span class="hl-keyword">const</span> <span class="hl-const">TAX_RATE</span> = <span class="hl-num">0.10</span>; <span class="hl-comment">// page1.php にも page2.php にも...</span>

<span class="hl-comment">// ✅ 分けた場合 — config.php に1回書くだけ</span>
<span class="hl-keyword">require_once</span> <span class="hl-string">'includes/config.php'</span>; <span class="hl-comment">// どのページも1行でOK</span></code></pre>
            </div>
        </section>

        <!-- Section 2: 4つの関数の違い -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-violet-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">2</span>
                4つの関数の違い
            </h3>

            <div class="overflow-x-auto mb-6">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-slate-900 text-white">
                            <th class="text-left p-4 rounded-tl-xl font-bold">関数</th>
                            <th class="text-left p-4 font-bold">ファイルがない場合</th>
                            <th class="text-left p-4 font-bold">2回目の読み込み</th>
                            <th class="text-left p-4 rounded-tr-xl font-bold">主な用途</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr class="bg-white hover:bg-rose-50 transition-colors">
                            <td class="p-4 font-mono font-bold text-rose-600">require</td>
                            <td class="p-4 text-rose-700 font-semibold">Fatal Error（停止）</td>
                            <td class="p-4 text-slate-600">再度読み込む</td>
                            <td class="p-4 text-slate-600">DB接続など絶対必要なもの</td>
                        </tr>
                        <tr class="bg-white hover:bg-rose-50 transition-colors">
                            <td class="p-4 font-mono font-bold text-rose-600">require_once</td>
                            <td class="p-4 text-rose-700 font-semibold">Fatal Error（停止）</td>
                            <td class="p-4 text-emerald-600 font-semibold">スキップ（安全）</td>
                            <td class="p-4 text-slate-600">設定・定数ファイルなど</td>
                        </tr>
                        <tr class="bg-white hover:bg-amber-50 transition-colors">
                            <td class="p-4 font-mono font-bold text-amber-600">include</td>
                            <td class="p-4 text-amber-700 font-semibold">Warning（続行）</td>
                            <td class="p-4 text-slate-600">再度読み込む</td>
                            <td class="p-4 text-slate-600">HTML パーツなど</td>
                        </tr>
                        <tr class="bg-white hover:bg-amber-50 transition-colors">
                            <td class="p-4 font-mono font-bold text-amber-600">include_once</td>
                            <td class="p-4 text-amber-700 font-semibold">Warning（続行）</td>
                            <td class="p-4 text-emerald-600 font-semibold">スキップ（安全）</td>
                            <td class="p-4 text-slate-600">関数定義ファイルなど</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 text-sm text-blue-800">
                <strong>使い分けの原則：</strong>
                そのファイルがなければページが成り立たない → <code>require_once</code>。
                なくても動く表示パーツ → <code>include</code>。
                迷ったら基本は <code>require_once</code> を使っておけばOK。
            </div>
        </section>

        <!-- Section 3: ファイル構成の実例 -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-violet-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">3</span>
                ファイル構成の実例
            </h3>
            <p class="mb-4">デモページ（<code>include_demo.php</code>）の構成を例に、どのファイルが何の役割を持つかを確認します。</p>

            <div class="code-block mb-6">
                <pre><code><span class="hl-comment">02_variable/</span>
<span class="hl-comment">├── include_demo.php       ← メインページ</span>
<span class="hl-comment">└── includes/</span>
<span class="hl-comment">    ├── config.php         ← 定数・設定（require_once）</span>
<span class="hl-comment">    ├── products.php       ← 商品データ（require_once）</span>
<span class="hl-comment">    ├── header.php         ← 共通ヘッダー（include）</span>
<span class="hl-comment">    └── footer.php         ← 共通フッター（include）</span></code></pre>
            </div>

            <h4 class="font-bold text-slate-900 mb-3">include_demo.php の冒頭（読み込み部分）</h4>
            <div class="code-block mb-6">
                <pre><code><span class="hl-comment">// 設定ファイル（必須） — なければ停止</span>
<span class="hl-keyword">require_once</span> <span class="hl-string">'includes/config.php'</span>;

<span class="hl-comment">// 商品データ（必須） — なければ停止</span>
<span class="hl-keyword">require_once</span> <span class="hl-string">'includes/products.php'</span>;

<span class="hl-comment">// ヘッダー（任意表示パーツ）— なければ警告だけ</span>
<span class="hl-keyword">include</span> <span class="hl-string">'includes/header.php'</span>;

<span class="hl-comment">// フッター（任意表示パーツ）— なければ警告だけ</span>
<span class="hl-keyword">include</span> <span class="hl-string">'includes/footer.php'</span>;</code></pre>
            </div>
        </section>

        <!-- Section 4: スコープ（変数の受け渡し） -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-violet-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">4</span>
                スコープ — 変数は引き継がれる
            </h3>
            <p class="mb-4">読み込まれたファイルは「その場に展開」されるイメージです。読み込み元の変数は読み込まれたファイル内でもそのまま使えます。</p>

            <div class="code-block mb-6">
                <pre><code><span class="hl-comment">// main.php</span>
<span class="hl-var">$username</span> = <span class="hl-string">"Yamada"</span>;
<span class="hl-keyword">include</span> <span class="hl-string">'greeting.php'</span>; <span class="hl-comment">// ← この時点での $username が使える</span>

<span class="hl-comment">// greeting.php</span>
<span class="hl-comment">// $username は main.php から引き継がれている</span>
echo <span class="hl-string">"こんにちは、{</span><span class="hl-var">$username</span><span class="hl-string">}さん！"</span>; <span class="hl-comment">// → こんにちは、Yamadaさん！</span></code></pre>
            </div>

            <div class="bg-amber-50 border-l-4 border-amber-400 p-4 text-sm text-amber-800">
                <strong>Note:</strong> 関数の中から <code>include</code> すると、変数スコープは関数内に限られます。トップレベルでの <code>include</code> はグローバルスコープで展開されます。
            </div>
        </section>

        <!-- Section 5: よくある使い方パターン -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-violet-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">5</span>
                よくある使い方パターン
            </h3>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <h4 class="font-bold text-slate-900 mb-3">パターン1：設定ファイル（config.php）</h4>
                    <div class="code-block text-xs">
                        <pre><code><span class="hl-comment">// config.php — 定数・環境設定をまとめる</span>
<span class="hl-keyword">const</span> <span class="hl-const">DB_HOST</span> = <span class="hl-string">'localhost'</span>;
<span class="hl-keyword">const</span> <span class="hl-const">DB_NAME</span> = <span class="hl-string">'shop_db'</span>;
<span class="hl-keyword">const</span> <span class="hl-const">TAX_RATE</span> = <span class="hl-num">0.10</span>;</code></pre>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <h4 class="font-bold text-slate-900 mb-3">パターン2：共通レイアウトパーツ</h4>
                    <div class="code-block text-xs">
                        <pre><code><span class="hl-comment">// page.php</span>
<span class="hl-keyword">require_once</span> <span class="hl-string">'config.php'</span>;

<span class="hl-var">$pageTitle</span> = <span class="hl-string">"商品一覧"</span>;
<span class="hl-keyword">include</span> <span class="hl-string">'parts/header.php'</span>;  <span class="hl-comment">// header.php 内で $pageTitle を使う</span>

<span class="hl-comment">// ページ固有のコンテンツ...</span>

<span class="hl-keyword">include</span> <span class="hl-string">'parts/footer.php'</span>;</code></pre>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <h4 class="font-bold text-slate-900 mb-3">パターン3：関数定義ファイル</h4>
                    <div class="code-block text-xs">
                        <pre><code><span class="hl-comment">// functions.php — 関数をまとめる（_once で二重定義を防ぐ）</span>
<span class="hl-keyword">function</span> <span class="hl-func">formatPrice</span>(<span class="hl-var">$price</span>): string {
    <span class="hl-keyword">return</span> <span class="hl-string">'¥'</span> . number_format(<span class="hl-var">$price</span>);
}

<span class="hl-comment">// 使う側（require_once で確実に1度だけ定義）</span>
<span class="hl-keyword">require_once</span> <span class="hl-string">'functions.php'</span>;
echo <span class="hl-func">formatPrice</span>(<span class="hl-num">1980</span>); <span class="hl-comment">// → ¥1,980</span></code></pre>
                    </div>
                </div>
            </div>
        </section>

        <footer class="pt-12 border-t border-slate-200 text-center">
            <p class="text-slate-500 text-sm italic">"ファイルを分けることで、変更1ヶ所・反映は全体。これが保守しやすいコードの第一歩です。"</p>
        </footer>
    </main>

</body>

</html>