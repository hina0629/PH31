<div class="sticky top-0 z-10 bg-white/90 backdrop-blur-sm px-4 py-3 border-b border-slate-100">
    <form action="home/search.php" method="get">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" name="keyword"
                value="<?= isset($keyword) ? $keyword : '' ?>"
                placeholder="キーワードで検索"
                class="w-full bg-slate-100 rounded-full pl-9 pr-4 py-2 text-sm text-slate-800 placeholder-slate-400
                       focus:outline-none focus:bg-white focus:ring-2 focus:ring-sky-300 transition">
        </div>
    </form>
</div>