(function() {
    const config = window.OWNERS_CONFIG || {};
    const routes = config.routes || {};
    const ids = config.ids || {};

    function getSearchText() {
        const input = document.getElementById(ids.searchInput || 'searchOwner');
        return input ? input.value : '';
    }

    function searchOwners() {
        if (!routes.owners) return;
        const text = getSearchText();
        if (typeof setCharge === 'function') {
            setCharge();
        }
        location.href = `${routes.owners}/${btoa(text)}`;
    }

    function setCreateUser() {
        const input = document.getElementById(ids.associateInput || 'associateUserDoctor');
        if (input) {
            input.value = '1';
        }
    }

    document.addEventListener('click', function(event) {
        const searchBtn = event.target.closest('[data-owners-action="search"]');
        if (searchBtn) {
            searchOwners();
            return;
        }

        const createBtn = event.target.closest('[data-owners-action="create-user"]');
        if (createBtn) {
            setCreateUser();
        }
    });

    document.addEventListener('keydown', function(event) {
        const input = event.target;
        if (!input) return;
        if (input.id === (ids.searchInput || 'searchOwner') && event.key === 'Enter') {
            event.preventDefault();
            searchOwners();
        }
    });
})();
