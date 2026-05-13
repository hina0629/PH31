<?php
$title = '演算子と計算の基本';
$description = '変数を使った計算、文字列の連結、インクリメント/デクリメント、そして三項演算子など、PHPで数値や文字列を操る演算子を学びましょう。';
$lesson_number = 3;
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>解説：演算子と計算 | PHP Operators</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Prism.js for code highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-slate-50 text-slate-800 leading-relaxed antialiased">

    <?php include('../components/nav.php'); ?>

    <main class="max-w-4xl mx-auto px-6 py-12">
        <?php include '../components/header.php'; ?>

        <!-- Section 1: Arithmetic Operators -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-violet-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">1</span>
                算術演算子
            </h3>
            <p class="mb-4">数値の計算に使う演算子です。<code>order.php</code> の注文金額や合計の計算もすべてこれらで行っています。</p>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm mb-6">
                <table class="w-full text-sm">
                    <thead class="bg-slate-100 text-slate-700 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">演算子</th>
                            <th class="px-6 py-3 text-left">意味</th>
                            <th class="px-6 py-3 text-left">例</th>
                            <th class="px-6 py-3 text-left">結果</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100 font-mono">
                        <tr>
                            <td class="px-6 py-3 font-bold text-violet-600">+</td>
                            <td class="px-6 py-3 font-sans">加算</td>
                            <td class="px-6 py-3 text-slate-600">120 + 150</td>
                            <td class="px-6 py-3 text-slate-500">270</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 font-bold text-violet-600">-</td>
                            <td class="px-6 py-3 font-sans">減算</td>
                            <td class="px-6 py-3 text-slate-600">500 - 50</td>
                            <td class="px-6 py-3 text-slate-500">450</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 font-bold text-violet-600">*</td>
                            <td class="px-6 py-3 font-sans">乗算</td>
                            <td class="px-6 py-3 text-slate-600">120 * 2</td>
                            <td class="px-6 py-3 text-slate-500">240</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 font-bold text-violet-600">/</td>
                            <td class="px-6 py-3 font-sans">除算</td>
                            <td class="px-6 py-3 text-slate-600">300 / 4</td>
                            <td class="px-6 py-3 text-slate-500">75</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 font-bold text-violet-600">%</td>
                            <td class="px-6 py-3 font-sans">剰余（余り）</td>
                            <td class="px-6 py-3 text-slate-600">10 % 3</td>
                            <td class="px-6 py-3 text-slate-500">1</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 font-bold text-violet-600">**</td>
                            <td class="px-6 py-3 font-sans">べき乗</td>
                            <td class="px-6 py-3 text-slate-600">2 ** 8</td>
                            <td class="px-6 py-3 text-slate-500">256</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <pre class="language-php mb-6"><code class="language-php">&lt;?php
$price1    = 120;
$price2    = 150;
$price3    = 130;
$quantity1 = 2;  // インクリメント後
$quantity2 = 1;
$quantity3 = 2;  // デクリメント後

// 各商品の小計（単価 × 数量）
$amount1 = $price1 * $quantity1; // 240
$amount2 = $price2 * $quantity2; // 150
$amount3 = $price3 * $quantity3; // 260

// 合計
$total = $amount1 + $amount2 + $amount3; // 650</code></pre>
        </section>

        <!-- Section 2: String Concatenation -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-violet-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">2</span>
                文字列の連結と変数展開
            </h3>
            <p class="mb-4">文字列同士をつなげるには <code>.</code>（ドット）演算子を使います。ダブルクォート内では <code>{}</code> を使って変数を直接埋め込む「変数展開」も使えます。</p>
            <pre class="language-php mb-6"><code class="language-php">&lt;?php
$last_name  = "Tokyo";
$first_name = "Taro";

// 1. ドット演算子で連結
$full_name = $last_name . " " . $first_name;
echo $full_name; // → Tokyo Taro

// 2. ダブルクォート内での変数展開（同じ結果）
$full_name = "{$last_name} {$first_name}";
echo $full_name; // → Tokyo Taro

