<?php
// 変数
$last_name = "Tokyo";
$first_name = "Taro";

// 文字列連結
// TODO: ドット演算子: last_name と first_name の間に半角スペースを入れる
$full_name = "";
// TODO: テンプレートリテラル: last_name と first_name の間に半角スペースを入れる
$full_name = "";

// drink1, drink2, drink3に商品名を代入
$drink1 = "コーラ";
$drink2 = "オレンジジュース";
$drink3 = "紅茶";

// image1, image2, image3に画像ファイル名を代入
$image1 = "images/cola.webp";
$image2 = "images/orange.webp";
$image3 = "images/tea.webp";

// price1, price2, price3に価格を代入
$price1 = 120;
$price2 = 150;
$price3 = 130;

// quantity1, quantity2, quantity3に個数を代入
$quantity1 = 1;
$quantity2 = 1;
$quantity3 = 3;

// 会員ラベル
$memberLabel = "";

// 定数：割引率
const DISCOUNT_RATE = 0.1;
const POINT_RATE = 0.01;

// 会員フラグ
$isMember = true;

// 演算
// TODO: quantity1 をインクリメント

// TODO: quantity3 をデクリメント

// TODO: amount1, amount2, amount3に金額を代入
$amount1 = 0;
$amount2 = 0;
$amount3 = 0;

// 通常合計価格
$total = 0;

// 三項演算
// TODO: 会員の場合、割引率を DISCOUNT_RATE に設定、そうでない場合 0
$discountRate = 0;

// TODO: isMember の値に応じて 会員 or 非会員
$memberLabel = "";

// 割引額
$discount = $total * $discountRate;

// 合計金額
$totalWithDiscount = $total - $discount;

// TODO: ポイント計算：小数点は floor() で切り捨て
$point = 0;
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文確認 | デジタルストア</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased min-h-screen bg-slate-50 text-slate-900 py-12 px-4">
    <main class="max-w-5xl mx-auto">
        <!-- Header -->
        <header class="text-center mb-2">
            <h1 class="text-2xl font-extrabold mb-4 tracking-tight text-slate-900">
                注文内容の確認
            </h1>
        </header>

        <div class="p-4 mb-2">
            <p>
                <span class="text-emerald-600 font-bold mr-2"><?= $full_name; ?></span>
                <span class="text-slate-500 text-sm">さん、ようこそ</span>
            </p>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Product 1 -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 transition-transform duration-300 hover:-translate-y-1 hover:shadow-xl group">
                <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                    <img src="<?= $image1; ?>" alt="<?= $drink1; ?>"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-3 text-slate-900"><?= $drink1; ?></h2>
                    <div class="flex items-end justify-between">
                        <div class="space-y-1">
                            <p class="text-slate-500 text-sm">単価</p>
                            <p class="text-xl font-semibold">&yen;<?= number_format($price1); ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-slate-500 text-sm">数量</p>
                            <p class="text-xl font-bold text-sky-600"><span class="text-sky-600 text-sm mr-1">x</span><?= $quantity1 ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 transition-transform duration-300 hover:-translate-y-1 hover:shadow-xl group">
                <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                    <img src="<?= $image2; ?>" alt="<?= $drink2; ?>"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-3 text-slate-900"><?= $drink2; ?></h2>
                    <div class="flex items-end justify-between">
                        <div class="space-y-1">
                            <p class="text-slate-500 text-sm">単価</p>
                            <p class="text-lg font-semibold">&yen;<?= number_format($price2); ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-slate-500 text-sm">数量</p>
                            <p class="text-2xl font-bold text-sky-600"><span class="text-sky-600 text-sm mr-1">x</span><?= $quantity2 ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 transition-transform duration-300 hover:-translate-y-1 hover:shadow-xl group">
                <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                    <img src="<?= $image3; ?>" alt="<?= $drink3; ?>"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-3 text-slate-900"><?= $drink3; ?></h2>
                    <div class="flex items-end justify-between">
                        <div class="space-y-1">
                            <p class="text-slate-500 text-sm">単価</p>
                            <p class="text-lg font-semibold">&yen;<?= number_format($price3); ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-slate-500 text-sm">数量</p>
                            <p class="text-2xl font-bold text-sky-600"><span class="text-sky-600 text-sm mr-1">x</span><?= $quantity3 ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Summary -->
        <div class="mt-12 bg-white shadow-lg p-8 rounded-[2rem] border border-slate-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-slate-500">
                        <span>小計</span>
                        <span>&yen;<?= number_format($total); ?></span>
                    </div>
                    <div class="flex justify-between items-center text-slate-500">
                        <span class="text-sm font-medium uppercase tracking-widest">会員ステータス</span>
                        <span class="<?= $isMember ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-700' ?> px-3 py-1 rounded-full text-xs font-bold uppercase tracking-tighter shadow-sm">
                            <?= $memberLabel ?>
                        </span>
                    </div>
                    <div class="flex justify-between items-center text-emerald-600 font-medium">
                        <span>会員割引 (<?= $discountRate * 100 ?>%)</span>
                        <span>- &yen;<?= number_format($discount); ?></span>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                        <span class="text-xl font-bold text-slate-900">お支払い合計</span>
                        <span class="text-4xl font-black text-sky-600 leading-none">&yen;<?= number_format($totalWithDiscount); ?></span>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-200 p-6 rounded-2xl flex items-center gap-6 shadow-inner">
                    <div class="w-16 h-16 bg-sky-100 rounded-2xl flex items-center justify-center shrink-0">
                        <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 uppercase tracking-widest font-bold">獲得ポイント</p>
                        <p class="text-3xl font-black text-slate-900 leading-none mt-1"><?= number_format($point); ?><span class="text-lg font-bold ml-1 text-slate-400">pt</span></p>
                        <p class="text-xs text-sky-600 mt-1">還元率: <?= POINT_RATE * 100 ?>% 適用中</p>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-12 text-center text-slate-400 text-sm">
            <p>&copy; 2026 プレミアム・デジタルストア. 無断複写・転載を禁じます。</p>
        </footer>
    </main>
</body>

</html>