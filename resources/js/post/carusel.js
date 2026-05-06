let slideIndices = {};

window.moveSlide = function(postId, step) {
    showSlide(postId, slideIndices[postId] ? slideIndices[postId] += step : slideIndices[postId] = step);
}

window.currentSlide = function(postId, index) {
    showSlide(postId, slideIndices[postId] = index);
}

function showSlide(postId, index) {
    const carousel = document.querySelector(`.post-carousel[data-post-id="${postId}"]`);
    const slides = carousel.querySelectorAll('.carousel-slide');
    const container = carousel.querySelector('.carousel-container');
    const dots = carousel.querySelectorAll('.dot');

    if (!slideIndices[postId]) slideIndices[postId] = 0;

    if (index >= slides.length) slideIndices[postId] = 0;
    if (index < 0) slideIndices[postId] = slides.length - 1;

    const offset = -slideIndices[postId] * 100;
    container.style.transform = `translateX(${offset}%)`;

    dots.forEach(dot => dot.classList.remove('active'));
    if (dots[slideIndices[postId]]) {
        dots[slideIndices[postId]].classList.add('active');
    }
}
function moveSlide(button, direction) {
    const container = button.parentElement;
    const images = container.querySelectorAll('.carousel-img');
    let activeIndex = Array.from(images).findIndex(img => img.classList.contains('active'));

    images[activeIndex].classList.remove('active');

    activeIndex += direction;

    if (activeIndex >= images.length) activeIndex = 0;
    if (activeIndex < 0) activeIndex = images.length - 1;

    images[activeIndex].classList.add('active');
}
