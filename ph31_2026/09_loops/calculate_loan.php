<?php
// 初期値の設定: GETパラメータから受け取り、存在しない場合はデフォルト値を使用
$start_loan = isset($_GET['loan']) ? (int)$_GET['loan'] : 20000000;
$pay_by_month = isset($_GET['pay_by_month']) ? (int)$_GET['pay_by_month'] : 80000;
$interest_rate = isset($_GET['interest_rate']) ? (float)$_GET['interest_rate'] : 1.5;

// 計算用変数
$loan = $start_loan;
$total_interest = 0;
$month_count = 0;
$values = [];
$error_message = "";

// 支払い月額が初月の利息より低い場合の無限ループ防止
$first_month_interest = ($loan * $interest_rate / 100) / 12;
if ($pay_by_month <= $first_month_interest) {
    $error_message = "月々の支払額が利息額（&yen;" . number_format(ceil($first_month_interest)) . "）を下回っているため、返済が完了しません。";
} else {
    // 支払い計算ループ（最大1000ヶ月 = 約83年で制限）
    // TODO: while で繰り返し: 条件式を修正（$loan > 0 && $month_count < 1000）
    while (false) {
        // 月数カウンターを1増やす
        $month_count++;
        // 利息計算: 年利を12で割って月利を計算し、ローン残高に掛ける
        $interest = ($loan * $interest_rate / 100) / 12;

        // 最終月の調整
        if ($loan + $interest < $pay_by_month) {
            // 最終月は残高と利息の合計額を支払う
            $payment = $loan + $interest;
            // ローン残高を0にする
            $loan = 0;
        } else {
            // 通常月は月々の支払額を支払う
            $payment = $pay_by_month;
            // TODO: ローン残高から支払額を引く
            $loan = 0;
        }

        // TODO: 利息合計を計算
        $total_interest = 0;

        // 12ヶ月ごと、または最終月のみデータを保存（全データだと重くなるため）
        if ($month_count % 12 == 0 || $loan <= 0) {
            // 12ヶ月ごと、または最終月のデータを配列に保存
            $values[] = [
                'month' => $month_count,
                'year' => ceil($month_count / 12),
                'interest' => round($interest),
                'loan' => max(0, round($loan))
            ];
        }
    }
}

// 総支払額を計算
$total_payment = $start_loan + $total_interest;
// 返済年数を計算
$years = floor($month_count / 12);
// 残りの月数を計算
$remaining_months = $month_count % 12;
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>住宅ローンシミュレーター | PHP Repeat</title>
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased bg-slate-50 text-slate-900 pb-20">
    <main class="max-w-6xl mx-auto px-4 pt-12">
        <!-- Header -->
        <header class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <div class="inline-block px-3 py-1 mb-3 rounded-full bg-sky-100 text-sky-700 text-xs font-bold uppercase tracking-widest">
                    Financial Simulation
                </div>
                <h1 class="font-outfit text-4xl font-extrabold tracking-tight text-slate-900">
                    Loan <span class="text-sky-600">Simulator</span>
                </h1>
            </div>
            <a href="../index.php" class="text-sm font-bold text-slate-400 hover:text-sky-600 transition-colors inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                ダッシュボードに戻る
            </a>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Sidebar: Form -->
            <aside class="lg:col-span-4">
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200 sticky top-8">
                    <h2 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        返済条件の設定
                    </h2>

                    <form action="" method="get" class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">総借入額</label>
                            <div class="relative">
                                <input type="number" name="loan" value="<?= $start_loan ?>" class="w-full pl-4 pr-12 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-4 focus:ring-sky-50 transition-all font-bold">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">円</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">年利（固定）</label>
                            <div class="relative">
                                <input type="number" step="0.1" name="interest_rate" value="<?= $interest_rate ?>" class="w-full pl-4 pr-12 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-4 focus:ring-sky-50 transition-all font-bold">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">%</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">毎月の支払額</label>
                            <div class="relative">
                                <input type="number" name="pay_by_month" value="<?= $pay_by_month ?>" class="w-full pl-4 pr-12 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-4 focus:ring-sky-50 transition-all font-bold">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">円</span>
                            </div>
                        </div>

                        <div class="pt-4 flex gap-2">
                            <button class="flex-1 bg-sky-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-sky-100 hover:bg-sky-700 active:scale-95 transition-all">再計算する</button>
                            <a href="?" class="px-6 bg-slate-100 text-slate-500 py-4 rounded-2xl font-bold hover:bg-slate-200 transition-all flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </a>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Main Content: Results -->
            <div class="lg:col-span-8 space-y-8">
                <?php if ($error_message): ?>
                    <div class="bg-rose-50 border-2 border-rose-100 p-6 rounded-3xl flex items-start gap-4">
                        <div class="w-10 h-10 bg-rose-500 rounded-xl flex items-center justify-center shrink-0 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-rose-900">計算エラー</p>
                            <p class="text-rose-700 text-sm"><?= $error_message ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        <div class="bg-sky-600 rounded-[2rem] p-8 text-white shadow-xl shadow-sky-100">
                            <p class="text-sky-200 text-xs font-bold uppercase tracking-widest mb-2">総支払額</p>
                            <p class="text-xl font-black">&yen;<?= number_format($total_payment) ?></p>
                            <p class="text-sky-200 text-[10px] mt-2 font-medium">元金 + 利息合計</p>
                        </div>
                        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200">
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">利息合計</p>
                            <p class="text-xl font-black text-rose-500">&yen;<?= number_format(round($total_interest)) ?></p>
                            <p class="text-slate-400 text-[10px] mt-2 font-medium">支払額の <?= round(($total_interest / $total_payment) * 100, 1) ?>%</p>
                        </div>
                        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200">
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">返済期間</p>
                            <p class="text-xl font-black text-slate-900"><?= $years ?><span class="text-sm ml-1">年</span><?= $remaining_months ?><span class="text-sm ml-1">ヶ月</span></p>
                            <p class="text-slate-400 text-[10px] mt-2 font-medium">合計 <?= $month_count ?> 回の支払い</p>
                        </div>
                    </div>

                    <!-- Details Table -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
                        <div class="p-8 border-b border-slate-100 flex justify-between items-center">
                            <h2 class="text-lg font-bold">返済予定の明細（年次抜粋）</h2>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Calculated with PHP 8.x Loop</span>
                        </div>
                        <div class="max-h-[500px] overflow-y-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="sticky top-0 bg-slate-50 text-slate-400 text-[10px] font-bold uppercase tracking-widest z-10">
                                    <tr>
                                        <th class="px-8 py-4">経過年数</th>
                                        <th class="px-8 py-4">支払い回数</th>
                                        <th class="px-8 py-4 text-right">利息額</th>
                                        <th class="px-8 py-4 text-right">ローン残高</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    <!-- 明細を繰り返し表示: $values -->
                                    <?php foreach ($values as $value) : ?>
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <!-- TODO: 経過年数を表示 -->
                                            <td class="px-8 py-4 font-bold text-slate-400 italic"> 年目</td>
                                            <!-- TODO: 支払い回数を表示 -->
                                            <td class="px-8 py-4 font-medium"> 回目</td>
                                            <!-- TODO: 利息額を表示 -->
                                            <td class="px-8 py-4 text-right text-rose-400">&yen;</td>
                                            <!-- TODO: ローン残高を表示 -->
                                            <td class="px-8 py-4 text-right font-bold text-slate-900">&yen;</td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>