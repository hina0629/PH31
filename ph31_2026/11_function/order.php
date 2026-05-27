<?php

/**
 * 06_function/order.php
 * 関数の定義と利用（名前付き関数、無名関数、アロー関数）
 */

// 定数
const TAX_RATE = 0.1;
const POINT_RATE = 0.05;

// 入力値（シミュレーター用）
$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 1;
$productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 1;
$quantity = isset($_GET['qty']) ? (int)$_GET['qty'] : 3;

// --- 関数の定義 ---

/**
 * ユーザーをIDで検索
 */
function findUser(int $id)
{
    require_once "data/users.php";
    // TODO: array_column で id の配列を作成
    $ids = [];
    // TODO:    array_search でインデックスを検索
    $index = 0;
    // インデックスが見つかった場合はユーザー情報を返し、見つからない場合は null を返す
    return ($index !== false) ? $users[$index] : null;
}

/**
 * 商品をIDで検索
 */
function findProduct(int $id)
{
    require_once "data/products.php";
    $ids = [];
    $index = false;
    // $ids = array_column($products, "id");
    // $index = array_search($id, $ids);
    return ($index !== false) ? $products[$index] : null;
}

/**
 * 合計金額の計算（単価 × 数量）
 */
function calculateSubtotal(int $price, int $quantity): int
{
    return $price * $quantity;
}

/**
 * ポイントの計算
 */
function calculatePoint(int $amount, float $rate = POINT_RATE): int
{
    return (int)floor($amount * $rate);
}

/**
 * メッセージの作成（無名関数 / クロージャ）
 */
$formatGreeting = function (string $name) {
    // return "{$name}さん、この商品を購入しますか？";
};

/**
 * 税抜き価格の計算（アロー関数）
 */
$getExclTaxPrice = fn(int $inclTaxPrice): int => (int)ceil($inclTaxPrice / (1 + TAX_RATE));

// --- データの取得と計算 ---

$user = findUser($userId);
$product = findProduct($productId);

$subtotal = 0;
$exclTaxPrice = 0;
$earnedPoints = 0;
if ($user && $product) {
    // TODO: calculateSubtotal関数を使用して、合計金額を計算
    $subtotal = 0;
    // TODO: $getExclTaxPrice を使用して、税込価格から税抜価格を計算
    $exclTaxPrice = 0;
    // TODO: calculatePoint関数を使用して、獲得予定ポイントを計算
    $earnedPoints = 0;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文処理システム | PHP Function</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased bg-slate-50 text-slate-900 py-12 px-4">
    <main class="max-w-4xl mx-auto">
        <!-- Header -->
        <header class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6 text-center md:text-left">
            <div>
                <div class="inline-block px-3 py-1 mb-3 rounded-full bg-indigo-100 text-indigo-700 text-[10px] font-black uppercase tracking-[0.2em]">
                    Order Processing System
                </div>
                <h1 class="font-outfit text-4xl font-extrabold tracking-tight text-slate-900 leading-none">
                    Functional <span class="text-indigo-600">Logic</span>
                </h1>
            </div>
            <a href="../index.php" class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors inline-flex items-center gap-2 mx-auto md:mx-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                ダッシュボードに戻る
            </a>
        </header>

        <?php if (!$user || !$product): ?>
            <div class="bg-rose-50 border-2 border-rose-100 p-8 rounded-[2rem] text-center">
                <p class="text-rose-600 font-bold">データが見つかりませんでした。</p>
                <a href="order.php" class="mt-4 inline-block text-sm font-bold text-rose-400 underline">リセットする</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left: Greeting & Order Details -->
                <div class="lg:col-span-7 space-y-8">
                    <!-- Greeting Card (Using Closure) -->
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Message from System</h2>
                                <p class="text-lg font-bold text-slate-800 leading-relaxed">
                                    <?= htmlspecialchars($formatGreeting($user['display_name'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card -->
                    <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm border border-slate-200">
                        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                            <h2 class="text-lg font-bold">注文内容</h2>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Order Summary</span>
                        </div>
                        <div class="p-8 flex items-center gap-8">
                            <div class="w-32 h-32 bg-slate-100 rounded-3xl shrink-0 overflow-hidden">
                                <img src="./images/<?= $product['image'] ?? '' ?>" class="w-full h-full object-cover"
                                    onerror="this.src=''">
                            </div>
                            <div class="grow">
                                <h3 class="text-2xl font-black mb-1"><?= htmlspecialchars($product['name']) ?></h3>
                                <div class="flex items-center gap-4 text-slate-500 font-bold">
                                    <p class="text-lg">&yen;<?= number_format($product['price']) ?> <span class="text-[10px] font-medium text-slate-400 ml-1">(税込)</span></p>
                                    <p class="text-lg text-indigo-600">x <?= $quantity ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Price Breakdown -->
                <div class="lg:col-span-5 space-y-8">
                    <!-- Simulator Controls -->
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Simulator Controls</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="?user_id=1&product_id=1&qty=1" class="px-3 py-2 bg-slate-50 rounded-xl text-[10px] font-bold text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition-all text-center">ユーザー1 / 商品1</a>
                            <a href="?user_id=2&product_id=2&qty=5" class="px-3 py-2 bg-slate-50 rounded-xl text-[10px] font-bold text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition-all text-center">ユーザー2 / 商品2</a>
                            <a href="?user_id=3&product_id=3&qty=10" class="px-3 py-2 bg-slate-50 rounded-xl text-[10px] font-bold text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition-all text-center">ユーザー3 / 商品3</a>
                            <a href="order.php" class="px-3 py-2 bg-slate-50 rounded-xl text-[10px] font-bold text-slate-500 hover:bg-slate-100 transition-all text-center">リセット</a>
                        </div>
                    </div>
                    <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-indigo-200">
                        <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-8">Calculation Details</h2>

                        <div class="space-y-6">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400 text-sm font-medium">税抜き単価</span>
                                <span class="font-outfit font-bold">&yen;<?= number_format($exclTaxPrice) ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400 text-sm font-medium">消費税 (<?= TAX_RATE * 100 ?>%)</span>
                                <span class="font-outfit font-bold text-slate-500">&yen;<?= number_format($product['price'] - $exclTaxPrice) ?></span>
                            </div>
                            <div class="pt-6 border-t border-white/10 flex justify-between items-end">
                                <span class="text-lg font-bold">合計金額</span>
                                <span class="text-4xl font-black font-outfit text-indigo-400 leading-none">&yen;<?= number_format($subtotal) ?></span>
                            </div>
                        </div>

                        <!-- Points Banner -->
                        <div class="mt-10 bg-white/5 rounded-2xl p-5 border border-white/10 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-amber-400 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-slate-900" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-bold text-white/80">獲得予定ポイント</span>
                            </div>
                            <span class="text-xl font-black font-outfit"><?= number_format($earnedPoints) ?><span class="text-[10px] ml-1 opacity-50">pt</span></span>
                        </div>
                    </div>

                </div>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>