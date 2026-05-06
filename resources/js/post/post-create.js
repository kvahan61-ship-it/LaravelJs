document.addEventListener('DOMContentLoaded', function () {
    const feed = document.querySelector('.instagram-feed');

    if (feed) {
        feed.addEventListener('click', async function (e) {
            const likeBtn = e.target.closest('.like-btn');
            if (!likeBtn) return;

            e.preventDefault();
            const postId = likeBtn.dataset.id;
            const icon = likeBtn.querySelector('i');
            const countSpan = likeBtn.querySelector('.likes-count');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    if (data.status === 'liked') {
                        icon.classList.replace('fa-heart-o', 'fa-heart');
                        icon.style.color = 'red';
                    } else {
                        icon.classList.replace('fa-heart', 'fa-heart-o');
                        icon.style.color = 'black';
                    }
                    countSpan.innerText = data.likes_count;
                }
            } catch (error) {
                console.error('Error liking post:', error);
            }
        });
    }


    const imageInput = document.getElementById('images');

    if (imageInput) {
        imageInput.onchange = function (evt) {
            const files = this.files;
            if (files && files[0]) {
                let previewContainer = document.getElementById('image-preview-container');

                if(!previewContainer) {
                    previewContainer = document.createElement('div');
                    previewContainer.id = 'image-preview-container';
                    this.closest('.file-upload-wrapper').after(previewContainer);
                }

                previewContainer.style.display = 'block';
                previewContainer.style.marginTop = '15px';


                previewContainer.innerHTML = `
                    <img src="${URL.createObjectURL(files[0])}"
                         style="max-width: 150px; border-radius: 8px; border: 1px solid #ddd;" />
                `;
            }
        };
    }
});
