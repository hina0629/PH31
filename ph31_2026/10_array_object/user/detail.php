<?php
// データの読み込み
require_once 'data/users.php';

// URLパラメータからIDを取得
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 該当するユーザーを検索
$user = null;

// 1. foreach の場合
// foreach ($users as $user) {
//     if ($user['id'] === $id) {
//         $user = $user;
//         break;
//     }
// }

// 2. array_search() の場合
// $key = array_search($id, array_column($users, 'id'), true);
// $user = $key !== false ? $users[$key] : null;

// 3. array_filter() の場合
// $user = array_filter($users, fn($user) => $user['id'] === $id);
// $user = $user ? reset($user) : null;

// ユーザーが見つからない場合は一覧に戻すかエラーを表示
if (!$user) {
    header("Location: ./");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $user['display_name'] ?> のプロフィール | PHP Array Object</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-900 min-h-screen py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Back Button -->
        <a href="./" class="inline-flex items-center text-sm font-bold text-slate-400 hover:text-indigo-600 mb-8 transition-colors group">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            一覧に戻る
        </a>

        <!-- Profile Card -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200 overflow-hidden border border-white">
            <!-- Cover Header -->
            <div class="h-32 bg-gradient-to-r from-indigo-500 to-purple-600"></div>

            <div class="px-8 pb-10">
                <!-- Avatar -->
                <div class="relative -mt-16 mb-6">
                    <!-- TODO: アバター画像を表示 -->
                    <img src="" alt="" class="w-32 h-32 rounded-3xl border-4 border-white shadow-lg object-cover bg-white">
                </div>

                <!-- Profile Info -->
                <div class="mb-8">
                    <!-- TODO: ユーザー名を表示 -->
                    <h1 class="text-3xl font-black tracking-tight mb-1"></h1>
                    <!-- TODO: アカウント名を @+アカウント名で表示 -->
                    <p class="text-slate-400 font-bold text-sm uppercase tracking-widest"></p>
                </div>

                <!-- Roles & Tags -->
                <div class="flex flex-wrap gap-2 mb-8">
                    <!-- TODO: ロールを表示 -->
                    <span class="px-4 py-1.5 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold ring-1 ring-indigo-100"></span>
                    <!-- TODO: IDを表示 -->
                    <span class="px-4 py-1.5 bg-slate-50 text-slate-500 rounded-full text-xs font-bold ring-1 ring-slate-100">ID: </span>
                </div>

                <!-- Bio Section -->
                <div class="bg-slate-50 rounded-3xl p-8 mb-8 border border-slate-100">
                    <h2 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4">自己紹介</h2>
                    <p class="text-slate-600 leading-relaxed font-medium">
                        <!-- TODO: 自己紹介を表示: nl2br() htmlspecialchars() を使用 -->
                    </p>
                </div>

                <!-- Contact Info -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-5 rounded-2xl bg-white border border-slate-100 shadow-sm flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email</p>
                            <!-- TODO: emailを表示 -->
                            <p class="text-sm font-bold text-slate-900 truncate"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>