<?php

/**
 * ビンゴカード生成ロジック
 */
// BINGOの各列のラベル
$labels = ['B', 'I', 'N', 'G', 'O'];
// 各列の番号の範囲
// TODO: 各列の番号の範囲を定義:  range()
// 1 - 15, 16 - 30, 31 - 45, 46 - 60, 61 - 75
$ranges = [
    'B' => [],
    'I' => [],
    'N' => [],
    'G' => [],
    'O' => [],
];

// 各列の番号を格納する配列
$columns = [];
// TODO: 各列の番号の範囲をループ: foreach($ranges as $label => $range)
// 各列の番号をシャッフル
// shuffle($range);
// 5つ選ぶ
// $columns[$label] = array_slice($range, 0, 5);

// 中央（N列の3番目）を FREE に
$columns['N'][2] = 'FREE';

/**
 * 縦の列データを横の行データに変換 (5x5)
 */
// 縦の列データを横の行データに変換する配列
$rows = [];
// 5x5のビンゴカードを作成
for ($i = 0; $i < 5; $i++) {
    // $labels をループ
    foreach ($labels as $label) {
        if (isset($columns[$label][$i])) {
            $rows[$i][] = $columns[$label][$i];
        }
    }
}

// ラベルごとの色設定
$colors = [
    'B' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-600', 'light' => 'bg-blue-50'],
    'I' => ['bg' => 'bg-rose-500', 'text' => 'text-rose-600', 'light' => 'bg-rose-50'],
    'N' => ['bg' => 'bg-amber-500', 'text' => 'text-amber-600', 'light' => 'bg-amber-50'],
    'G' => ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-600', 'light' => 'bg-emerald-50'],
    'O' => ['bg' => 'bg-purple-500', 'text' => 'text-purple-600', 'light' => 'bg-purple-50'],
];
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プレミアム・ビンゴ | PHP Repeat</title>
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Outfit', 'Noto Sans JP', sans-serif;
        }

        .bingo-cell {
            aspect-ratio: 1 / 1;
        }

        .free-star {
            filter: drop-shadow(0 0 8px rgba(245, 158, 11, 0.5));
        }
    </style>
</head>

<body class="antialiased min-h-screen py-2 px-4">
    <main class="max-w-md mx-auto">
        <!-- Header -->
        <header class="text-center mb-1">
            <div class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-white/60 text-[10px] font-bold uppercase tracking-[0.3em]">
                PHP Array & Loop Training
            </div>
            <h1 class="text-5xl font-black mb-2 tracking-tighter italic">
                BINGO<span class="text-amber-400">!</span>
            </h1>
            <p class="text-slate-500 text-sm font-bold">ランダムな数値配列の生成と繰り返し表示</p>
        </header>

        <div class="mt-2 flex flex-col items-center gap-6">
            <button onclick="window.location.reload()" class="group relative inline-flex items-center justify-center px-8 py-4 font-black text-white bg-sky-600 rounded-2xl">
                新しいカードを引く
                <svg class="w-5 h-5 ml-2 transform group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </button>
        </div>

        <!-- Bingo Card Container -->
        <div class="bg-white rounded-[2rem] p-4 shadow-lg border-slate-300">
            <!-- Header Labels -->
            <div class="grid grid-cols-5 gap-2 mb-2">
                <!-- TODO: コロン構文 foreach でラベルを繰り返し -->
                    <div class="<?= $colors[$label]['bg'] ?> rounded-2xl bingo-cell flex items-center justify-center text-2xl text-white font-black shadow-inner">
                        <?= $label ?>
                    </div>
            </div>

            <!-- Numbers Grid -->
            <div class="grid grid-cols-5 gap-2">
                <!-- TODO: $rows で繰り返し -->
                <?php foreach ([] as $row): ?>
                    <!-- TODO: $row で繰り返し -->
                    <?php foreach ([] as $value): ?>
                        <?php
                        $isFree = ($value === 'FREE');
                        ?>
                        <div class="bingo-cell relative group">
                            <div class="absolute inset-0 bg-slate-100 rounded-2xl transform transition-transform group-hover:scale-95"></div>
                            <div class="relative h-full flex items-center justify-center text-xl font-black <?= $isFree ? 'text-amber-500' : 'text-slate-800' ?>">
                                <?php if ($isFree): ?>
                                    <!-- isFree の場合 -->
                                    <svg class="w-10 h-10 free-star animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                    <span class="absolute bottom-1 text-[8px] font-black uppercase tracking-widest opacity-50">Free</span>
                                <?php else: ?>
                                    <!-- TODO: $value を表示 -->
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Controls -->
        <div class="mt-12 flex flex-col items-center gap-6">
            <a href="../index.php" class="text-sm font-bold text-slate-500 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                ダッシュボードに戻る
            </a>
        </div>
    </main>
</body>

</html>