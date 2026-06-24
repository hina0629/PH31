<?php

use App\Models\User;
?>
<a href="user/?id=<?= (int) $follow_user['id'] ?>" class="flex gap-3 px-4 py-4 border-b border-slate-100 hover:bg-slate-50 transition">
    <img
        src="<?= h(User::profileImage($follow_user['profile_image'] ?? null)) ?>"
        class="w-12 h-12 rounded-full object-cover shrink-0"
        alt="">
    <div class="min-w-0">
        <div class="flex items-center gap-2 flex-wrap">
            <span class="font-bold text-slate-900"><?= h($follow_user['display_name']) ?></span>
            <span class="text-sm text-slate-400">@<?= h($follow_user['account_name']) ?></span>
        </div>
        <?php if (!empty($follow_user['profile'])) : ?>
            <p class="mt-1 text-sm text-slate-600 whitespace-pre-wrap"><?= h($follow_user['profile']) ?></p>
        <?php else : ?>
            <p class="mt-1 text-sm text-slate-400">自己紹介はまだありません</p>
        <?php endif; ?>
    </div>
</a>