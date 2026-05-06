// resources/js/post/post-create.js

document.addEventListener('click', async function (e) {
    const button = e.target.closest('.add-to-cart-btn-primary');

    if (button) {
        e.preventDefault();

        const postId = button.dataset.id;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        console.log("Հարցումը գնաց POST-ով, ID:", postId);

        try {
            const response = await fetch(`/cart/add/${postId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                const badge = document.getElementById('cart-badge');
                if (badge) badge.innerText = data.cart_count;

                button.style.background = '#1e7e34';
                button.innerHTML = '<i class="fa fa-check"></i> Ավելացվեց';

                setTimeout(() => {
                    button.style.background = '#28a745';
                    button.innerHTML = '<i class="fa fa-shopping-cart"></i> Ավելացնել զամբյուղ';
                }, 2000);
            } else {
                console.error("Server Error:", data);
                alert('Սխալ: ' + (data.message || 'Անհայտ սխալ'));
            }
        } catch (error) {
            console.error('Fetch Error:', error);
            alert('Կապի սխալ: ' + error.message);
        }
    }
});
document.addEventListener('click', async function(e) {
    const btn = e.target.closest('.update-qty');
    if (!btn) return;

    const row = btn.closest('.cart-item-row');
    const itemId = row.dataset.id;
    const action = btn.dataset.action;
    const qtyElement = row.querySelector('.quantity-value');
    const rowTotalElement = row.querySelector('.row-total-price');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    try {
        const response = await fetch(`/cart/update/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ action: action })
        });

        const data = await response.json();

        if (data.status === 'success') {
            qtyElement.innerText = data.new_quantity;

            rowTotalElement.innerText = new Intl.NumberFormat('hy-AM').format(data.row_total);

            const cartTotalElement = document.querySelector('.total-sum-display');
            if (cartTotalElement) {
                cartTotalElement.innerText = new Intl.NumberFormat('hy-AM').format(data.cart_total);
            }
        }
    } catch (error) {
        console.error('Error updating quantity:', error);
    }
});
