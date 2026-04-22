<?php
// TODO: 変数: $ 記号を名前の前につけてデータを保存します
// TODO: 文末: 命令の終わりには必ず ; (セミコロン) をつけます
// TODO: PHPのバージョンを取得: phpversion()
// TODO: 複数コメント
?>
<!-- ここからHTMLレンダリング -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello World | PHP基礎</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-900 min-h-screen flex items-center justify-center p-4">
    <main class="max-w-xl w-full">
        <!-- Result Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-indigo-100 overflow-hidden border border-white p-10 text-center">

            <h1 class="font-outfit text-5xl font-black text-slate-900 tracking-tighter mb-6">
                Hello <span class="text-indigo-600">PHP!</span>
            </h1>

            <div class="bg-slate-50 rounded-3xl p-8 mb-8 border border-slate-100">
                <p class="text-xl font-bold text-slate-700 leading-relaxed">
                    <!-- 変数の中身を表示します -->
                    <?php echo $message ?>
                </p>
            </div>

            <div class="flex items-center justify-center gap-2 text-slate-400 font-bold text-xs uppercase tracking-widest">
                <span>Ver.</span>
                <span class="text-indigo-500 bg-indigo-50 px-2 py-1 rounded-lg">PHP <?= $version ?></span>
            </div>
        </div>
    </main>
</body>

</html>