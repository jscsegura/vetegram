(function() {
    window.addEventListener('load', function() {
        const body = document.body;
        if (!body) {
            return;
        }
        if (body.getAttribute('data-auto-print') === '1') {
            if (typeof window.print === 'function') {
                window.print();
            }
        }
    });
})();
