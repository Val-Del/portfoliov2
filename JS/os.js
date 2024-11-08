import { initLogin } from './login.js';
import { initDesktop } from './desktop.js';
window.onload = function() {
    initLogin();
    initDesktop();
};
