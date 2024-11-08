window.onload = function() {
    const me = document.querySelector('.me');
    if (me) {
        document.body.addEventListener('scroll', function() {
            const scrollPosition = document.body.scrollTop;
            const fadeOutPoint = 300;
            const opacity = Math.max(0, 1 - (scrollPosition / fadeOutPoint));
            me.style.opacity = opacity;
        });
    }
    const stickyPoint = 0; 
    const header = document.querySelector('header');
    document.body.addEventListener('scroll', function() {
        const scrollPosition = document.body.scrollTop || document.documentElement.scrollTop;
        
        if (scrollPosition > stickyPoint) {
            header.classList.add('scrolling');
        } else {
            header.classList.remove('scrolling');
        }
    });

    const burger = document.querySelector(".burger");

    burger.addEventListener("click", function () {
        if (document.body.classList.contains("menu-open")) {
            document.body.classList.remove("menu-open");
        } else {
            document.body.classList.add("menu-open");
        }
    });
}
