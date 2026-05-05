document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const msgDiv = document.getElementById('loginMessage');

    fetch('/login', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
        .then(response => response.json())
        .then(res => {
            if (res.redirect) {
                window.location.href = res.redirect;
            } else if (res.errors) {
                msgDiv.style.color = 'red';
                msgDiv.innerText = Object.values(res.errors).flat()[0];
            }
        })
        .catch(error => {
            console.error('Error:', error);
            msgDiv.style.color = 'red';
            msgDiv.innerText = 'Կապի սխալ: Փորձեք մի փոքր ուշ:';
        });
});
