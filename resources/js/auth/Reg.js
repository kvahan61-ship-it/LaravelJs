document.getElementById('regForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const msgDiv = document.getElementById('message');

    fetch('/register', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
        .then(response => response.json())
        .then(res => {
            if (res.errors) {
                msgDiv.style.color = 'red';
                msgDiv.innerText = Object.values(res.errors).flat().join(' ');
            } else if (res.redirect) {
                window.location.href = res.redirect;
            } else {
                // Հաջողության հաղորդագրություն, եթե redirect-ը չկա
                msgDiv.style.color = 'green';
                msgDiv.innerText = res.message || 'Գրանցումը հաջողվեց:';
                this.reset();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            msgDiv.style.color = 'red';
            msgDiv.innerText = 'Ինչ-որ սխալ տեղի ունեցավ սերվերի հետ կապ հաստատելիս:';
        });
});
