<?php if (empty($reply) || !is_array($reply)) return; ?>

<div class="flex gap-2 py-3 border-b border-slate-50 last:border-0">
    <img src="<?= h($reply['profile_image_url']) ?>" class="w-8 h-8 rounded-full object-cover shrink-0 mt-0.5">
    <div class="flex-1 min-w-0">
        <div class="flex items-baseline gap-1 flex-wrap">
            <span class="font-bold text-sm text-slate-900"><?= h($reply['display_name']) ?></span>
            <span class="text-slate-400 text-xs">@<?= h($reply['account_name']) ?></span>
            <span class="text-slate-400 text-xs">· <?= h($reply['created_at']) ?></span>
        </div>
        <p class="text-sm text-slate-800 mt-0.5 whitespace-pre-wrap"><?= h($reply['message']) ?></p>
    </div>
</div>