window.onload = function() {
    const me = document.querySelector('.me')
    window.addEventListener('scroll', function() {
        const scrollPosition = window.scrollY;
        const fadeOutPoint = 300;
        // opacity based on scroll position
        const opacity = Math.max(0, 1 - (scrollPosition / fadeOutPoint));
        me.style.opacity = opacity;
    });
}