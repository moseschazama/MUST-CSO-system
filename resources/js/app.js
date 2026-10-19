/**
 * Lightweight progressive enhancement.
 *
 * The site remains fully usable without JavaScript: the mobile navigation is
 * rendered in the document and only toggled here, and destructive actions ask
 * for confirmation before submitting.
 */
const menuButton = document.querySelector('[data-mobile-menu-button]');
const mobileMenu = document.querySelector('[data-mobile-menu]');

if (menuButton && mobileMenu) {
    const setMenuOpen = (open) => {
        menuButton.setAttribute('aria-expanded', String(open));
        mobileMenu.classList.toggle('hidden', !open);
    };

    menuButton.addEventListener('click', () => {
        setMenuOpen(menuButton.getAttribute('aria-expanded') !== 'true');
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && menuButton.getAttribute('aria-expanded') === 'true') {
            setMenuOpen(false);
            menuButton.focus();
        }
    });

    mobileMenu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setMenuOpen(false));
    });
}

document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        const message = form.getAttribute('data-confirm');

        if (message && ! window.confirm(message)) {
            event.preventDefault();
        }
    });
});
