document.addEventListener('DOMContentLoaded', function() {
    const minusBtn = document.querySelector('.minus-btn');
    const plusBtn = document.querySelector('.plus-btn');
    const quantityInput = document.getElementById('product-quantity');
    const addToCartBtn = document.querySelector('.add-to-cart-btn-primary');

    if (minusBtn && plusBtn && quantityInput) {
        minusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        plusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        });

        quantityInput.addEventListener('change', function() {
            if (this.value < 1 || isNaN(this.value)) {
                this.value = 1;
            }
        });
    }

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', async function(e) {
            e.preventDefault();

            const postId = this.dataset.id;
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch(`/cart/add/${postId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ quantity: quantity })
                });

                const data = await response.json();

                if (response.ok && data.status === 'success') {
                    const badge = document.getElementById('cart-badge');
                    if (badge) badge.innerText = data.cart_count;

                    addToCartBtn.style.background = '#1e7e34';
                    addToCartBtn.innerHTML = '<i class="fa fa-check"></i> Ավելացվեց';

                    setTimeout(() => {
                        addToCartBtn.style.background = '#28a745';
                        addToCartBtn.innerHTML = '<i class="fa fa-shopping-cart"></i> Ավելացնել զամբյուղ';
                    }, 2000);

                } else {
                    console.error("Server Error:", data);
                    alert('Սխալ: ' + (data.message || 'Անհայտ սխալ'));
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                alert('Կապի սխալ: ' + error.message);
            }
        });
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const imageWrapper = document.querySelector('.single-image-wrapper');
    const imageOverlay = document.querySelector('.product-image-overlay');

    if (imageWrapper && imageOverlay) {
        imageWrapper.addEventListener('mouseenter', function () {
            imageOverlay.classList.add('active');
        });

        imageWrapper.addEventListener('mouseleave', function () {
            imageOverlay.classList.remove('active');
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const track = document.getElementById('showCarouselTrack');
    const counter = document.getElementById('showCarouselCounter');
    const prevBtn = document.getElementById('prevShowBtn');
    const nextBtn = document.getElementById('nextShowBtn');

    // Ստուգում ենք՝ արդյոք էջում կան այս տարրերը (որ ուրիշ էջերում սխալ չտա)
    if (track) {
        const images = track.querySelectorAll('img');
        const totalImages = images.length;
        let currentIndex = 0;

        if (totalImages > 1 && prevBtn && nextBtn) {

            // Աջ կոճակի սեղմում
            nextBtn.addEventListener('click', function () {
                currentIndex++;
                if (currentIndex >= totalImages) {
                    currentIndex = 0;
                }
                updateCarouselLayout();
            });

            // Ձախ կոճակի սեղմում
            prevBtn.addEventListener('click', function () {
                currentIndex--;
                if (currentIndex < 0) {
                    currentIndex = totalImages - 1;
                }
                updateCarouselLayout();
            });
        }


        function updateCarouselLayout() {
            track.style.transform = `translateX(-${currentIndex * 100}%)`;
            if (counter) {
                counter.textContent = `${currentIndex + 1} / ${totalImages}`;
            }
        }
    }
});
