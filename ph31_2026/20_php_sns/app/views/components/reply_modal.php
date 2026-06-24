<?php

use App\Models\User;
?>
<div id="reply-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
    <div id="reply-modal-backdrop" class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>
    <div class="relative flex min-h-full items-center justify-center p-4">
        <div class="w-full max-w-xl overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <h2 class="text-base font-bold text-slate-900">返信する</h2>
                <button id="reply-modal-close" type="button" class="rounded-full p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition" aria-label="閉じる">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-5 py-4">
                <div id="reply-target-card" class="rounded-2xl border border-slate-100 bg-slate-50 px-4 py-4">
                    <div class="flex gap-3">
                        <img id="reply-target-avatar" src="" alt="" class="h-10 w-10 rounded-full object-cover shrink-0">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-baseline gap-1">
                                <span id="reply-target-display-name" class="font-bold text-slate-900"></span>
                                <span id="reply-target-account-name" class="text-sm text-slate-400"></span>
                                <span class="text-sm text-slate-400">·</span>
                                <span id="reply-target-created-at" class="text-sm text-slate-400"></span>
                            </div>
                            <p id="reply-target-message" class="mt-1 whitespace-pre-wrap break-words text-sm leading-relaxed text-slate-800"></p>
                            <img id="reply-target-image" src="" alt="" class="mt-3 hidden max-h-80 rounded-xl border border-slate-100 object-cover">
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex gap-3">
                    <img src="<?= h(User::profileImage($auth_user['profile_image'] ?? null)) ?>" alt="" class="h-10 w-10 rounded-full object-cover shrink-0">
                    <div class="min-w-0 flex-1">
                        <textarea id="reply-modal-textarea" rows="4" class="w-full resize-none rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-400" placeholder="返信を入力..."></textarea>
                        <p id="reply-modal-error" class="mt-2 hidden text-sm text-red-500"></p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-slate-100 px-5 py-4">
                <button id="reply-modal-cancel" type="button" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    キャンセル
                </button>
                <button id="reply-modal-submit" type="button" class="rounded-full bg-sky-500 px-5 py-2 text-sm font-semibold text-white hover:bg-sky-600 transition">
                    返信
                </button>
            </div>
        </div>
    </div>
</div>
