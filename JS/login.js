export function initLogin() {
    const closeWarning = document.getElementById("closeWarning");
    const warning = document.getElementById("warning");
    setTimeout(function() {
        warning.classList.add('hide');
    }, 2500);

    const input = document.getElementById("login-password");
    input.focus();
    input.setSelectionRange(input.value.length, input.value.length);

    document.getElementById("icon-next").addEventListener('click', function() {
        loged();
    });

    document.getElementById("login-password").addEventListener('keydown', function(event) {
        if (event.key === "Enter") {
            loged();
        }
    });

    function loged() {
        document.querySelector('body').classList.add('loged');
    }
}
