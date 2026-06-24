<?php

use App\Models\User;

if (empty($auth_user)) exit('Not found auth user.');

$form = $form ?? [];
$displayName = $form['display_name'] ?? $auth_user['display_name'];
$profile = $form['profile'] ?? ($auth_user['profile'] ?? '');
?>

<div class="flex max-w-4xl mx-auto min-h-screen">

    <!-- サイドナビ -->
    <header class="sticky top-0 h-screen w-20 shrink-0 self-start border-r border-slate-100 xl:w-56">
        <?php include COMPONENT_DIR . 'nav.php' ?>
    </header>

    <!-- メインコンテンツ -->
    <main class="flex-1 border-r border-slate-100 min-h-screen">
        <div class="p-5 border-b border-slate-100">
            <a href="user/?id=<?= $auth_user['id'] ?>" class="font-bold">&larr; <span class="ml-4">もどる</span></a>
        </div>
        <div class="w-full mt-3 p-5">
            <h2 class="text-2xl mb-3 font-bold text-center">プロフィールを編集</h2>

            <!-- ユーザ画像アップロード -->
            <div class="flex justify-center items-center">
                <div class="bg-white p-8 rounded-lg">
                    <form action="user/upload_profile_image.php" method="post" enctype="multipart/form-data" class="flex flex-col items-center">
                        <!-- CSRF対策 -->
                        <input type="hidden" name="csrf_token" value="<?= Lib\Csrf::token() ?>">
                        <label for="image-input" class="cursor-pointer">
                            <img id="preview-image" src="<?= User::profileImage($auth_user['profile_image']) ?>" alt="Profile Picture" class="w-32 h-32 object-cover rounded-full mb-4">
                        </label>
                        <!-- <input type="file" id="image-input" name="file" class="mb-3 block w-full text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-sky-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-sky-600 hover:file:bg-sky-100" accept="image/*" required> -->
                        <button id="upload-button"
                            class="w-full text-sm my-2 py-1 px-3 bg-sky-500 hover:bg-sky-700 text-white rounded-lg">
                            アップロード
                        </button>
                    </form>
                </div>
            </div>

            <!-- ユーザ編集フォーム -->
            <?php include COMPONENT_DIR . 'error_message.php' ?>
            <?php if (!empty($success)) : ?>
                <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    <?= h($success) ?>
                </div>
            <?php endif; ?>

            <form action="user/update.php" method="post">
                <input type="hidden" name="csrf_token" value="<?= Lib\Csrf::token() ?>">
                <div class="relative mb-4">
                    <input type="text" name="account_name"
                        id="account_name"
                        class="block px-2.5 pb-2.5 pt-6 mb-3 w-full rounded-lg text-sm text-gray-900 ring-1 ring-gray-300"
                        value="<?= $auth_user['account_name'] ?>"
                        placeholder=" " disabled>
                    <label for="email" class="absolute text-sm text-gray-400 transform -translate-y-4 scale-75 top-4 origin-[0] start-2.5">アカウント名</label>
                </div>
                <div class="relative mb-4">
                    <input type="text" name="account_name"
                        id="email"
                        class="block px-2.5 pb-2.5 pt-6 mb-3 w-full rounded-lg text-sm text-gray-900 ring-1 ring-gray-300"
                        value="<?= $auth_user['email'] ?>"
                        placeholder=" " disabled>
                    <label for="email" class="absolute text-sm text-gray-400 transform -translate-y-4 scale-75 top-4 origin-[0] start-2.5">Email</label>
                </div>

                <div class="relative mb-4">
                    <input type="text" name="display_name"
                        id="display_name"
                        class="block px-2.5 pb-2.5 pt-6 mb-3 w-full rounded-lg text-sm
                                    text-gray-900 ring-1 ring-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-600 peer" value="<?= h($displayName) ?>" placeholder=" " required>
                    <label for="name" class="absolute
                        text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 origin-[0] start-2.5
                        peer-focus:px-0
                        peer-focus:text-blue-600
                        peer-focus:dark:text-blue-500
                        peer-placeholder-shown:scale-100
                        peer-placeholder-shown:translate-y-0
                        peer-focus:scale-75
                        peer-focus:-translate-y-4">
                        ディスプレイ名
                    </label>
                </div>


                <div class="relative mb-4">
                    <textarea id="profile" name="profile"
                        class="block px-2.5 pb-2.5 pt-6 mb-3 w-full rounded-lg text-sm text-gray-900 ring-1 ring-gray-300
                                    focus:outline-none focus:ring-1 focus:ring-blue-600 peer"
                        placeholder=" "><?= h($profile) ?></textarea>
                    <label for="profile"
                        class="absolute text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 origin-[0] start-2.5
                                    peer-focus:px-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">
                        自己紹介
                    </label>
                </div>

                <div>
                    <button class="w-full mb-2 py-2 px-4 bg-sky-500 hover:bg-sky-700 text-white rounded-lg">
                        保存
                    </button>
                </div>
            </form>
        </div>
    </main>

</div>
