<?php

/**
 * スーパーグローバル変数のデモ
 * 
 * PHPには、どこからでもアクセスできる特別な組み込み変数「スーパーグローバル」があります。
 * これらを使うことで、ユーザーからの入力やサーバーの情報、セッション情報などを取得できます。
 */

// TODO: $_GET: URLパラメータの取得 (?name=Taro などの値)
// URLパラメータから 'name' を取得し、なければ 'ゲスト' をデフォルト値
$name = '';

// TODO: $_POST: フォームから送信されたデータの取得
// フォームから送信された 'user_name' と 'message' を取得し、なければ空文字をデフォルト値
$postedMessage =  '';
$postedName = '';

// TODO: $_SERVER: サーバーや実行環境の情報
// サーバー名:$_SERVER['SERVER_NAME']
$serverName = "";
// ユーザーエージェント: $_SERVER['HTTP_USER_AGENT']
$userAgent = "";
// リクエスト方法: $_SERVER['REQUEST_METHOD']
$requestMethod = "";
// クライアントのIPアドレス: $_SERVER['REMOTE_ADDR']
$remoteAddr = "";
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スーパーグローバル変数 | PHP基礎</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-900 py-12 px-4">
    <main class="max-w-3xl mx-auto pb-20">
        <header class="text-center mb-12">
            <div class="inline-block px-3 py-1 mb-3 rounded-full bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-widest">
                Superglobal Variables
            </div>
            <h2 class="text-4xl font-extrabold tracking-tight mb-2">
                特別な変数「<span class="text-amber-600">スーパーグローバル</span>」
            </h2>
            <p class="text-slate-500">PHPが最初から用意している、どこからでも使える特別な変数たちです。</p>
        </header>

        <!-- $_GET Demo -->
        <section class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 mb-8">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2 text-blue-600">
                <span class="w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center text-sm font-mono italic">G</span>
                $_GET (URLパラメータ)
            </h2>
            <div class="bg-blue-50 p-4 rounded-2xl mb-6 border border-blue-100">
                <p class="text-sm text-blue-800 font-bold mb-2">こんにちは、<?= htmlspecialchars($name) ?> さん！</p>
                <p class="text-xs text-blue-600 leading-relaxed italic">
                    URLの最後に <code>?name=あなたの名前</code> を付けてアクセスすると値が変わります。
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="?name=Yamada" class="text-sm font-bold bg-white border border-blue-200 px-3 py-2 rounded-xl text-blue-600 hover:bg-blue-50 transition-all">Yamada</a>
                <a href="?name=Tanaka" class="text-sm font-bold bg-white border border-blue-200 px-3 py-2 rounded-xl text-blue-600 hover:bg-blue-50 transition-all">Tanaka</a>
                <a href="superglobals.php" class="text-sm font-bold bg-white border border-slate-200 px-3 py-2 rounded-xl text-slate-500 hover:bg-slate-50 transition-all">リセット</a>
            </div>
        </section>

        <!-- $_POST Demo -->
        <section class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 mb-8">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2 text-rose-600">
                <span class="w-8 h-8 bg-rose-500 text-white rounded-lg flex items-center justify-center text-sm font-mono italic">P</span>
                $_POST (フォームデータ)
            </h2>

            <?php if ($requestMethod === 'POST'): ?>
                <div class="bg-rose-50 p-6 rounded-2xl mb-8 border border-rose-100 shadow-inner">
                    <p class="text-sm font-black text-rose-400 uppercase tracking-widest mb-3">受信したデータ</p>
                    <div class="space-y-2">
                        <p class="text-sm font-bold text-rose-900">名前: <span class="font-normal"><?= htmlspecialchars($postedName) ?></span></p>
                        <p class="text-sm font-bold text-rose-900">メッセージ: <span class="font-normal"><?= htmlspecialchars($postedMessage) ?></span></p>
                    </div>
                </div>
            <?php endif; ?>

            <form action="superglobals.php" method="post" class="space-y-4">
                <div>
                    <label class="text-sm font-bold text-slate-400 uppercase tracking-widest block mb-1">お名前</label>
                    <input type="text" name="user_name" placeholder="例：鈴木" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-rose-500 focus:ring-4 focus:ring-rose-50 transition-all text-sm outline-none">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-400 uppercase tracking-widest block mb-1">メッセージ</label>
                    <textarea name="message" placeholder="ここに入力した文字が$_POSTで受け取れます" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-rose-500 focus:ring-4 focus:ring-rose-50 transition-all text-sm outline-none h-24"></textarea>
                </div>
                <button type="submit" class="w-full bg-rose-500 text-white font-bold py-3 rounded-xl shadow-lg shadow-rose-100 hover:bg-rose-600 active:scale-95 transition-all text-sm">
                    POST送信を試す
                </button>
            </form>
        </section>

        <!-- $_SERVER Demo -->
        <section class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2 text-indigo-600">
                <span class="w-8 h-8 bg-indigo-500 text-white rounded-lg flex items-center justify-center text-sm font-mono italic">S</span>
                $_SERVER (システム情報)
            </h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-slate-50">
                    <span class="text-sm font-bold text-slate-400 uppercase tracking-wider">サーバー名</span>
                    <span class="text-sm font-mono font-bold"><?= $serverName ?></span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-slate-50">
                    <span class="text-sm font-bold text-slate-400 uppercase tracking-wider">リクエスト方法</span>
                    <span class="text-sm font-mono font-bold text-rose-600"><?= $requestMethod ?></span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-slate-50">
                    <span class="text-sm font-bold text-slate-400 uppercase tracking-wider">IPアドレス</span>
                    <span class="text-sm font-mono font-bold"><?= $remoteAddr ?></span>
                </div>
                <div class="py-3">
                    <span class="text-sm font-bold text-slate-400 uppercase tracking-wider block mb-2">ブラウザ情報 (User Agent)</span>
                    <p class="text-sm font-mono bg-slate-50 p-3 rounded-xl break-all text-slate-500 border border-slate-100">
                        <?= $userAgent ?>
                    </p>
                </div>
            </div>
        </section>

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