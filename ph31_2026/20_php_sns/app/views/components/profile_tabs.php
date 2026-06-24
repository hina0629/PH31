<?php
$userId = (int) $user_data['id'];
$activeTab = $active_tab ?? 'posts';
?>
<div class="grid grid-cols-3 border-b border-slate-100">
    <a href="user/?id=<?= $userId ?>"
        class="px-4 py-3 text-center text-sm font-semibold transition <?= $activeTab === 'posts' ? 'border-b-2 border-sky-500 text-slate-900' : 'text-slate-500 hover:bg-slate-50' ?>">
        投稿
    </a>
    <a href="user/following.php?id=<?= $userId ?>"
        class="px-4 py-3 text-center text-sm font-semibold transition <?= $activeTab === 'following' ? 'border-b-2 border-sky-500 text-slate-900' : 'text-slate-500 hover:bg-slate-50' ?>">
        フォロー中
    </a>
    <a href="user/followers.php?id=<?= $userId ?>"
        class="px-4 py-3 text-center text-sm font-semibold transition <?= $activeTab === 'followers' ? 'border-b-2 border-sky-500 text-slate-900' : 'text-slate-500 hover:bg-slate-50' ?>">
        フォロワー
    </a>
</div>