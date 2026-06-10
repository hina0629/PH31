<?php
// タイトルなどのメタ情報
$title = 'PHP基礎：日付操作 date() 関数';

// TODO: タイムゾーンの設定
date_default_timezone_set("Asia/Tokyo");

// TODO: 現在のタイムスタンプ
$now_time = time();

// x日後のタイムスタンプ
$day = 7;
// TODO: 現在のタイムスタンプ + (24時間 * 60分 * 60秒) * x日
$next_time = $now_time + (24 * 60 * 60) * $day;

// TODO: 現在の年: Y
$year = date('Y');
// TODO: 現在の月: m
$month = date('m');
// TODO: 現在の月の日数: t
$days = date('t');
// TODO: 現在の日付と時刻: Y/m/d H:i:s
$today_string = date('Y/m/d H:i:s');

// x日後: strtotime() : +1 day
$next_day_time = strtotime('+1 day');
$next_day = date('Y/m/d', $next_day_time);

// xヶ月前: strtotime() : -3 month
$prev_day_time = strtotime('-3 month');
$prev_day = date('Y/m/d', $prev_day_time);

// x時間後: strtotime() : +3 hour
$next_hour_time = strtotime('+3 hour');
$next_hour = date('Y/m/d H:i:s', $next_hour_time);

// 次の曜日: strtotime() : +1 sunday
$next_week_time = strtotime('+1 sunday');
$next_week = date('Y/m/d H:i:s', $next_week_time);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | PHP Samples</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 leading-relaxed antialiased">

    <?php include('../components/nav.php'); ?>

    <main class="max-w-4xl mx-auto px-6 py-12">

        <!-- Section 1: Timestamp -->
        <section class="mb-12">
            <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-indigo-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">1</span>
                タイムスタンプ
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 card-shadow transition hover:border-indigo-200">
                    <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">現在のタイムスタンプ</h4>
                    <p class="text-3xl font-mono font-bold text-indigo-600"><?= $now_time ?></p>
                    <p class="text-xs text-slate-400 mt-2"><code>time()</code> 関数で取得</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 card-shadow transition hover:border-indigo-200">
                    <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2"><?= $day ?>日後のタイムスタンプ</h4>
                    <p class="text-3xl font-mono font-bold text-slate-700"><?= $next_time ?></p>
                    <p class="text-xs text-slate-400 mt-2">計算: 現在 + (24 * 60 * 60) * <?= $day ?></p>
                </div>
            </div>
        </section>

        <!-- Section 2: Current Info -->
        <section class="mb-12">
            <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-emerald-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">2</span>
                現在の日付・時刻（フォーマット済み）
            </h3>
            <div class="bg-white rounded-2xl border border-slate-200 card-shadow overflow-hidden">
                <div class="p-8 bg-gradient-to-br from-emerald-50 to-white border-b border-slate-100 text-center">
                    <p class="text-sm font-bold text-emerald-600 mb-2"><code>date('Y/m/d H:i:s')</code></p>
                    <h4 class="text-4xl font-extrabold text-slate-900 tracking-tight"><?= $today_string ?></h4>
                </div>
                <div class="grid grid-cols-3 divide-x divide-slate-100">
                    <div class="p-4 text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">現在の年 (Y)</p>
                        <p class="text-xl font-bold text-slate-700"><?= $year ?>年</p>
                    </div>
                    <div class="p-4 text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">現在の月 (m)</p>
                        <p class="text-xl font-bold text-slate-700"><?= $month ?>月</p>
                    </div>
                    <div class="p-4 text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">今月の日数 (t)</p>
                        <p class="text-xl font-bold text-slate-700"><?= $days ?>日間</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 3: strtotime Calculations -->
        <section class="mb-12">
            <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-amber-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">3</span>
                相対的な日付計算 (<code>strtotime</code>)
            </h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200 hover:bg-amber-50 transition">
                    <div>
                        <span class="text-xs font-bold text-amber-600 uppercase">1日後 (+1 day)</span>
                        <h4 class="text-lg font-bold text-slate-800"><?= $next_day ?></h4>
                    </div>
                    <code class="text-xs bg-slate-100 px-2 py-1 rounded text-slate-500"><?= $next_day_time ?></code>
                </div>
                <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200 hover:bg-amber-50 transition">
                    <div>
                        <span class="text-xs font-bold text-amber-600 uppercase">3ヶ月前 (-3 month)</span>
                        <h4 class="text-lg font-bold text-slate-800"><?= $prev_day ?></h4>
                    </div>
                    <code class="text-xs bg-slate-100 px-2 py-1 rounded text-slate-500"><?= $prev_day_time ?></code>
                </div>
                <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200 hover:bg-amber-50 transition">
                    <div>
                        <span class="text-xs font-bold text-amber-600 uppercase">3時間後 (+3 hour)</span>
                        <h4 class="text-lg font-bold text-slate-800"><?= $next_hour ?></h4>
                    </div>
                    <code class="text-xs bg-slate-100 px-2 py-1 rounded text-slate-500"><?= $next_hour_time ?></code>
                </div>
                <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200 hover:bg-amber-50 transition">
                    <div>
                        <span class="text-xs font-bold text-amber-600 uppercase">次の日曜日 (+1 sunday)</span>
                        <h4 class="text-lg font-bold text-slate-800"><?= $next_week ?></h4>
                    </div>
                    <code class="text-xs bg-slate-100 px-2 py-1 rounded text-slate-500"><?= $next_week_time ?></code>
                </div>
            </div>
            <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-400 text-sm text-blue-700 rounded-r-lg">
                <strong>Tips:</strong> <code>strtotime</code> 関数を使うと、人間が読むような自然な英語表現で日付を計算できます。
            </div>
        </section>

        <footer class="pt-12 border-t border-slate-200 text-center">
            <p class="text-slate-500 text-sm italic">"日付や時刻の扱いはシステム開発において非常に重要です。適切なフォーマットと正確なタイムスタンプの理解を深めましょう。"</p>
        </footer>
    </main>

</body>

</html>