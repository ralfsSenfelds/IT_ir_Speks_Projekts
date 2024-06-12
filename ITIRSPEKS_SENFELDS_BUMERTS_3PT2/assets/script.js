const container = document.getElementById('slideshow-container');
const slides = document.querySelectorAll('.mySlides');
const slideWidth = container.clientWidth / 5;

slides.forEach(slide => {
    const clone = slide.cloneNode(true);
    container.appendChild(clone);
});

const totalSlides = container.querySelectorAll('.mySlides').length;
let scrollAmount = 0;

function autoScroll() {
    const maxScroll = (totalSlides - slides.length) * slideWidth;
    const initialScroll = container.scrollLeft;
    const targetScroll = (scrollAmount + slideWidth) % (maxScroll + slideWidth);
    const direction = targetScroll > initialScroll ? 1 : 0;
    const scrollStep = 10;
    const stepCount = Math.abs(targetScroll - initialScroll) / scrollStep;
    let currentStep = 0;

    function smoothScroll() {
        if (currentStep < stepCount) {
            currentStep++;
            container.scrollBy(direction * scrollStep, 0);
            requestAnimationFrame(smoothScroll);
        } else {
            scrollAmount = targetScroll;
            container.scrollLeft = scrollAmount;
            if (scrollAmount >= maxScroll) {
                container.style.scrollBehavior = 'auto';
                container.scrollLeft = 0;
                container.style.scrollBehavior = 'smooth';
                scrollAmount = 0;
            }
        }
    }

    smoothScroll();
}

container.addEventListener('scroll', () => {
    const maxScroll = (totalSlides - slides.length) * slideWidth;
    if (container.scrollLeft >= maxScroll) {
        container.style.scrollBehavior = 'auto';
        container.scrollLeft = container.scrollLeft - maxScroll;
        container.style.scrollBehavior = 'smooth';
    }
});

setInterval(autoScroll, 2000);

document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menu-btn');
    const navbar = document.querySelector('.navbar');

    menuBtn.addEventListener('click', () => {
        navbar.classList.toggle('active');
    });
});
