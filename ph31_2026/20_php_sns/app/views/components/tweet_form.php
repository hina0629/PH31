<?php

use App\Models\User;

if (!isset($auth_user)) return;
?>
<div class="px-4 py-4 border-b border-slate-100">
    <form id="tweet-form" action="home/add.php" method="post" enctype="multipart/form-data">
        <div class="flex gap-3">

            <!-- プロフィール画像 -->
            <a href="user/" class="shrink-0">
                <img id="preview-image" src="<?= User::profileImage($auth_user['profile_image']) ?>"
                    class="w-10 h-10 rounded-full object-cover">
            </a>

            <!-- 入力エリア -->
            <div class="flex-1 min-w-0">
                <textarea required name="message" rows="2"
                    class="w-full resize-none outline-none text-base placeholder-slate-400 text-slate-900 pt-1 bg-transparent"
                    placeholder="いまどうしてる？"></textarea>

                <!-- 画像プレビュー用コンテナ -->
                <div id="imagePreviewContainer" class="mt-2"></div>

                <!-- ツールバー -->
                <div class="flex items-center justify-between pt-3 mt-1 border-t border-sky-100">
                    <label for="fileInput" class="cursor-pointer p-2 rounded-full hover:bg-sky-50 transition">
                        <img src="svg/image.svg" class="w-5 h-5" alt="画像を追加">
                    </label>
                    <button type="submit"
                        class="bg-sky-500 hover:bg-sky-600 active:bg-sky-700 text-white font-bold py-1.5 px-5 rounded-full text-sm transition shadow-sm">
                        ポストする
                    </button>
                </div>

                <!-- ファル選択: file input -->
                <input type="file" name="file" id="fileInput" accept="image/*" class="hidden">
            </div>

        </div>
    </form>
</div>