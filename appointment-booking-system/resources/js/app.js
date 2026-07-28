

import Alpine from 'alpinejs';

const themeStorageKey = 'appointly-theme';

const systemTheme = () => (
    window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
);

const storedTheme = () => localStorage.getItem(themeStorageKey);

const currentTheme = () => storedTheme() || systemTheme();

const applyTheme = (theme) => {
    document.documentElement.classList.toggle('dark', theme === 'dark');
    document.documentElement.style.colorScheme = theme;
    window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme } }));
};

window.appTheme = {
    current: currentTheme,
    apply(theme) {
        localStorage.setItem(themeStorageKey, theme);
        applyTheme(theme);
        return theme;
    },
    toggle() {
        return this.apply(currentTheme() === 'dark' ? 'light' : 'dark');
    },
};

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    if (! storedTheme()) {
        applyTheme(systemTheme());
    }
});

applyTheme(currentTheme());
window.Alpine = Alpine;

Alpine.start();
