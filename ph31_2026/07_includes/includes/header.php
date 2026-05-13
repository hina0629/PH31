<!-- ========================================
     共通ヘッダー (includes/header.php)
     include で読み込む再利用可能なパーツ
     ======================================== -->
<header class="bg-white border-b border-slate-200 sticky top-0 z-10">
    <div class="max-w-5xl mx-auto px-6 py-4 flex justify-between items-center">
        <div>
            <span class="text-xs font-bold uppercase tracking-widest text-violet-600 bg-violet-50 px-2 py-0.5 rounded">includes/header.php</span>
            <h1 class="text-xl font-extrabold tracking-tight text-slate-900 mt-1"><?= STORE_NAME ?></h1>
        </div>
        <a href="../index.php" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition">&larr; ダッシュボード</a>
    </div>
</header>
