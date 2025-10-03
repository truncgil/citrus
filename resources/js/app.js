import './bootstrap';

// Dark mode initialization
document.addEventListener('DOMContentLoaded', function() {
    // Check for saved theme preference or default to 'light'
    const savedTheme = localStorage.getItem('darkMode');
    
    if (savedTheme === null) {
        // If no saved preference, check system preference
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        localStorage.setItem('darkMode', prefersDark.toString());
    }
    
    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (localStorage.getItem('darkMode') === null) {
            localStorage.setItem('darkMode', e.matches.toString());
            window.location.reload();
        }
    });
});


