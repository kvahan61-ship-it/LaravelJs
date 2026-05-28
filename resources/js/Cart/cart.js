document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.cart-qty-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const row = this.closest('.cart-item-row');
            const cartItemId = this.dataset.id;
            const action = this.classList.contains('plus') ? 'increase' : 'decrease';
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch(`/cart/update/${cartItemId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ action: action })
                });

                const data = await response.json();

                if (data.status === 'success') {
                    const input = row.querySelector('.cart-qty-input');
                    if (input) input.value = data.new_quantity;

                    const rowTotalDisplay = row.querySelector('.row-total');
                    if (rowTotalDisplay) {
                        rowTotalDisplay.innerText = Number(data.row_total).toLocaleString('hy-AM') + ' ֏';
                    }

                    document.querySelectorAll('.checkout-card span:last-child').forEach((el, index) => {
                        if(el.innerText.includes('֏') && !el.innerText.includes('Անվճար')) {
                            el.innerText = Number(data.cart_total).toLocaleString('hy-AM') + ' ֏';
                        }
                    });
                }
            } catch (error) {
                console.error('Սխալ զամբյուղի քանակը թարմացնելիս:', error);
            }
        });
    });
});
