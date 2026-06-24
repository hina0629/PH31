<?php
if (empty($user_data)) return;

use App\Models\User;
?>

<div class="px-6">
    <div class="py-6 flex justify-center cursor-pointer">
        <img id="preview-image" src="<?= User::profileImage($user_data['profile_image']) ?>" class="w-32 h-32 object-cover rounded-full mb-4">
    </div>
    <div class="text-center">
        <?php if (isset($auth_user) && $auth_user['id'] == $user_data['id']): ?>
            <a href="user/edit.php" class="border border-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">プロフィールを編集</a>
        <?php elseif ($is_following ?? false): ?>
            <form action="user/unfollow.php" method="post">
                <input type="hidden" name="followee_id" value="<?= $user_data['id'] ?>">
                <button type="submit" class="font-bold py-2 px-5 rounded-full border border-slate-300 text-slate-900 hover:bg-red-50 hover:text-red-500 hover:border-red-300 transition">
                    フォロー解除
                </button>
            </form>
        <?php else: ?>
            <form action="user/follow.php" method="post">
                <input type="hidden" name="followee_id" value="<?= $user_data['id'] ?>">
                <button type="submit" class="font-bold py-2 px-5 rounded-full bg-slate-900 text-white hover:bg-slate-700 transition">
                    フォロー
                </button>
            </form>
        <?php endif ?>
    </div>

    <div>
        <h2 class="text-2xl font-bold py-2"><?= $user_data['display_name'] ?></h2>
        <div class="text-gray-600 mb-2">
            <span>@<?= $user_data['account_name'] ?></span>
        </div>
        <div class="text-gray-600 text-sm mb-4">
            <?= nl2br($user_data['profile'] ?? "") ?>
        </div>
        <div class="text-gray-600 text-sm mb-4">
            <?= date('Y.m.d', strtotime($user_data['created_at'])) ?> から利用しています
        </div>
    </div>

    <div>
        <div class="flex justify-start gap-4 text-sm">
            <div class="text-center">
                <span class="font-bold text-lg"><?= $tweet_count ?? 0 ?></span>
                <span class="text-gray-600 text-sm">ツイート</span>
            </div>
            <a href="user/following.php?id=<?= (int) $user_data['id'] ?>" class="text-center hover:opacity-70 transition">
                <span class="font-bold text-lg"><?= $follow_count ?? 0 ?></span>
                <span class="text-gray-600 text-sm">フォロー中</span>
            </a>
            <a href="user/followers.php?id=<?= (int) $user_data['id'] ?>" class="text-center hover:opacity-70 transition">
                <span id="follower-count" class="font-bold text-lg"><?= $follower_count ?? 0 ?></span>
                <span class="text-gray-600 text-sm">フォロワー</span>
            </a>
        </div>
    </div>
</div>