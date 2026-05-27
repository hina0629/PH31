<?php

/**
 * 07_form_session/post_request.php
 * POST & Session 認証シミュレーター
 */

// TODO: セッションの開始

// セッションから各種データを取得
// TODO: previous_post
$posts = [];
// TODO: status
$status = "";
// TODO: authUser
$authUser = [];
$message = flashMessage();

// TODO: フラッシュメッセージの削除 (リロード時に消えるように): unset() status

// 表示用のデータ
$email = $posts['email'] ?? '';

function flashMessage()
{
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
        return $message;
    }
    return '';
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>認証ラボ | PHP Form & Session</title>
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased bg-slate-50 text-slate-900 py-12 px-4">
    <main class="max-w-2xl mx-auto">
        <!-- Header -->
        <header class="text-center mb-2">
            <div class="inline-block px-3 py-1 mb-3 rounded-full bg-rose-100 text-rose-700 text-sm font-black uppercase tracking-[0.2em]">
                Authentication Simulator
            </div>
            <h1 class="font-outfit text-4xl font-extrabold tracking-tight text-slate-900 leading-none">
                Identity <span class="text-rose-600">Check</span>
            </h1>
            <p class="text-slate-500 mt-4 text-sm leading-relaxed italic">
                テストユーザー: user@example.com / password123
            </p>
        </header>

        <!-- Status Message (Flash Message) -->
        <?php if ($message): ?>
            <div class="mb-8 p-5 rounded-[2rem] border-2 flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500 <?= $status === 'success' ? 'bg-emerald-50 border-emerald-100 text-emerald-800' : 'bg-rose-50 border-rose-100 text-rose-800' ?>">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 <?= $status === 'success' ? 'bg-emerald-500' : 'bg-rose-500' ?> text-white shadow-lg">
                    <?php if ($status === 'success'): ?>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    <?php else: ?>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    <?php endif; ?>
                </div>
                <p class="font-bold"><?= htmlspecialchars($message) ?></p>
            </div>
        <?php endif; ?>

        <?php if ($authUser): ?>
            <div class="flex justify-between mb-8 p-5 rounded-[2rem] border-2 items-center gap-4">
                <p class="font-bold"><?= htmlspecialchars($authUser['name']) ?>さん、おかえりなさい！</p>
                <p>
                    <a href="logout.php" class="bg-rose-100 text-rose-900 font-bold py-2 px-4 rounded-2xl shadow-xl hover:bg-rose-200 active:scale-[0.98] transition-all text-sm">ログアウト</a>
                </p>
            </div>
        <?php endif; ?>

        <!-- Main Card -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200 overflow-hidden border border-white">
            <div class="p-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-indigo-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-black tracking-tight">サインイン</h2>
                </div>

                <form action="post_receive.php" method="post" class="space-y-6">
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-black text-slate-400 uppercase tracking-widest ml-1">メールアドレス</label>
                        <input type="text" name="email" id="email"
                            class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition-all text-sm outline-none font-bold"
                            placeholder="user@example.com"
                            value="<?= htmlspecialchars($email) ?>">
                    </div>
                    <div class="space-y-2">
                        <label for="password" class="text-sm font-black text-slate-400 uppercase tracking-widest ml-1">パスワード</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition-all text-sm outline-none font-bold"
                            placeholder="••••••••">
                    </div>
                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl shadow-xl hover:bg-slate-800 active:scale-[0.98] transition-all text-sm">
                        ログイン
                    </button>
                </form>
            </div>

            <div class="bg-white p-8 border-t border-slate-100">
                <p class="text-sm text-rose-600 leading-relaxed">
                    送信された情報は <code>post_receive.php</code> で検証され、結果がセッションに保存されます。このページはリダイレクト後にそのセッション情報を読み取って表示を切り替えています。
                </p>
            </div>
        </div>

        <!-- Dashboard Link -->
        <?php include '../components/footer.php'; ?>
    </main>
</body>

</html>