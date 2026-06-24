<?php if (empty($value)) return; ?>

<div id="reply-section-<?= $value['id'] ?>" class="hidden mt-2 pl-2 border-l-2 border-slate-100">
    <div id="reply-list-<?= $value['id'] ?>" class="ml-2"></div>

    <div class="flex gap-2 mt-2">
        <textarea
            id="reply-input-<?= $value['id'] ?>"
            class="flex-1 text-sm border border-slate-200 rounded-lg px-3 py-2 resize-none focus:outline-none focus:border-sky-400"
            rows="2"
            placeholder="返信を入力..."></textarea>
        <button
            onclick="submitReply(<?= $value['id'] ?>)"
            class="px-4 py-2 bg-sky-500 text-white text-sm font-bold rounded-full hover:bg-sky-400 transition self-end">
            返信
        </button>
    </div>
</div>