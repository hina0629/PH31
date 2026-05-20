<?php
// 外部データの読み込み
require_once __DIR__ . '/data/users.php';
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー一覧 | PHP Array Object</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased min-h-screen bg-slate-50 text-slate-900 py-12 px-4">
    <main class="max-w-4xl mx-auto">
        <!-- Header -->
        <header class="text-center mb-12">
            <div class="inline-block px-4 py-1.5 mb-4 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-widest">
                PHP Array & Object
            </div>
            <h1 class="text-4xl font-extrabold mb-4 tracking-tight text-slate-900">
                User Directory
            </h1>
            <p class="text-slate-500 text-sm max-w-xl mx-auto leading-relaxed">
                配列データを外部ファイル（data/users.php）から読み込み、詳細画面への遷移とデータの出し分けをシミュレートしています。
            </p>
        </header>

        <!-- User Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php if (isset($users) && is_array($users)): ?>
                <?php foreach ($users as $user): ?>
                    <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center gap-6 group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="shrink-0">
                            <img src="../images/users/<?= $user['avatar'] ?>" alt="<?= $user['display_name'] ?>"
                                class="w-20 h-20 rounded-3xl object-cover bg-slate-100 ring-4 ring-slate-50">
                        </div>

                        <div class="grow min-w-0">
                            <p class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] mb-1"><?= $user['role'] ?></p>
                            <h2 class="text-xl font-bold text-slate-900 mb-1 truncate"><?= $user['display_name'] ?></h2>
                            <p class="text-xs text-slate-400 font-medium truncate mb-4">@<?= $user['account_name'] ?></p>

                            <a href="detail.php?id=<?= $user['id'] ?>"
                                class="inline-flex items-center text-xs font-bold text-slate-900 hover:text-indigo-600 transition-colors">
                                プロフィールを見る
                                <svg class="w-3 h-3 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full p-12 text-center bg-white rounded-[2.5rem] border border-dashed border-slate-200">
                    <p class="text-slate-400 font-medium">ユーザーが見つかりません。</p>
                </div>
            <?php endif; ?>
        </div>

        <footer class="mt-16 text-center">
            <a href="../../" class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                ダッシュボードに戻る
            </a>
        </footer>
    </main>
</body>

</html>