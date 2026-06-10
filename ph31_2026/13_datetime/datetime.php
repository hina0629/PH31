<?php
// タイムゾーンの設定
date_default_timezone_set('Asia/Tokyo');

// DateTimeクラスのインスタンス化
$date = new DateTime();
// TODO: 日付と時刻の設定: setDate(), setTime()
$date->setDate(2026, 6, 3)->setTime(17, 21, 04);
// TODO 日付と時刻のフォーマット: format() : Y-m-d H:i:s
$date_string = $date->format('Y-m-d H:i:s');

// 比較用データ
$date1 = new DateTime();
$date1->setDate(2022, 3, 10)->setTime(10, 30, 45);
$date_string1 = $date1->format('Y-m-d H:i:s');

$date2 = new DateTime();
$date2->setDate(2022, 3, 10)->setTime(10, 30, 45);
// TODO: 日付の操作: modify() : +1 day
$date2->modify('+1 day');

$date_string2 = $date2->format('Y-m-d H:i:s');

// 比較実行
$is_match = ($date1 < $date2);

// 比較結果のテキスト
$comparison_text = $is_match ? "{$date_string1} は {$date_string2} より前の日時です（True）" : "{$date_string1} は {$date_string2} 以降の日時です（False）";
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP基礎：DateTime クラス | PHP Samples</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-slate-50 text-slate-800 leading-relaxed antialiased">

    <main class="max-w-4xl mx-auto px-6 py-12">

        <!-- Section 1: Basic Usage -->
        <section class="mb-12">
            <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-indigo-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">1</span>
                DateTime オブジェクトの作成
            </h3>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">フォーマット済み出力</h4>
                        <p class="text-2xl font-mono font-bold text-indigo-600"><?= $date_string ?></p>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                        <code class="text-xs text-slate-600">
                            $date = new DateTime();<br>
                            $date->setDate(2022, 3, 10)->setTime(10, 30, 45);
                        </code>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 2: Comparison -->
        <section class="mb-12">
            <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-emerald-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">2</span>
                日付の比較と操作
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-5 rounded-xl border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">日付1 (基準)</span>
                    <p class="text-lg font-mono font-bold text-slate-700"><?= $date_string1 ?></p>
                </div>
                <div class="bg-white p-5 rounded-xl border border-slate-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-emerald-500 text-white text-[10px] px-2 py-0.5 font-bold">+1 day</div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">日付2 (修正後)</span>
                    <p class="text-lg font-mono font-bold text-slate-700"><?= $date_string2 ?></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-2 h-2 rounded-full animate-pulse"></div>
                    <h4 class="text-sm font-bold uppercase tracking-widest">比較結果 ($date1 < $date2)</h4>
                </div>
                <p class="text-xl font-bold"><?= $comparison_text ?></p>
                <div class="mt-4 pt-4 border-t border-slate-200">
                    <p class="text-sm text-slate-400">
                        DateTimeオブジェクト同士は、比較演算子でそのまま比較できます。
                    </p>
                </div>
            </div>
        </section>

        <footer class="pt-12 border-t border-slate-200 text-center">
            <p class="text-slate-500 text-sm italic">"DateTimeクラスは、タイムゾーンの扱いや複雑な期間計算にも対応しており、実務ではこちらが主流です。"</p>
        </footer>
    </main>

</body>

</html>