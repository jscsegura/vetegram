(function() {
    document.addEventListener('DOMContentLoaded', function() {
        if (!window.bootstrap || !window.bootstrap.Tooltip) {
            return;
        }
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach((el) => new bootstrap.Tooltip(el));
    });
})();
