<?php
if (!isset($auth_user)) return;
if (!isset($active_tab)) return;
$activeTab = $active_tab ?? 'public';
?>
<div id="tweet-list"
    data-auth-user-id="<?= (int) $auth_user['id'] ?>">
    <?php if (empty($tweets)) : ?>
        <p class="p-8 text-center text-slate-400 text-sm">
            <?= $activeTab === 'followers' ? 'フォロー中ユーザーの投稿はありません' : '投稿がありません' ?>
        </p>
    <?php else : ?>
        <?php foreach ($tweets as $tweet) : ?>
            <?php include COMPONENT_DIR . 'tweet_item.php' ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>