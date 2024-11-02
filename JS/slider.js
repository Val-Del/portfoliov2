export function initializeSlider(sliderContainer) {
    if (!sliderContainer) {
        console.error("Slider container not found");
        return;
    }

    const slide = sliderContainer.querySelector(".slide");
    const images = Array.from(slide.querySelectorAll(".image"));
    const leftArrow = sliderContainer.querySelector(".left");
    const rightArrow = sliderContainer.querySelector(".right");
    const thumbnails = Array.from(sliderContainer.querySelectorAll(".thumbnail"));
    const captionElement = sliderContainer.querySelector(".caption");

    let currentIndex = 0;  // Start with the first image

    // Function to update the displayed image and caption
    function updateSlider() {
        const imgWidth = images[0].clientWidth;
        slide.style.transform = `translateX(-${currentIndex * imgWidth}px)`;
        captionElement.textContent = images[currentIndex].getAttribute("data-caption");
        updateThumbnailHighlight();
    }

    // Function to highlight the active thumbnail
    function updateThumbnailHighlight() {
        thumbnails.forEach((thumbnail, index) => {
            thumbnail.style.border = index === currentIndex ? "2px solid #FFFFFF" : "2px solid transparent";
        });
    }

    // Move to the next image
    function nextSlide() {
        currentIndex = (currentIndex + 1) % images.length;
        updateSlider();
    }

    // Move to the previous image
    function prevSlide() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateSlider();
    }

    // Event listeners for arrows
    rightArrow.addEventListener("click", nextSlide);
    leftArrow.addEventListener("click", prevSlide);

    // Event listeners for thumbnails
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener("click", () => {
            currentIndex = index;
            updateSlider();
        });
    });

    // Initial setup
    updateSlider();
}

// Initialize the slider after the DOM is fully loaded
document.addEventListener("DOMContentLoaded", () => {
    const sliderContainer = document.querySelector(".slider");
    initializeSlider(sliderContainer);
});
