<?php
// TODO: 日付オブジェクトの生成（パラメータがあればその日、なければ今日）
// $targetDate = isset($_GET['date']) ? new DateTime($_GET['date']) : new DateTime();

// TODO: 曜日インデックス（0:日 〜 6:土）
$weekIndex = 0;

// 日本語の曜日名を取得 (IntlDateFormatterを使用)
$formatter = new IntlDateFormatter('ja_JP', IntlDateFormatter::NONE, IntlDateFormatter::NONE, null, null, 'E');
// TODO: 曜日フォーマット
$weekDay = "";

// ゴミ出しのルールを定義
$burnable = ["is_garbage" => true, "label" => "燃えるゴミ", "color" => "bg-rose-500"];
$unburnable = ["is_garbage" => true, "label" => "燃えないゴミ", "color" => "bg-amber-500"];
$none = ["is_garbage" => false, "label" => "回収なし", "color" => "bg-slate-400"];

// TODO: ゴミ出しの判定 (PHP 8.0+ match式)
// 1, 3 → 月、水 → 燃えるゴミ
// 5 → 金 → 燃えないゴミ
// 2, 4, 6, 0 → 火、木、土、日 → 回収なし
$garbage = $none; 

// レイアウト用の色設定
$statusColor = $garbage['color'];
// メッセージ設定
$message = $garbage['is_garbage'] ? "朝8時までに集積所へ！" : "今日はゆっくり過ごしましょう。";
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ゴミ出しカレンダー | PHP Condition</title>
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased min-h-screen bg-slate-50 text-slate-900 py-12 px-4">
    <main class="max-w-md mx-auto">
        <!-- Header -->
        <header class="text-center mb-10">
            <h1 class="text-4xl font-extrabold mb-2 tracking-tight text-slate-900">
                Garbage Check
            </h1>
            <p class="text-slate-500 text-sm">条件分岐を利用したスケジュール判定</p>
        </header>

        <!-- Main Card -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/60 overflow-hidden border border-slate-100">
            <!-- Date Banner -->
            <div class="p-8 text-center border-b border-slate-50">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mb-2">Target Date</p>
                <div class="flex items-center justify-center gap-3">
                    <span class="text-3xl font-black font-outfit"><?= $targetDate->format('Y.m.d') ?></span>
                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-sm font-bold"><?= $weekDay ?>曜日</span>
                </div>
            </div>

            <!-- Status Content -->
            <div class="p-10 text-center">
                <div class="mb-6 inline-flex items-center justify-center w-20 h-20 rounded-3xl <?= $statusColor ?> text-white shadow-lg shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>

                <h2 class="text-slate-400 text-sm font-bold uppercase tracking-widest mb-2">本日の回収内容</h2>
                <div class="text-4xl font-black text-slate-900 tracking-tight mb-2">
                    <?= $garbage['label'] ?>
                </div>
                <p class="text-slate-400 text-sm italic">
                    <?= $message ?>
                </p>
            </div>

            <!-- Links for Testing -->
            <div class="bg-slate-50 p-6 flex flex-wrap justify-center gap-2">
                <a href="?date=2026-03-02" class="text-[10px] font-bold px-3 py-1.5 rounded-full bg-white border border-slate-200 text-slate-500 hover:border-indigo-300 hover:text-indigo-600 transition-all">月曜(燃える)</a>
                <a href="?date=2026-03-03" class="text-[10px] font-bold px-3 py-1.5 rounded-full bg-white border border-slate-200 text-slate-500 hover:border-indigo-300 hover:text-indigo-600 transition-all">火曜(なし)</a>
                <a href="?date=2026-03-06" class="text-[10px] font-bold px-3 py-1.5 rounded-full bg-white border border-slate-200 text-slate-500 hover:border-indigo-300 hover:text-indigo-600 transition-all">金曜(不燃)</a>
            </div>
        </div>

        <!-- Meta Info -->
        <div class="mt-8 bg-slate-100/50 rounded-2xl p-4 border border-slate-200/50">
            <div class="flex justify-between items-center text-[10px] font-mono text-slate-500">
                <span>Week Index: <?= $weekIndex ?></span>
                <span>PHP 8.x Match Expression</span>
            </div>
        </div>

        <footer class="mt-12 text-center">
            <a href="../index.php" class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                ダッシュボードに戻る
            </a>
        </footer>
    </main>
</body>

</html>