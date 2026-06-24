<div class="bg-sky-50 min-h-screen flex flex-col justify-center items-center px-4 py-12">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-md p-8">

        <!-- ロゴ・タイトル -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-sky-100 mb-4">
                <svg class="w-7 h-7 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-sky-600 tracking-wide">Sign Up</h2>
            <p class="text-sm text-gray-400 mt-1">新しいアカウントを作成してください</p>
        </div>

        <!-- エラーメッセージ -->
        <?php include COMPONENT_DIR . 'error_message.php' ?>

        <form action="register/add.php" method="post" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= Lib\Csrf::token() ?>">

            <!-- アカウント名 -->
            <div class="relative">
                <input type="text" name="account_name" id="account_name"
                    value="<?= h($regist['account_name'] ?? '') ?>"
                    class="block w-full px-4 pb-2.5 pt-6
                           text-sm text-gray-800
                           bg-white border border-sky-200 rounded-xl
                           focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent
                           peer transition"
                    placeholder=" " required>
                <label for="account_name"
                    class="absolute left-4 top-4 text-sm text-gray-400
                           transition-all duration-200
                           peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm
                           peer-focus:top-1.5 peer-focus:text-xs peer-focus:text-sky-500
                           peer-[:not(:placeholder-shown)]:top-1.5 peer-[:not(:placeholder-shown)]:text-xs">
                    アカウント名
                </label>
            </div>

            <!-- 表示名 -->
            <div class="relative">
                <input type="text" name="display_name" id="display_name"
                    value="<?= h($regist['display_name'] ?? '') ?>"
                    class="block w-full px-4 pb-2.5 pt-6
                           text-sm text-gray-800
                           bg-white border border-sky-200 rounded-xl
                           focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent
                           peer transition"
                    placeholder=" " required>
                <label for="display_name"
                    class="absolute left-4 top-4 text-sm text-gray-400
                           transition-all duration-200
                           peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm
                           peer-focus:top-1.5 peer-focus:text-xs peer-focus:text-sky-500
                           peer-[:not(:placeholder-shown)]:top-1.5 peer-[:not(:placeholder-shown)]:text-xs">
                    表示名
                </label>
            </div>

            <!-- メールアドレス -->
            <div class="relative">
                <input type="email" name="email" id="email"
                    value="<?= h($regist['email'] ?? '') ?>"
                    class="block w-full px-4 pb-2.5 pt-6
                           text-sm text-gray-800
                           bg-white border border-sky-200 rounded-xl
                           focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent
                           peer transition"
                    placeholder=" " required>
                <label for="email"
                    class="absolute left-4 top-4 text-sm text-gray-400
                           transition-all duration-200
                           peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm
                           peer-focus:top-1.5 peer-focus:text-xs peer-focus:text-sky-500
                           peer-[:not(:placeholder-shown)]:top-1.5 peer-[:not(:placeholder-shown)]:text-xs">
                    メールアドレス
                </label>
            </div>

            <!-- パスワード -->
            <div class="relative">
                <input type="password" name="password" id="password"
                    class="block w-full px-4 pb-2.5 pt-6
                           text-sm text-gray-800
                           bg-white border border-sky-200 rounded-xl
                           focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent
                           peer transition"
                    placeholder=" " required>
                <label for="password"
                    class="absolute left-4 top-4 text-sm text-gray-400
                           transition-all duration-200
                           peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm
                           peer-focus:top-1.5 peer-focus:text-xs peer-focus:text-sky-500
                           peer-[:not(:placeholder-shown)]:top-1.5 peer-[:not(:placeholder-shown)]:text-xs">
                    パスワード
                </label>
            </div>

            <!-- 登録ボタン -->
            <button type="submit"
                class="w-full py-3 px-4 bg-sky-500 hover:bg-sky-600 active:bg-sky-700
                       text-white font-semibold rounded-xl
                       transition duration-200
                       disabled:bg-sky-200 disabled:cursor-not-allowed
                       shadow-sm mt-2">
                アカウントを作成する
            </button>
        </form>

        <!-- フッターリンク -->
        <div class="mt-6 space-y-2 text-center">
            <p class="text-sm text-gray-500">
                すでにアカウントをお持ちですか？
                <a href="login/" class="text-sky-500 font-semibold hover:text-sky-700 hover:underline transition">
                    Sign In
                </a>
            </p>
            <button onclick="inputTestRegistUser()"
                class="text-sm text-sky-400 hover:text-sky-600 hover:underline transition">
                Test Input
            </button>
        </div>

    </div>
</div>
