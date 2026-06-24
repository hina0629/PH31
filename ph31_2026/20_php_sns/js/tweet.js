let activeReplyTweetId = null;

function escapeHtml(str) {
    return String(str ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function heartSvg(filled) {
    return filled
        ? `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
               <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.218l-.022.012-.007.003-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
           </svg>`
        : `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
               <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
           </svg>`;
}

function initTweetMessages(container) {
    container.querySelectorAll('.tweet-message').forEach((el) => {
        el.addEventListener('click', (e) => {
            if (e.target.tagName.toLowerCase() !== 'a') {
                window.location.href = `home/detail.php?id=${el.dataset.id}`;
            }
        });
    });
}

function initLikeButtons(container) {
    container.querySelectorAll('.like-btn').forEach((btn) => {
        btn.addEventListener('click', async () => {
            const tweetId = Number(btn.dataset.tweetId);
            try {
                const res = await fetch(apiUrl('api/like/update.php'), {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ tweet_id: tweetId }),
                });
                if (!res.ok) throw new Error(`HTTP ${res.status}`);

                const { like_count, liked } = await res.json();
                btn.dataset.liked = String(liked);
                btn.innerHTML = heartSvg(liked) + `<span class="like-count text-xs">${like_count}</span>`;

                if (liked) {
                    btn.classList.remove('text-slate-400');
                    btn.classList.add('text-rose-500');
                } else {
                    btn.classList.remove('text-rose-500');
                    btn.classList.add('text-slate-400');
                }
            } catch (e) {
                console.error('like error:', e);
            }
        });
    });
}

function createReplyHtml(reply) {
    const profileImg = reply.profile_image_url
        ? escapeHtml(reply.profile_image_url)
        : 'images/avater.png';

    return `
        <div class="flex gap-2 py-3 border-b border-slate-50 last:border-0">
            <img src="${profileImg}" class="w-8 h-8 rounded-full object-cover shrink-0 mt-0.5">
            <div class="flex-1 min-w-0">
                <div class="flex items-baseline gap-1 flex-wrap">
                    <span class="font-bold text-sm text-slate-900">${escapeHtml(reply.display_name)}</span>
                    <span class="text-slate-400 text-xs">@${escapeHtml(reply.account_name)}</span>
                    <span class="text-slate-400 text-xs">· ${escapeHtml(reply.created_at)}</span>
                </div>
                <p class="text-sm text-slate-800 mt-0.5 whitespace-pre-wrap">${escapeHtml(reply.message)}</p>
            </div>
        </div>`;
}

function updateReplyCount(tweetId, count) {
    document.querySelectorAll(`.reply-count[data-tweet-id="${tweetId}"]`).forEach((el) => {
        el.textContent = String(count);
    });
}

function closeReplyModal() {
    const modal = document.getElementById('reply-modal');
    const textarea = document.getElementById('reply-modal-textarea');
    const error = document.getElementById('reply-modal-error');

    if (!modal || !textarea || !error) return;

    activeReplyTweetId = null;
    modal.classList.add('hidden');
    modal.setAttribute('aria-hidden', 'true');
    textarea.value = '';
    error.textContent = '';
    error.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

function openReplyModal(btn) {
    const card = btn.closest('.tweet-card');
    const modal = document.getElementById('reply-modal');
    const textarea = document.getElementById('reply-modal-textarea');
    const avatar = document.getElementById('reply-target-avatar');
    const displayName = document.getElementById('reply-target-display-name');
    const accountName = document.getElementById('reply-target-account-name');
    const createdAt = document.getElementById('reply-target-created-at');
    const message = document.getElementById('reply-target-message');
    const image = document.getElementById('reply-target-image');

    if (!card || !modal || !textarea || !avatar || !displayName || !accountName || !createdAt || !message || !image) {
        return;
    }

    activeReplyTweetId = Number(btn.dataset.tweetId);
    avatar.src = card.dataset.profileImageUrl || 'images/avater.png';
    displayName.textContent = card.dataset.displayName || '';
    accountName.textContent = `@${card.dataset.accountName || ''}`;
    createdAt.textContent = card.dataset.createdAt || '';
    message.textContent = card.dataset.message || '';

    if (card.dataset.imagePath) {
        image.src = card.dataset.imagePath;
        image.classList.remove('hidden');
    } else {
        image.src = '';
        image.classList.add('hidden');
    }

    modal.classList.remove('hidden');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('overflow-hidden');
    textarea.focus();
}

async function submitReplyFromModal() {
    const textarea = document.getElementById('reply-modal-textarea');
    const submitBtn = document.getElementById('reply-modal-submit');
    const error = document.getElementById('reply-modal-error');
    const replyList = document.getElementById('reply-list');

    if (!textarea || !submitBtn || !error || !activeReplyTweetId) return;

    const message = textarea.value.trim();
    if (!message) {
        error.textContent = '返信を入力してください';
        error.classList.remove('hidden');
        return;
    }

    submitBtn.disabled = true;
    error.textContent = '';
    error.classList.add('hidden');

    try {
        const res = await fetch(apiUrl('api/reply/add.php'), {
            method: 'POST',
            credentials: 'include',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ tweet_id: activeReplyTweetId, message }),
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);

        const reply = await res.json();
        updateReplyCount(activeReplyTweetId, Number(reply.reply_count ?? 0));

        if (replyList && Number(replyList.dataset.tweetId) === activeReplyTweetId) {
            const empty = replyList.querySelector('p');
            if (empty) empty.remove();
            replyList.insertAdjacentHTML('beforeend', createReplyHtml(reply));
        }

        closeReplyModal();
    } catch (e) {
        console.error('reply error:', e);
        error.textContent = '返信に失敗しました';
        error.classList.remove('hidden');
    } finally {
        submitBtn.disabled = false;
    }
}

function initReplyModal() {
    const modal = document.getElementById('reply-modal');
    const backdrop = document.getElementById('reply-modal-backdrop');
    const closeBtn = document.getElementById('reply-modal-close');
    const cancelBtn = document.getElementById('reply-modal-cancel');
    const submitBtn = document.getElementById('reply-modal-submit');
    const textarea = document.getElementById('reply-modal-textarea');

    if (!modal || !backdrop || !closeBtn || !cancelBtn || !submitBtn || !textarea) return;

    backdrop.addEventListener('click', closeReplyModal);
    closeBtn.addEventListener('click', closeReplyModal);
    cancelBtn.addEventListener('click', closeReplyModal);
    submitBtn.addEventListener('click', submitReplyFromModal);
    textarea.addEventListener('keydown', (e) => {
        if ((e.metaKey || e.ctrlKey) && e.key === 'Enter') {
            submitReplyFromModal();
        }
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeReplyModal();
        }
    });
}

function initReplyForms(container) {
    container.querySelectorAll('.reply-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
            openReplyModal(btn);
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initTweetMessages(document);
    initLikeButtons(document);
    initReplyModal();
    initReplyForms(document);
});
