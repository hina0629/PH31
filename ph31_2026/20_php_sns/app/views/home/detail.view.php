<?php if (empty($tweet) || !is_array($tweet)) return; ?>

<div class="flex max-w-4xl mx-auto min-h-screen">

    <!-- サイドナビ -->
    <header class="sticky top-0 h-screen w-20 shrink-0 self-start border-r border-slate-100 xl:w-56">
        <?php include COMPONENT_DIR . 'nav.php' ?>
    </header>

    <!-- メインコンテンツ -->
    <main class="flex-1 border-r border-slate-100 min-h-screen">
        <div class="p-5 border-b border-slate-100">
            <a href="home/" class="font-bold">&larr; <span class="ml-4">ポスト</span></a>
        </div>

        <div id="tweet-detail" data-tweet-id="<?= (int) $tweet['id'] ?>" data-auth-user-id="<?= (int) $auth_user['id'] ?>">
            <?php include COMPONENT_DIR . 'tweet_item.php' ?>
        </div>

        <div id="reply-list" data-tweet-id="<?= (int) $tweet['id'] ?>" class="mx-4 border-t border-slate-100">
            <?php if (empty($replies)) : ?>
                <p class="p-6 text-center text-slate-400 text-sm">返信がありません</p>
            <?php else : ?>
                <?php foreach ($replies as $reply) : ?>
                    <?php include COMPONENT_DIR . 'reply_item.php' ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

</div>