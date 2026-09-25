import './bootstrap';

// Import CoreUI
import * as coreui from '@coreui/coreui';

window.coreui = coreui;

// --- Preferensi tampilan (tersimpan di cookie, bertahan walau browser ditutup) ---
function getCookie(name) {
    const match = document.cookie.match(new RegExp('(?:^|; )' + name + '=([^;]*)'));
    return match ? decodeURIComponent(match[1]) : null;
}

function setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${encodeURIComponent(value)};expires=${date.toUTCString()};path=/;SameSite=Lax`;
}

document.addEventListener('DOMContentLoaded', function () {
    const sidebarEl = document.querySelector('#sidebar');
    if (!sidebarEl) {
        return;
    }

    const sidebar = coreui.Sidebar.getInstance(sidebarEl) || new coreui.Sidebar(sidebarEl);

    // Terapkan preferensi tersimpan sebelum user sempat melihat kedipan tampilan default.
    if (getCookie('sidebar_hidden') === '1') {
        sidebar.hide();
    }

    sidebarEl.addEventListener('hidden.coreui.sidebar', () => setCookie('sidebar_hidden', '1', 365));
    sidebarEl.addEventListener('shown.coreui.sidebar', () => setCookie('sidebar_hidden', '0', 365));
});
