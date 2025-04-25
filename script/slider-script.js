const slider = document.querySelector('.slider-content');
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');
const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');

let currentSlide = 0;

function goToSlide(index) {
    currentSlide = index;
    slider.style.transform = `translateX(-${currentSlide * 100}%)`;
    
    // Update dots
    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === currentSlide);
    });
}

// Next slide
nextBtn.addEventListener('click', () => {
    currentSlide = (currentSlide + 1) % slides.length;
    goToSlide(currentSlide);
});

// Previous slide
prevBtn.addEventListener('click', () => {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    goToSlide(currentSlide);
});

// Dot navigation
dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        goToSlide(index);
    });
});

// Optional: Auto-slide every 5 seconds
setInterval(() => {
    currentSlide = (currentSlide + 1) % slides.length;
    goToSlide(currentSlide);
}, 5000);