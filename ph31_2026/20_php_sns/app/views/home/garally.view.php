<div class="flex max-w-4xl mx-auto min-h-screen">

    <!-- サイドナビ -->
    <header class="sticky top-0 h-screen w-20 shrink-0 self-start border-r border-slate-100 xl:w-56">
        <?php include COMPONENT_DIR . 'nav.php' ?>
    </header>

    <!-- メインコンテンツ -->
    <main class="flex-1 border-r border-slate-100 min-h-screen">
        <div class="px-6 py-5 border-b border-slate-100">
            <h1 class="text-2xl font-bold text-slate-900">メディア</h1>
            <p class="text-sm text-slate-500 mt-1">画像付きの投稿を新しい順に表示します。</p>
        </div>

        <div id="media-gallery" class="p-4" data-ssr-rendered="true">
            <?php if (empty($tweets)) : ?>
                <p class="p-8 text-center text-slate-400 text-sm">画像付きの投稿はまだありません。</p>
            <?php else : ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    <?php foreach ($tweets as $tweet) : ?>
                        <a href="home/detail.php?id=<?= (int) $tweet['id'] ?>" class="block overflow-hidden rounded-xl bg-white border border-slate-100 hover:shadow-md transition">
                            <!-- TODO: srcに画像(image_path) -->
                            <img src="" alt="" class="w-full h-48 object-cover hover:scale-105 transition-transform duration-200">
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

</div>