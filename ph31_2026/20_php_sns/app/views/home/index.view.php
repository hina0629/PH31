<div class="flex max-w-4xl mx-auto min-h-screen">

    <!-- サイドナビ -->
    <header class="sticky top-0 h-screen w-20 shrink-0 self-start border-r border-slate-100 xl:w-56">
        <!-- ホームタブ: app/views/components/home_tabs.php -->
        <?php include COMPONENT_DIR . 'nav.php' ?>
    </header>

    <!-- メインコンテンツ -->
    <main class="flex-1 border-r border-slate-100 min-h-screen">
        <!-- ホームタブ: app/views/components/home_tabs.php -->
        <?php include COMPONENT_DIR . 'home_tabs.php' ?>
        <!-- TODO: 検索フォーム読み込み: app/views/components/search_form.php -->
        <div class="border-b border-slate-100 p-4 text-sm text-slate-400">TODO: 検索フォーム読み込み: app/views/components/search_form.php</div>
        <!-- TODO: ツイート投稿フォーム読み込み: app/views/components/tweet_form.php -->
        <div class="border-b border-slate-100 p-4 text-sm text-slate-400">TODO: ツイート投稿フォーム読み込み: app/views/components/tweet_form.php</div>
        <!-- ホームツイートリスト: app/views/components/home_tweet_list.php -->
        <?php include COMPONENT_DIR . 'home_tweet_list.php' ?>
    </main>
</div>