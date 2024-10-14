export function initDesktop() {
    const icons = document.querySelectorAll('.icons li');

    icons.forEach(icon => {
        // Highlight of the icon
        icon.addEventListener('click', function (e) {
            e.preventDefault();
            const selectedIcon = document.querySelector('.icons .selected');
            if (selectedIcon) {
                selectedIcon.classList.remove('selected');
            }
            icon.classList.add('selected');
        });

        // drag
        // if (icon.getAttribute('data-draggable') === 'true') {
        //     let isDragging = false;
        //     let copy, offsetX, offsetY;

        //     icon.addEventListener('mousedown', function (e) {
        //         e.preventDefault();
        //         isDragging = true;

        //         // Calculate the offset relative to the mouse click
        //         offsetX = e.clientX - icon.getBoundingClientRect().left;
        //         offsetY = e.clientY - icon.getBoundingClientRect().top;

        //         // Create a copy of the original icon
        //         copy = icon.cloneNode(true);
        //         copy.classList.add('copy');
        //         copy.style.position = 'absolute';
        //         copy.style.pointerEvents = 'none';

        //         // Set the copy's initial position to match the original element
        //         const rect = icon.getBoundingClientRect();
        //         copy.style.left = `${rect.left + 6}px`; 
        //         copy.style.top = `${rect.top + 6}px`;  

        //         document.body.appendChild(copy);

        //         icon.classList.add('dragging');
        //         document.body.classList.add('hide-cursor');
        //         // document.body.style.cursor = 'none';


        //         function moveCopy(e) {
        //             if (isDragging) {
        //                 // Move the copy with the mouse, maintaining the offset
        //                 copy.style.left = `${e.clientX - offsetX + 6}px`;
        //                 copy.style.top = `${e.clientY - offsetY + 6}px`;
        //             }
        //         }

        //         document.addEventListener('mousemove', moveCopy);

        //         document.addEventListener('mouseup', function () {
        //             isDragging = false;
        //             icon.classList.remove('dragging');
        //             document.body.classList.remove('hide-cursor');

        //             if (copy) {
        //                 document.body.removeChild(copy);
        //             }

        //             document.removeEventListener('mousemove', moveCopy);
        //         }, { once: true });
        //     });
        // }

        // Double-click the icon (desktop)
        icon.addEventListener('dblclick', function (e) {
            e.preventDefault();
            openWindow(e);
        });

        // Single-tap detection for mobile
        icon.addEventListener('touchstart', function (e) {
            e.preventDefault();
            openWindow(e);
        });

        // Function to handle window opening
        function openWindow(e) {
            if (e.target.parentElement.classList.contains('icons') ||
                e.target.parentElement.parentElement.classList.contains('icons')) {

                if (e.target.id === 'resume' || e.target.parentElement.id === 'resume') {
                    let resume = document.querySelector('#resumeWindow');
                    resume.classList.remove('hide');
                    zindexWindow(resume);
                }

                if (e.target.id === 'projects' || e.target.parentElement.id === 'projects') {
                    let projects = document.querySelector('#projectsWindow');
                    if (projects.classList.contains('hide')) {
                        projects.classList.remove('hide');
                        zindexWindow(projects);
                    }
                }
            }
        }
    });


    // bring it forward with zindex + add class for css
    function zindexWindow(windowElement) {
        let highestZ = 0;
        let windows = Array.from(document.querySelector('#windows').children);

        windows.forEach(window => {
            let currentZ = parseInt(window.style.zIndex) || 0;
            if (currentZ > highestZ) {
                highestZ = currentZ;
            }
        });

        windowElement.style.zIndex = highestZ + 1;
        // remove current front window
        const frontWindow = document.querySelector('.frontWindow');
        if (frontWindow) {
            frontWindow.classList.remove('frontWindow');
        }
        windowElement.classList.add('frontWindow')
    }

    //close = return windows
    const closeButtons = document.querySelectorAll('.close')
    const returnButtons = document.querySelectorAll('.back')
    closeButtons.forEach(closeButton => {
        closeButton.addEventListener('click', function (e) {
            closeButton.parentElement.parentElement.classList.add('hide')
        })
    });
    returnButtons.forEach(returnButtons => {
        returnButtons.addEventListener('click', function (e) {
            returnButtons.parentElement.parentElement.classList.add('hide')
        })
    });

    // bring window forward when clicking on it
    let windows = Array.from(document.querySelector('#windows').children);

    windows.forEach(window => {
        window.addEventListener('click', function (e) {
            let folderElement = e.target.closest('.folder');
            let resumeElement = e.target.closest('.resume');

            if (folderElement) {
                zindexWindow(folderElement);
                activateOverlayPdf();
            }
            else if (resumeElement) {
                zindexWindow(resumeElement);
            }
            else {
                console.log(e);
            }
        });
    });

    //overlay pdf to allow event listeners on iframes

    const overlay = document.querySelector('.overlay-pdf');

    overlay.addEventListener('click', function (e) {
        // overlay transparent to allow clicks to pass through
        disableOverlayPdf()
    });


    function activateOverlayPdf() {
        overlay.style.pointerEvents = 'auto';
    }
    function disableOverlayPdf() {
        overlay.style.pointerEvents = 'none';
    }

    // project folders
    const iconFolders = document.querySelectorAll('.icons-folder li');
    iconFolders.forEach(icon => {
        // highlight of the icon
        icon.addEventListener('click', function (e) {
            e.preventDefault();
            const selectedIcon = document.querySelector('.icons-folder .selected');
            if (selectedIcon) {
                selectedIcon.classList.remove('selected');
            }
            icon.classList.add('selected');
        });
        // double-click the icon (desktop)
        icon.addEventListener('dblclick', function (e) {
            e.preventDefault();
            openWindow(e);
        });
        // double-tap detection for mobile
        icon.addEventListener('touchstart', function (e) {
            console.log("Touch events supported");
            e.preventDefault();
            openWindow(e);
        });

        function openWindow(e) {
            let id = e.target.id || e.target.parentElement.id;

            if (e.target.parentElement.classList.contains('icons-folder') ||
                e.target.parentElement.parentElement.classList.contains('icons-folder')) {

                let windowElement;

                switch (id) {
                    case '2022':
                        windowElement = document.getElementById('2022Window');
                        break;
                    case '2023':
                        windowElement = document.getElementById('2023Window');
                        break;
                    case '2024':
                        windowElement = document.getElementById('2024Window');
                        break;
                    case 'botPDF':
                        windowElement = document.getElementById('botWindow');
                        break;
                    case 'restaurantPDF':
                        windowElement = document.getElementById('restaurantWindow');
                        break;
                    case 'ecommercePDF':
                        windowElement = document.getElementById('ecommerceWindow');
                        break;
                    case 'restaurantMenuPDF':
                        windowElement = document.getElementById('menuWindow');
                        break;
                    case 'hospitalPDF':
                        windowElement = document.getElementById('hospitalWindow');
                        break;
                    case 'refactoringPDF':
                        windowElement = document.getElementById('refactoringWindow');
                        break;
                    case 'migrationPDF':
                        windowElement = document.getElementById('migrationWindow');
                        break;
                    case 'karumanyPDF':
                        windowElement = document.getElementById('karumanyWindow');
                        break;
                    case 'linkedinPDF':
                        windowElement = document.getElementById('linkedinWindow');
                        break;
                    case 'blogPDF':
                        windowElement = document.getElementById('blogWindow');
                        break;
                    case 'flashcardsPDF':
                        windowElement = document.getElementById('flashcardsWindow');
                        break;
                    default:
                        console.log('No matching window found');
                        return;
                }

                // show the window and adjust the z-index
                if (windowElement) {
                    windowElement.classList.remove('hide');
                    zindexWindow(windowElement);
                }
            }
        }

    });
}
