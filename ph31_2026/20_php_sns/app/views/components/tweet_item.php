<?php
if (!isset($tweet)) return;
if (!isset($auth_user)) return;
?>
<div class="tweet-card px-4 py-4 border-b border-slate-100 hover:bg-slate-50 transition">
    <div class="flex gap-3">
        <a href="user/?id=<?= (int) $tweet['user_id'] ?>" class="shrink-0">
            <img src="<?= h($tweet['profile_image_url']) ?>" class="rounded-full w-10 h-10 object-cover">
        </a>
        <div class="flex-1 min-w-0">
            <div class="flex items-baseline gap-1 flex-wrap">
                <a href="user/?id=<?= (int) $tweet['user_id'] ?>" class="font-bold text-slate-900 hover:underline">
                    TODO: 表示名(display_name)
                </a>
                <span class="text-slate-400 text-sm">@<?= h($tweet['account_name']) ?></span>
                <span class="text-slate-400 text-sm">·</span>
                <span class="text-slate-400 text-sm">
                    TODO: 投稿日時(created_at)を「YYYY年MM月DD日」形式
                </span>
            </div>
            <div class="tweet-message mt-1 text-slate-800 text-sm leading-relaxed" data-id="<?= (int) $tweet['id'] ?>">
                TODO: メッセージリンク: home/detail.php?id= でGETパラメータ
                TODO: メッセージ(message)を改行つきで表示
            </div>

            <?php if (!empty($tweet['image_path'])) : ?>
                <div class="mt-2">
                    <!-- TODO: src に 画像(image_path)を表示 -->
                    <img src="" class="rounded-xl max-w-sm max-h-80 object-cover border border-slate-100" alt="">
                </div>
            <?php endif; ?>

            <div class="flex items-center gap-5 mt-3">
                <button type="button"
                    class="reply-btn inline-flex items-center gap-1.5 text-slate-400 hover:text-sky-500 transition"
                    data-tweet-id="<?= (int) $tweet['id'] ?>">
                    <img src="svg/bubble.svg" class="w-4 h-4" alt="コメント">
                    <span class="reply-count text-xs" data-tweet-id="<?= (int) $tweet['id'] ?>"><?= (int) $tweet['reply_count'] ?></span>
                </button>

                <?php $liked = !empty($tweet['liked']); ?>
                <button type="button"
                    class="like-btn inline-flex items-center gap-1.5 <?= $liked ? 'text-rose-500' : 'text-slate-400' ?> hover:text-rose-500 transition"
                    data-tweet-id="<?= (int) $tweet['id'] ?>"
                    data-liked="<?= $liked ? 'true' : 'false' ?>">
                    <?php if ($liked) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.218l-.022.012-.007.003-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                        </svg>
                    <?php else : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                    <?php endif; ?>
                    <span class="like-count text-xs"><?= (int) $tweet['like_count'] ?></span>
                </button>

                <div class="inline-flex items-center gap-1.5 text-slate-400 hover:text-emerald-500 transition cursor-pointer">
                    <img src="svg/loop.svg" class="w-4 h-4" alt="リポスト">
                    <span class="text-xs">0</span>
                </div>

                <?php if ((int) $auth_user['id'] === (int) $tweet['user_id']) : ?>
                    <form action="home/delete.php" method="post" class="ml-auto">
                        <div onclick="deleteTweet(this)" class="inline-flex items-center gap-1.5 text-slate-400 hover:text-red-500 transition cursor-pointer">
                            <img src="svg/trash.svg" class="w-4 h-4" alt="削除">
                        </div>
                        <input type="hidden" name="tweet_id" value="<?= (int) $tweet['id'] ?>">
                        <input type="hidden" name="user_id" value="<?= (int) $auth_user['id'] ?>">
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>