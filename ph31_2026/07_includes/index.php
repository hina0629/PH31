<?php
// ============================================================
//  require / include デモ — ファイル分離のメリット
// ============================================================

// require_once: ファイルが存在しないと Fatal Error → 必須ファイルに使う
// TODO: includes/config.php を読み込む
require_once 'includes/config.php';

// ２回目は無視される
require_once 'includes/config.php';

// require_once: 商品データも必須
// TODO: includes/products.php を読み込む
require_once 'includes/products.php';

// 会員フラグ・数量（メインロジック）
$isMember  = true;
$quantities = [2, 1, 3];

// 金額計算（config.php の定数を利用）
$subtotal = 0;
if (!empty($products)) {
    foreach ($products as $i => $product) {
        $subtotal += $product['price'] * $quantities[$i];
    }
}

$discountRate    = $isMember ? DISCOUNT_RATE : 0;
$discount        = (int)($subtotal * $discountRate);
$tax             = (int)(($subtotal - $discount) * TAX_RATE);
$total           = $subtotal - $discount + $tax;
$point           = (int)($total * POINT_RATE);
$memberLabel     = $isMember ? '会員' : '非会員';
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>require/include デモ | PHP ファイル分離</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
</head>

<body class="antialiased bg-slate-50 text-slate-900">

    <!-- ヘッダー: include で読み込み（失敗しても継続） -->
    <?php include 'includes/header.php'; ?>

    <main class="max-w-5xl mx-auto px-6 py-10">

        <!-- ページタイトル -->
        <div class="mb-8">
            <div class="inline-block px-3 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-bold uppercase tracking-wider mb-3">Lesson 02 – Extra</div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">require / include デモ</h2>
            <p class="text-slate-600 mt-2">このページは複数のファイルを組み合わせて構成されています。ソースを確認し、ファイル分離の効果を体験してください。</p>
        </div>

        <!-- ファイル構造の可視化 -->
        <section class="mb-10 bg-slate-900 text-slate-100 rounded-2xl p-6 font-mono text-sm">
            <p class="text-slate-400 text-xs uppercase tracking-widest font-sans mb-4">このページのファイル構成</p>
            <pre class="leading-loose">
