<?php
date_default_timezone_set('Asia/Tokyo');

$today = new DateTime();
// 現在の年と月を取得
$year = $today->format('Y');
$month = $today->format('n');

// クエリパラメータがあれば取得
if (isset($_GET['y'])) $year = (int)$_GET['y'];
if (isset($_GET['m'])) $month = (int)$_GET['m'];

$today->setDate($year, $month, 1);
$end_day = (int)$today->format('t');
$days = range(1, $end_day);

// カレンダー配列の初期化 (最大6行)
$calendar = array_fill(0, 6, array_fill(0, 7, null));
$row = 0;

// 1日から月末までループ
foreach ($days as $day) {
    $date = new DateTime();
    $date->setDate($year, $month, $day);
    $week_number = (int)$date->format('w'); // 0 (日) から 6 (土)

    $calendar[$row][$week_number] = $date;

    // 土曜日（6）なら次の行へ
    if ($week_number === 6) {
        $row++;
    }
}

function isToday($date)
{
    $today = new DateTime();
    return $date->format('Y-m-d') === $today->format('Y-m-d');
}

function getDayClass($date)
{
    if (!$date) return 'bg-slate-50 opacity-20';
    // 本日の場合
    if (isToday($date)) return 'bg-orange-500 text-white font-bold';
    // 曜日を取得
    $w = (int)$date->format('w');
    // 日曜日
    if ($w === 0) return 'text-rose-500 bg-rose-50 font-bold';
    // 土曜日
    if ($w === 6) return 'text-blue-500 bg-blue-50 font-bold';
    // 平日
    return 'text-slate-700 hover:bg-indigo-50 transition-colors cursor-default';
}

// 前月・次月のリンク用
$prev_month_date = clone $today;
$prev_month_date->modify('-1 month');
$next_month_date = clone $today;
$next_month_date->modify('+1 month');
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Samples</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 leading-relaxed antialiased">

    <main class="max-w-4xl mx-auto px-6 py-12">
        <!-- Header -->
        <header class="text-center mb-2">
            <h1 class="font-outfit text-4xl font-extrabold tracking-tight text-slate-900 leading-none">
                Calendar <span class="text-rose-600">App</span>
            </h1>
            <p class="text-left mt-4 text-sm leading-relaxed">
                PHPのDateTimeクラスと配列を組み合わせて、実用的なカレンダー表示ロジックを作成します。月の初日、末日、曜日の判定などの基本を応用しています。
            </p>
        </header>

        <section class="mb-12">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
                <!-- Calendar Header -->
                <div class="bg-slate-900 px-8 py-6 flex items-center justify-between">
                    <h4 class="text-white text-2xl font-black tracking-tight">
                        <?= $year ?><span class="text-slate-500 mx-2">/</span><?= sprintf('%02d', $month) ?>
                    </h4>
                    <div class="flex gap-2">
                        <a href="?y=<?= $prev_month_date->format('Y') ?>&m=<?= $prev_month_date->format('n') ?>"
                            class="p-2 hover:bg-slate-800 rounded-lg text-slate-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <a href="?y=<?= date('Y') ?>&m=<?= date('n') ?>" class="px-4 py-2 bg-slate-800 hover:bg-indigo-600 text-slate-300 hover:text-white text-xs font-bold rounded-lg transition uppercase tracking-widest flex items-center">Today</a>
                        <a href="?y=<?= $next_month_date->format('Y') ?>&m=<?= $next_month_date->format('n') ?>"
                            class="p-2 hover:bg-slate-800 rounded-lg text-slate-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Days of Week -->
                <div class="calendar-grid bg-slate-100 border-b border-slate-200">
                    <?php
                    $weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    foreach ($weekdays as $index => $day):
                        $text_color = ($index === 0) ? 'text-rose-500' : (($index === 6) ? 'text-blue-500' : 'text-slate-400');
                    ?>
                        <div class="py-3 text-center text-[10px] font-black uppercase tracking-widest <?= $text_color ?>">
                            <?= $day ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Calendar Body -->
                <div class="calendar-grid bg-white">
                    <?php foreach ($calendar as $row_date):
                        // 行が空（すべてnull）ならスキップ
                        if (count(array_filter($row_date)) === 0) continue;
                    ?>
                        <?php foreach ($row_date as $date): ?>
                            <div class="aspect-square border-r border-b border-slate-50 flex flex-col items-center justify-center p-2 relative <?= getDayClass($date) ?>">
                                <?php if ($date): ?>
                                    <span class="text-lg font-bold"><?= $date->format('j') ?></span>
                                    <?php if (isToday($date)): ?>
                                        <div class="absolute bottom-2 w-1 h-1 bg-white rounded-full"></div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mt-8 bg-indigo-50 p-6 rounded-2xl border border-indigo-100">
                <h5 class="text-indigo-900 font-bold mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    実装のポイント
                </h5>
                <ul class="text-sm text-indigo-700 space-y-4 list-disc list-inside">
                    <li><code>new DateTime()</code> を使用したオブジェクト指向な日付操作</li>
                    <li><code>format('t')</code> による月の日数取得</li>
                    <li><code>format('w')</code> を活用した曜日ごとのセル配置</li>
                    <li>クエリパラメータによる動的な月の切り替え機能</li>
                </ul>
            </div>
        </section>

        <!-- Dashboard Link -->
        <?php include '../components/footer.php'; ?>
    </main>

</body>

</html>