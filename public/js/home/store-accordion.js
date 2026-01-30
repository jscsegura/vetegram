(function () {
    const config = window.HOME_STORE_ACCORDION_CONFIG || {};
    const breakpoint = Number(config.breakpoint || 1200);
    const accordion = document.getElementById('marketNav');

    if (!accordion) {
        return;
    }

    const collapseOne = accordion.querySelector('#collapseOne');
    const collapseBtn = accordion.querySelector('#catBtn');

    if (!collapseOne || !collapseBtn) {
        return;
    }

    function toggleAccordion() {
        if (window.innerWidth <= breakpoint) {
            if (collapseOne.classList.contains('show')) {
                collapseOne.classList.remove('show');
            }
            collapseBtn.classList.add('collapsed');
        } else {
            if (!collapseOne.classList.contains('show')) {
                collapseOne.classList.add('show');
            }
            collapseBtn.classList.remove('collapsed');
        }
    }

    toggleAccordion();

    const query = matchMedia('(max-width: ' + breakpoint + 'px)');
    if (query.addEventListener) {
        query.addEventListener('change', toggleAccordion);
    } else if (query.addListener) {
        query.addListener(toggleAccordion);
    }
})();
