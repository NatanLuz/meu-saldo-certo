<!-- Theme initialization script: only included in app layout (after login) -->
<script>
	(function() {
		try {
			var stored = localStorage.getItem('theme');
			if (stored === 'dark') {
				document.documentElement.classList.add('dark');
			} else if (stored === 'light') {
				document.documentElement.classList.remove('dark');
			} else {
				if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
					document.documentElement.classList.add('dark');
				}
			}
		} catch (e) {
		}
	})();
</script>
