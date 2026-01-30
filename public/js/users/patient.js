const Users = window.Users = window.Users || {};
(function() {
    const config = window.USERS_PATIENT_CONFIG || {};
    const routes = config.routes || {};

    function searchRows() {
        var search = $('#searchUser').val();
        if (!routes.searchBase) {
            return;
        }
        location.href = routes.searchBase + '/' + btoa(search);
    }

    Users.searchRows = searchRows;
})();
