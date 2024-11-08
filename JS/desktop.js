import { initializeSlider } from './slider.js';
export function initDesktop() {
    sessionStorage.clear();
    addIconEventListeners();

    // Function to handle window opening
    function openWindow(e) {
        let pathElement = e.target.closest('[data-path]');
        if (pathElement) {
            let path = pathElement.getAttribute('data-path');
            performAjaxRequest(path);
        }
    }

    // AJAX request for the new window
    function performAjaxRequest(path) {
        let xhr = new XMLHttpRequest();
        let url = 'index.php?page=ActionPath&path=' + encodeURIComponent(path);
        if (document.body.classList.contains('max')) {
            url += '&size=max';
        }
    
        xhr.open('GET', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
        let prevFrontWindow = document.querySelector('.frontWindow');
    
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.body.insertAdjacentHTML('beforeend', xhr.responseText);
                if (prevFrontWindow) {
                    prevFrontWindow.remove();
                }
                let addedWindow = document.body.lastElementChild;
                addWindowEventListeners(addedWindow);
                addIconEventListeners();
            } else {
                console.error('Error:', xhr.status, xhr.statusText);
            }
        };
        xhr.send();
    }
    

    function addIconEventListeners() {
        const icons = document.querySelectorAll('.icons li');
        icons.forEach(icon => {
            if (!icon.dataset.eventsAdded) {
                icon.addEventListener('click', handleIconClick);
                icon.addEventListener('dblclick', handleIconDblClick);
                icon.addEventListener('touchstart', handleIconTouch);
                icon.dataset.eventsAdded = true;
            }
        });
    }

    function addWindowEventListeners(addedWindow) {
        let nav = addedWindow.querySelector('.dirInput');
        if (nav) {
            nav.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    performAjaxRequest(nav.value);
                }
            });
        }

        let backButton = addedWindow.querySelector('.back');
        if (backButton) {
            backButton.addEventListener('click', function() {
                let pathElement = backButton.getAttribute('data-path');
                if (pathElement) {
                    performAjaxRequest(pathElement, true);
                }
            });
        }

        let maximizeButton = addedWindow.querySelector('.maximize');
        if (maximizeButton) {
            maximizeButton.addEventListener('click', function(e) {
                if (document.body.classList.contains('max')) {
                    document.body.classList.remove('max');
                    e.target.src = 'IMG/maximize.png';
                } else {
                    document.body.classList.add('max');
                    e.target.src = 'IMG/minimize.png';
                }
            });
        }

        let closeButton = addedWindow.querySelector('.close');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                if (addedWindow.parentElement) {
                    addedWindow.remove();
                }
            });
        }
        let slider = addedWindow.querySelector('.swiper');
        if (slider) {
            initializeSlider(slider);
        }
    }

    function handleIconClick(e) {
        e.preventDefault();
        const selectedIcon = document.querySelector('.icons .selected');
        if (selectedIcon) {
            selectedIcon.classList.remove('selected');
        }
        e.currentTarget.classList.add('selected');
    }

    function handleIconDblClick(e) {
        e.preventDefault();
        openWindow(e);
    }

    function handleIconTouch(e) {
        e.preventDefault();
        openWindow(e);
    }
}
