<?php
// 入力値の取得（URLパラメータでシミュレーション可能）
$payment = isset($_GET['payment']) ? (int)$_GET['payment'] : 1200;
$charge = isset($_GET['charge']) ? (int)$_GET['charge'] : 3000;
$isMaintenance = isset($_GET['maintenance']) && $_GET['maintenance'] === '1';

// 判定ロジック
$canPay = $charge >= $payment;
$status = "success";

// TODO: if 文
// 1. isMaintenance の場合
    $status = "maintenance";
    $message = "システムメンテナンス中";
    $subMessage = "ただいま決済機能をご利用いただけません。";

// 2. 決済できない場合
    $status = "error";
    $message = "残高が不足しています";
    $subMessage = "チャージしてから再度お試しください。";

// 3. それ以外の場合
    $status = "success";
    $message = "決済可能です";
    $subMessage = "「支払う」ボタンを押して完了してください。";

// TODO: match() で status によってレイアウト設定
    // 'success' => ['color' => 'indigo', 'icon' => 'M5 13l4 4L19 7'],
    // 'error'   => ['color' => 'rose', 'icon' => 'M6 18L18 6M6 6l12 12'],
    // 'maintenance' => ['color' => 'amber', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],

// 残高の割合（ゲージ用）
$balancePercent = min(100, max(0, ($charge / ($payment ?: 1)) * 50)); // 簡易的な計算
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スマート決済判定 | PHP Condition</title>
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased min-h-screen bg-slate-50 text-slate-900 py-12 px-4">
    <main class="max-w-md mx-auto">
        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="font-outfit text-3xl font-extrabold mb-1 tracking-tight text-slate-900">
                Payment <span class="text-indigo-600 text-base font-medium ml-1">Check</span>
            </h1>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">複合条件による決済判定</p>
        </header>

        <!-- Main Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200 overflow-hidden border border-white">
            <!-- Status Header -->
            <div class="bg-<?= $config['color'] ?>-600 p-8 text-white text-center relative overflow-hidden">
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="<?= $config['icon'] ?>"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold mb-1"><?= $message ?></h2>
                    <p class="text-white/70 text-xs font-medium"><?= $subMessage ?></p>
                </div>
                <!-- Abstract BG circles -->
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-black/5 rounded-full"></div>
            </div>

            <!-- Payment Details -->
            <div class="p-8 space-y-6">
                <div class="flex justify-between items-end pb-4 border-b border-slate-50">
                    <span class="text-slate-400 text-sm font-bold uppercase tracking-wider">支払い金額</span>
                    <span class="text-3xl font-black font-outfit text-slate-900 leading-none">&yen;<?= number_format($payment) ?></span>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm font-bold text-slate-500">
                        <span class="uppercase tracking-wider">現在の残高</span>
                        <span class="font-outfit">&yen;<?= number_format($charge) ?></span>
                    </div>
                    <!-- Balance Gauge -->
                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-<?= $config['color'] ?>-500 transition-all duration-1000" style="width: <?= $canPay ? '100%' : '30%' ?>"></div>
                    </div>
                    <!-- TODO: コロン構文 if: canPay と isMaintenance をチェック -->
                        <p class="text-[10px] text-rose-500 font-bold text-right">あと &yen;<?= number_format($payment - $charge) ?> 不足しています</p>
                </div>

                <!-- Action Button -->
                <button class="w-full py-4 rounded-2xl bg-<?= $config['color'] ?>-600 text-white font-bold shadow-lg shadow-<?= $config['color'] ?>-100 hover:scale-[1.02] active:scale-95 transition-all disabled:opacity-50 disabled:pointer-events-none" <?= (!$canPay || $isMaintenance) ? 'disabled' : '' ?>>
                    <?= $status === 'success' ? '今すぐ支払う' : ($status === 'maintenance' ? 'しばらくお待ちください' : 'チャージする') ?>
                </button>
            </div>

            <!-- Simulator Links -->
            <div class="bg-slate-50 px-8 py-6 border-t border-slate-100">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-3 text-center">シミュレーター設定</p>
                <div class="grid grid-cols-2 gap-2">
                    <a href="?payment=500&charge=2000" class="px-3 py-2 bg-white rounded-xl border border-slate-200 text-[10px] font-bold text-slate-500 hover:border-indigo-300 hover:text-indigo-600 text-center transition-all">決済成功</a>
                    <a href="?payment=5000&charge=1000" class="px-3 py-2 bg-white rounded-xl border border-slate-200 text-[10px] font-bold text-slate-500 hover:border-rose-300 hover:text-rose-600 text-center transition-all">残高不足</a>
                    <a href="?maintenance=1" class="px-3 py-2 bg-white rounded-xl border border-slate-200 text-[10px] font-bold text-slate-500 hover:border-amber-300 hover:text-amber-600 text-center transition-all">メンテナンス</a>
                    <a href="payment.php" class="px-3 py-2 bg-white rounded-xl border border-slate-200 text-[10px] font-bold text-slate-500 hover:bg-slate-100 text-center transition-all">リセット</a>
                </div>
            </div>
        </div>

        <footer class="mt-10 text-center">
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