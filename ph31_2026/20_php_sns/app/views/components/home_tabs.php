<?php $activeTab = $active_tab ?? 'public'; ?>
<div class="grid grid-cols-2 border-b border-slate-100 sticky top-0 bg-white/95 backdrop-blur z-10">
    <a href="home/?tab=public"
        class="px-4 py-3 text-center text-sm font-semibold transition <?= $activeTab === 'public' ? 'border-b-2 border-sky-500 text-slate-900' : 'text-slate-500 hover:bg-slate-50' ?>">
        パブリック
    </a>
    <a href="home/?tab=followers"
        class="px-4 py-3 text-center text-sm font-semibold transition <?= $activeTab === 'followers' ? 'border-b-2 border-sky-500 text-slate-900' : 'text-slate-500 hover:bg-slate-50' ?>">
        フォロワー
    </a>
</div>