document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('.login-form');

    if (loginForm) {
        loginForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const errorBox = document.getElementById('login-errors');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            submitBtn.disabled = true;
            submitBtn.innerText = 'Մուտք...';
            if (errorBox) errorBox.innerText = '';

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    window.location.href = result.redirect;
                } else {
                    let errorMsg = result.errors.auth || 'Տեղի է ունեցել սխալ:';
                    if (errorBox) {
                        errorBox.innerText = errorMsg;
                        errorBox.style.color = 'red';
                    } else {
                        alert(errorMsg);
                    }
                }
            } catch (error) {
                console.error('Error:', error);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Մուտք գործել';
            }
        });
    }
});
const tokenElement = document.querySelector('meta[name="csrf-token"]');
const csrfToken = tokenElement ? tokenElement.getAttribute('content') : '';

if (!csrfToken) {
    console.error('CSRF token NOT found! Համոզվեք, որ meta tag-ը ավելացված է layout-ում:');
}
