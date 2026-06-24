<?php

use App\Models\AuthUser;

$auth_user = AuthUser::get();
?>

<?php if (isset($auth_user)): ?>
    <nav id="side-menu" class="flex h-full flex-col gap-1 p-2 xl:p-4">

        <a href="home/" class="flex items-center justify-center gap-0 rounded-xl px-3 py-3 font-semibold text-slate-800 transition hover:bg-sky-50 xl:justify-start xl:gap-3">
            <img src="<?= BASE_URL ?>svg/home.svg" class="w-6 h-6 shrink-0">
            <span class="hidden xl:inline">ホーム</span>
        </a>

        <a href="home/garally.php" class="flex items-center justify-center gap-0 rounded-xl px-3 py-3 font-semibold text-slate-800 transition hover:bg-sky-50 xl:justify-start xl:gap-3">
            <img src="<?= BASE_URL ?>svg/image.svg" class="w-6 h-6 shrink-0">
            <span class="hidden xl:inline">メディア</span>
        </a>

        <a href="about/" class="flex items-center justify-center gap-0 rounded-xl px-3 py-3 font-semibold text-slate-800 transition hover:bg-sky-50 xl:justify-start xl:gap-3">
            <img src="<?= BASE_URL ?>svg/info.svg" class="w-6 h-6 shrink-0">
            <span class="hidden xl:inline">About</span>
        </a>

        <!-- ユーザーメニュー（下部） -->
        <div class="mt-auto pt-4 border-t border-slate-100 relative">
            <button id="user-menu" class="flex w-full items-center justify-center gap-0 rounded-xl px-3 py-2 text-left transition hover:bg-sky-50 xl:justify-start xl:gap-3">
                <img src="<?= AuthUser::profileImage($auth_user['profile_image']) ?>"
                    class="w-10 h-10 rounded-full object-cover shrink-0" id="user-icon">
                <div class="hidden min-w-0 xl:block">
                    <p class="text-sm font-bold text-slate-800 truncate"><?= htmlspecialchars($auth_user['display_name']) ?></p>
                    <p class="text-xs text-slate-400 truncate">@<?= htmlspecialchars($auth_user['account_name']) ?></p>
                </div>
            </button>

            <!-- ポップアップ（初期状態は非表示） -->
            <div id="user-popup" class="hidden absolute bottom-full left-1/2 mb-1 w-56 -translate-x-1/2 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg z-10 xl:left-0 xl:translate-x-0">
                <a href="user/" class="block px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-sky-50 transition">
                    プロフィール
                </a>
                <a href="user/logout.php" class="block px-4 py-3 text-sm font-semibold text-red-500 hover:bg-red-50 transition border-t border-slate-100">
                    @<?= h($auth_user['account_name']) ?> からログアウト
                </a>
            </div>
        </div>

    </nav>
<?php endif; ?>