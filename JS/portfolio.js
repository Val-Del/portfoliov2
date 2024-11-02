window.onload = function() {
    const me = document.querySelector('.me');

    document.body.addEventListener('scroll', function() {
        const scrollPosition = document.body.scrollTop;
        const fadeOutPoint = 300;
        const opacity = Math.max(0, 1 - (scrollPosition / fadeOutPoint));
        me.style.opacity = opacity;
    });
}
