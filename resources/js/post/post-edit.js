document.addEventListener('DOMContentLoaded', function () {
    const editForm = document.querySelector('.edit-post-form');

    if (editForm) {
        editForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const submitBtn = this.querySelector('button[type="submit"]');

            submitBtn.disabled = true;
            submitBtn.innerText = 'Պահպանվում է...';

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (response.ok) {
                    alert('Փոփոխությունները պահպանվեցին:');
                    window.location.href = '/home';
                } else {
                    const errors = await response.json();
                    console.log(errors);
                    alert('Սխալ տեղի ունեցավ թարմացնելիս:');
                }
            } catch (error) {
                console.error('Error:', error);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Update';
            }
        });
    }
});
