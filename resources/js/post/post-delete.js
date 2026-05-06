document.addEventListener('DOMContentLoaded', function () {
    const deleteBtn = document.querySelector('.delete-post-btn');

    if (deleteBtn) {
        deleteBtn.addEventListener('click', async function () {
            if (!confirm('Վստա՞հ եք, որ ուզում եք ջնջել այս պոստը:')) {
                return;
            }

            const url = this.dataset.url;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            this.disabled = true;
            this.innerText = 'Ջնջվում է...';

            try {
                const response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    alert('Պոստը հաջողությամբ ջնջվեց:');
                    window.location.href = '/posts';
                } else {
                    alert('Սխալ տեղի ունեցավ ջնջելիս:');
                    this.disabled = false;
                    this.innerText = 'Delete';
                }
            } catch (error) {
                console.error('Error:', error);
                this.disabled = false;
                this.innerText = 'Delete';
            }
        });
    }
});
