<script>
    (function () {
        var storageKey = 'appointly-theme';
        var savedTheme = localStorage.getItem(storageKey);
        var systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        var theme = savedTheme || (systemPrefersDark ? 'dark' : 'light');

        document.documentElement.classList.toggle('dark', theme === 'dark');
        document.documentElement.style.colorScheme = theme;
    })();
</script>