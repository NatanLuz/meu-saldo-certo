<script>
    (function () {
        try {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        } catch (e) {
            document.documentElement.classList.remove('dark');
        }
    })();
</script>
