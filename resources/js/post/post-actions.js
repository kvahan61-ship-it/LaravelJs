document.addEventListener('DOMContentLoaded', function () {
    const feed = document.querySelector('.instagram-feed');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (!feed) return;

    feed.addEventListener('click', async function (e) {
        const likeBtn = e.target.closest('.like-btn');
        if (likeBtn) {
            handleAction(likeBtn, `/posts/${likeBtn.dataset.id}/like`, 'fa-heart', 'fa-heart-o');
        }

        const saveBtn = e.target.closest('.save-btn');
        if (saveBtn) {
            handleAction(saveBtn, `/posts/${saveBtn.dataset.id}/save`, 'fa-bookmark', 'fa-bookmark-o');
        }
    });

    async function handleAction(btn, url, fullClass, emptyClass) {
        const icon = btn.querySelector('i');

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                }
            });

            const data = await response.json();

            if (response.ok) {
                if (data.status === 'added' || data.status === 'liked') {
                    icon.classList.replace(emptyClass, fullClass);
                    if(fullClass === 'fa-heart') icon.style.color = '#e00';
                } else {
                    icon.classList.replace(fullClass, emptyClass);
                    if(fullClass === 'fa-heart') icon.style.color = '';
                }
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
});