// 3. .= で文字列を追記
$message = "こんにちは、";
$message .= $full_name . " さん";
echo $message; // → こんにちは、Tokyo Taro さん</code></pre>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-violet-50 border border-violet-200 p-4 rounded-2xl text-sm">
                    <p class="font-bold text-violet-800 mb-1">ダブルクォート <code>" "</code></p>
                    <p class="text-violet-700">変数展開・エスケープシーケンス（<code>\n</code> など）が使える。</p>
                </div>
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl text-sm">
                    <p class="font-bold text-slate-800 mb-1">シングルクォート <code>' '</code></p>
                    <p class="text-slate-600">変数展開されない。文字列をそのまま出力したい場合に使う。速度もわずかに速い。</p>
                </div>
            </div>
        </section>

        <!-- Section 3: Assignment & Increment -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-violet-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">3</span>
                代入演算子とインクリメント / デクリメント
            </h3>
            <p class="mb-4">変数の値を更新するときに使います。<code>order.php</code> では数量の調整に <code>++</code> / <code>--</code> を使っています。</p>
            <pre class="language-php mb-6"><code class="language-php">&lt;?php
$quantity1 = 1;
$quantity3 = 3;

// インクリメント（1 増やす）
$quantity1++; // $quantity1 は 2 になる

// デクリメント（1 減らす）
$quantity3--; // $quantity3 は 2 になる

// 複合代入演算子（より詳細な増減）
$total = 500;
$total += 150;  // $total = $total + 150 → 650
$total -= 50;   // $total = $total - 50  → 600
$total *= 2;    // $total = $total * 2   → 1200
$total /= 4;    // $total = $total / 4   → 300</code></pre>

            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 text-sm text-blue-800 rounded-r-2xl">
                <strong>前置 vs 後置：</strong> <code>++$i</code>（前置）は加算してから返し、<code>$i++</code>（後置）は返してから加算します。単独で使う場合は同じ結果ですが、式の中に組み込む場合は挙動が変わります。
            </div>
        </section>

        <!-- Section 4: Ternary Operator -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-violet-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">4</span>
                三項演算子
            </h3>
            <p class="mb-4"><code>if / else</code> を1行で書ける演算子です。<code>条件 ? 真の値 : 偽の値</code> という形式で使います。<code>order.php</code> では会員フラグに応じて割引率とラベルを切り替えるために使っています。</p>
            <pre class="language-php mb-6"><code class="language-php">&lt;?php
const DISCOUNT_RATE = 0.1;

$isMember = true;

// 三項演算子：会員なら割引率を適用、非会員なら 0
$discountRate = ($isMember) ? DISCOUNT_RATE : 0;

// 表示ラベルも同様に切り替え
$memberLabel = ($isMember) ? "会員" : "非会員";

// 割引額と最終金額
$total            = 650;
$discount         = $total * $discountRate;       // 65
$totalWithDiscount = $total - $discount;           // 585</code></pre>

            <div class="bg-amber-50 border-l-4 border-amber-400 p-4 text-sm text-amber-800 rounded-r-2xl">
                <strong>Null 合体演算子 <code>??</code>：</strong> 左辺が <code>null</code> または未定義のとき右辺を返す特殊な三項演算子の仲間です。フォームの入力値取得など、値が存在しないかもしれない場面でよく使います。<br>
                <code class="text-amber-900 font-mono">$name = $_GET['name'] ?? 'ゲスト';</code>
            </div>
        </section>

        <!-- Section 5: Math Functions -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-violet-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">5</span>
                数値フォーマット関数
            </h3>
            <p class="mb-4">計算結果を画面に表示するときは、端数の処理や桁区切りの整形が必要になります。<code>order.php</code> ではポイント計算に <code>floor()</code>、価格表示に <code>number_format()</code> を使っています。</p>
            <pre class="language-php mb-6"><code class="language-php">&lt;?php
const POINT_RATE = 0.01;

$totalWithDiscount = 585;

// floor()  小数点以下を切り捨て（ポイント計算など）
$point = floor($totalWithDiscount * POINT_RATE); // 5

// ceil()   小数点以下を切り上げ
$ceil_val = ceil(4.1);   // 5

// round()  四捨五入
$round_val = round(4.5); // 5
$round_val = round(4.4); // 4

// number_format()  3桁ごとにカンマ区切り
echo number_format(1234567);      // → 1,234,567
echo number_format(1234.567, 2);  // → 1,234.57（小数2桁）</code></pre>

            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 text-sm text-blue-800 rounded-r-2xl">
                <strong>金額表示には必ず <code>number_format()</code> を使いましょう。</strong>
                大きな数値をそのまま <code>echo</code> しても読みにくい上に、フロートの精度誤差が出ることもあります。
            </div>
        </section>

        <footer class="pt-12 border-t border-slate-200 text-center">
            <p class="text-slate-500 text-sm italic">"演算子を正しく使いこなすことが、正確な計算ロジックの第一歩です。"</p>
        </footer>
    </main>

    <!-- Prism.js Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup-templating.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
</body>

</html>