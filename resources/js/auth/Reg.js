document.getElementById('regForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const msgDiv = document.getElementById('message');

    const codeInput = document.getElementById('verification_code_input');

    if (!codeInput) {
        fetch('/register/send-code', {
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
                } else if (res.status === 'code_sent') {
                    msgDiv.style.color = 'green';
                    msgDiv.innerText = res.message;

                    appendVerificationInput();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                msgDiv.style.color = 'red';
                msgDiv.innerText = 'Ինչ-որ սխալ տեղի ունեցավ սերվերի հետ կապ հաստատելիս:';
            });

    } else {
        const codeValue = document.getElementById('verification_code').value;
        const verificationData = new FormData();
        verificationData.append('code', codeValue);

        const csrfToken = document.querySelector('input[name="_token"]').value;
        verificationData.append('_token', csrfToken);

        fetch('/register/verify', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: verificationData
        })
            .then(response => response.json())
            .then(res => {
                if (res.errors) {
                    msgDiv.style.color = 'red';
                    msgDiv.innerText = Object.values(res.errors).flat().join(' ');
                } else if (res.redirect) {
                    window.location.href = res.redirect;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                msgDiv.style.color = 'red';
                msgDiv.innerText = 'Կոդի ստուգման ժամանակ սխալ տեղի ունեցավ:';
            });
    }
});

function appendVerificationInput() {
    const form = document.getElementById('regForm');

    if (document.getElementById('verification_code_input')) return;

    const div = document.createElement('div');
    div.id = 'verification_code_input';
    div.style.marginBottom = '20px';
    div.innerHTML = `
        <label style="font-size: 14px; font-weight: 600; color: #007bff; display: block; margin-bottom: 5px;">
            Մուտքագրեք Gmail-ին ուղարկված 6 նիշանոց կոդը
        </label>
        <input type="text" id="verification_code" name="code" placeholder="******" maxlength="6" style="width: 100%; padding: 10px; border: 2px solid #007bff; border-radius: 8px; outline: none; font-size: 16px; text-align: center; letter-spacing: 5px; font-weight: bold;" required>
    `;

    const submitBtn = form.querySelector('button[type="submit"]');
    form.insertBefore(div, submitBtn);

    submitBtn.innerText = '🛡️ Հաստատել և Գրանցվել';
    submitBtn.style.background = '#28a745';
}
