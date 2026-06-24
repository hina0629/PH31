<div class="flex max-w-4xl mx-auto min-h-screen">

    <!-- サイドナビ -->
    <header class="sticky top-0 h-screen w-20 shrink-0 self-start border-r border-slate-100 xl:w-56">
        <?php include COMPONENT_DIR . 'nav.php' ?>
    </header>

    <!-- メインコンテンツ -->
    <main class="flex-1 border-r border-slate-100 min-h-screen">
        <?php include COMPONENT_DIR . 'search_form.php' ?>

        <?php include COMPONENT_DIR . 'tweet_form.php' ?>

        <div id="search-result"
            data-auth-user-id="<?= (int) $auth_user['id'] ?>"
            data-ssr-rendered="true">
            <?php if (empty($keyword)) : ?>
                <p class="p-8 text-center text-slate-400 text-sm">キーワードを入力してください</p>
            <?php else : ?>
                <div class="px-4 py-3 border-b border-slate-100">
                    <p class="text-sm text-slate-500">「<span class="font-bold text-slate-800"><?= h($keyword ?? '') ?></span>」の検索結果</p>
                    <p class="text-xs text-slate-400 mt-0.5"><?= !empty($tweets) ? count($tweets) : 0 ?> 件</p>
                </div>

                <?php if (empty($tweets)) : ?>
                    <p class="p-8 text-center text-slate-400 text-sm">投稿が見つかりませんでした</p>
                <?php else : ?>
                    <?php foreach ($tweets as $tweet) : ?>
                        <?php include COMPONENT_DIR . 'tweet_item.php' ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>

</div>