<span class="text-sky-400">include_demo.php</span>  <span class="text-slate-500">← 今ここ</span>
├── <span class="text-fuchsia-400">require_once</span> <span class="text-green-400">'includes/config.php'</span>    <span class="text-slate-500">設定・定数（必須）</span>
├── <span class="text-fuchsia-400">require_once</span> <span class="text-green-400">'includes/products.php'</span>  <span class="text-slate-500">商品データ（必須）</span>
├── <span class="text-amber-400">include</span>      <span class="text-green-400">'includes/header.php'</span>    <span class="text-slate-500">共通ヘッダー（任意）</span>
└── <span class="text-amber-400">include</span>      <span class="text-green-400">'includes/footer.php'</span>    <span class="text-slate-500">共通フッター（任意）</span>
</pre>
        </section>

        <!-- require vs include 比較カード -->
        <section class="mb-10 grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white border-2 border-rose-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-10 h-10 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center font-bold text-sm">必須</span>
                    <div>
                        <p class="font-bold text-slate-900 font-mono">require / require_once</p>
                        <p class="text-xs text-slate-500">ファイルがなければ即停止</p>
                    </div>
                </div>
                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex gap-2"><span class="text-rose-500 font-bold shrink-0">●</span> ファイルが見つからない → <strong>Fatal Error</strong></li>
                    <li class="flex gap-2"><span class="text-rose-500 font-bold shrink-0">●</span> 処理はそこで完全に停止する</li>
                    <li class="flex gap-2"><span class="text-rose-500 font-bold shrink-0">●</span> DB接続・設定ファイルなど<strong>必須</strong>のファイルに使う</li>
                    <li class="flex gap-2"><span class="text-rose-500 font-bold shrink-0">●</span> <code class="bg-rose-50 px-1 rounded">_once</code> 付きは同一ファイルの重複読み込みを防ぐ</li>
                </ul>
                <div class="mt-4 bg-slate-900 rounded-xl p-3 font-mono text-xs text-green-400">
                    require_once 'includes/config.php';
                </div>
            </div>

            <div class="bg-white border-2 border-amber-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center font-bold text-sm">任意</span>
                    <div>
                        <p class="font-bold text-slate-900 font-mono">include / include_once</p>
                        <p class="text-xs text-slate-500">ファイルがなくても処理継続</p>
                    </div>
                </div>
                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex gap-2"><span class="text-amber-500 font-bold shrink-0">●</span> ファイルが見つからない → <strong>Warning</strong>（続行）</li>
                    <li class="flex gap-2"><span class="text-amber-500 font-bold shrink-0">●</span> 処理はそのまま続く</li>
                    <li class="flex gap-2"><span class="text-amber-500 font-bold shrink-0">●</span> ヘッダー・フッターなど<strong>表示パーツ</strong>に使う</li>
                    <li class="flex gap-2"><span class="text-amber-500 font-bold shrink-0">●</span> <code class="bg-amber-50 px-1 rounded">_once</code> 付きは同一ファイルの重複読み込みを防ぐ</li>
                </ul>
                <div class="mt-4 bg-slate-900 rounded-xl p-3 font-mono text-xs text-green-400">
                    include 'includes/header.php';
                </div>
            </div>
        </section>

        <!-- require_once 二重読み込み防止のデモ -->
        <section class="mb-10 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 mb-4">require_once の二重読み込み防止</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="font-bold text-rose-600 mb-2">require（問題あり）</p>
                    <div class="bg-slate-900 rounded-xl p-4 font-mono text-xs text-slate-300">
                        <span class="text-fuchsia-400">require</span> <span class="text-green-400">'config.php'</span>;<br>
                        <span class="text-fuchsia-400">require</span> <span class="text-green-400">'config.php'</span>; <span class="text-slate-500">// 2回目</span><br>
                        <span class="text-rose-400">// → Fatal Error: 定数の再定義</span>
                    </div>
                </div>
                <div>
                    <p class="font-bold text-emerald-600 mb-2">require_once（安全）</p>
                    <div class="bg-slate-900 rounded-xl p-4 font-mono text-xs text-slate-300">
                        <span class="text-fuchsia-400">require_once</span> <span class="text-green-400">'config.php'</span>;<br>
                        <span class="text-fuchsia-400">require_once</span> <span class="text-green-400">'config.php'</span>; <span class="text-slate-500">// 2回目</span><br>
                        <span class="text-emerald-400">// → 無視される（エラーなし）</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-sm bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-emerald-800">
                <strong>実際にこのページで確認：</strong>
                config.php は2回 <code>require_once</code> されていますが、定数 <code>STORE_NAME</code> は正常に <code><?= STORE_NAME ?></code> と表示されています。
            </div>
        </section>

        <!-- ファイル分離のメリット実演: 商品一覧 -->
        <section class="mb-10">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">includes/products.php より</span>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-4">商品一覧（products.php から読み込み）</h3>
            <p class="text-sm text-slate-500 mb-5">商品データを <code class="bg-slate-100 px-1 rounded text-rose-600">includes/products.php</code> に一元管理。追加・変更はそこだけでOK。</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php if (isset($products) && is_array($products) && count($products) > 0): ?>
                    <?php foreach ($products as $i => $product): ?>
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                            <div class="aspect-[4/3] bg-slate-100 overflow-hidden">
                                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="p-5">
                                <h4 class="font-bold text-slate-900 text-lg mb-2"><?= htmlspecialchars($product['name']) ?></h4>
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-xs text-slate-400">単価</p>
                                        <p class="text-xl font-semibold"><?= CURRENCY ?><?= number_format($product['price']) ?></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-slate-400">数量</p>
                                        <p class="text-xl font-bold text-sky-600">×<?= $quantities[$i] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- 合計計算（config.php の定数を使用） -->
        <section class="mb-10">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold uppercase tracking-widest text-violet-600 bg-violet-50 px-2 py-0.5 rounded">includes/config.php の定数を使用</span>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-4">お会計（定数で一元管理）</h3>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 max-w-md">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>小計</span>
                        <span>¥<?= number_format($subtotal) ?></span>
                    </div>
                    <div class="flex justify-between items-center text-slate-600">
                        <span>会員ステータス</span>
                        <span class="<?= $isMember ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600' ?> px-2 py-0.5 rounded-full text-xs font-bold">
                            <?= $memberLabel ?>
                        </span>
                    </div>
                    <div class="flex justify-between text-emerald-600">
                        <span>会員割引 (<?= DISCOUNT_RATE * 100 ?>%) <span class="text-xs text-slate-400">← DISCOUNT_RATE</span></span>
                        <span>-¥<?= number_format($discount) ?></span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>消費税 (<?= TAX_RATE * 100 ?>%) <span class="text-xs text-slate-400">← TAX_RATE</span></span>
                        <span>+¥<?= number_format($tax) ?></span>
                    </div>
                    <div class="pt-3 border-t border-slate-200 flex justify-between items-center font-bold">
                        <span class="text-lg">合計</span>
                        <span class="text-2xl text-sky-600">¥<?= number_format($total) ?></span>
                    </div>
                    <div class="flex justify-between text-slate-400 text-xs">
                        <span>獲得ポイント (<?= POINT_RATE * 100 ?>%) <span class="text-slate-300">← POINT_RATE</span></span>
                        <span><?= number_format($point) ?> pt</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 bg-blue-50 border-l-4 border-blue-400 p-4 text-sm text-blue-800 max-w-md">
                <strong>Point:</strong> 税率・割引率を変更する際は <code>includes/config.php</code> の1行を直すだけ。全ページに即反映。
            </div>
        </section>

    </main>

    <!-- フッター: include で読み込み -->
    <?php include 'includes/footer.php'; ?>

</body>

</html>