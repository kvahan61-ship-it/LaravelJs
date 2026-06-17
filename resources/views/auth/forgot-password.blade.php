@extends('layouts.main')

@section('content')
    <div style="max-width: 400px; margin: 80px auto; padding: 30px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; margin-bottom: 20px; color: #1e293b; font-family: sans-serif;">🔒 Գաղտնաբառի վերականգնում</h2>

        <div id="message" style="margin-bottom: 15px; font-weight: bold; font-family: sans-serif; font-size: 14px; text-align: center;"></div>

        <form id="forgotForm" action="javascript:void(0);" method="POST">
            @csrf
            <div id="email_section">
                <label style="font-family: sans-serif; font-size: 14px; color: #475569;">Մուտքագրեք Ձեր Email-ը</label>
                <input type="email" id="email" name="email" style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 6px; border: 1px solid #cbd5e1; outline: none;" required>
            </div>

            <button type="submit" id="submitBtn" style="width: 100%; padding: 11px; background: #007bff; color: #fff; border: none; border-radius: 6px; margin-top: 20px; cursor: pointer; font-weight: bold; font-size: 15px; transition: 0.2s;">
                📩 Ուղարկել կոդը
            </button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('forgotForm');

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const msgDiv = document.getElementById('message');
                    const submitBtn = document.getElementById('submitBtn');
                    const formData = new FormData(this);

                    const isVerificationStep = document.getElementById('verification_section');

                    if (!isVerificationStep) {
                        msgDiv.style.color = '#3182ce';
                        msgDiv.innerText = 'Կոդը ուղարկվում է...';
                        submitBtn.disabled = true;

                        fetch('/forgot-password/send-code', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                            .then(response => response.json())
                            .then(res => {
                                submitBtn.disabled = false;
                                if (res.errors) {
                                    msgDiv.style.color = 'red';
                                    msgDiv.innerText = Object.values(res.errors).flat().join(' ');
                                } else if (res.status === 'code_sent') {
                                    msgDiv.style.color = 'green';
                                    msgDiv.innerText = 'Կոդը հաջողությամբ ուղարկվեց Ձեր Gmail-ին:';

                                    document.getElementById('email_section').style.display = 'none';
                                    appendResetFields();
                                }
                            })
                            .catch(err => {
                                submitBtn.disabled = false;
                                console.error(err);
                            });
                    } else {
                        fetch('/forgot-password/reset', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                            .then(response => response.json())
                            .then(res => {
                                if (res.errors) {
                                    msgDiv.style.color = 'red';
                                    msgDiv.innerText = Object.values(res.errors).flat().join(' ');
                                } else if (res.redirect) {
                                    alert('Գաղտնաբառը հաջողությամբ փոխվեց։');
                                    window.location.href = res.redirect;
                                }
                            })
                            .catch(err => console.error(err));
                    }
                });
            }
        });

        function appendResetFields() {
            const form = document.getElementById('forgotForm');
            const submitBtn = document.getElementById('submitBtn');

            if (document.getElementById('verification_section')) return;

            const div = document.createElement('div');
            div.id = 'verification_section';
            div.innerHTML = `
        <div style="margin-top: 15px; font-family: sans-serif;">
            <label style="color: #007bff; font-weight: bold; font-size: 14px;">Մուտքագրեք 6 նիշանոց կոդը</label>
            <input type="text" name="code" maxlength="6" style="width: 100%; padding: 10px; margin-top: 5px; text-align: center; font-weight: bold; border: 2px solid #007bff; border-radius: 6px; font-size: 18px; letter-spacing: 2px;" required>
        </div>
        <div style="margin-top: 15px; font-family: sans-serif;">
            <label style="font-size: 14px; color: #475569;">Նոր Գաղտնաբառ</label>
            <input type="password" name="password" style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 6px; border: 1px solid #cbd5e1;" required>
        </div>
        <div style="margin-top: 15px; font-family: sans-serif;">
            <label style="font-size: 14px; color: #475569;">Կրկնել Նոր Գաղտնաբառը</label>
            <input type="password" name="password_confirmation" style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 6px; border: 1px solid #cbd5e1;" required>
        </div>
    `;

            form.insertBefore(div, submitBtn);
            submitBtn.innerText = '🔄 Փոխել Գաղտնաբառը';
            submitBtn.style.background = '#28a745';
        }
    </script>
@endsection
