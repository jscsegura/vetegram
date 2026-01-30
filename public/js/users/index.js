const Users = window.Users = window.Users || {};
(function() {
    const config = window.USERS_INDEX_CONFIG || {};
    const routes = config.routes || {};
    const texts = config.texts || {};
    const helpers = window.vetegramHelpers || {};

    function searchRows() {
        var search = $('#searchUser').val();
        if (!routes.searchBase) {
            return;
        }
        location.href = routes.searchBase + '/' + btoa(search);
    }

    function removeUser(id) {
        const swalRef = window.Swal || window.swal;
        if (!swalRef || !routes.deleteUser) {
            return;
        }
        const swalWithBootstrapButtons = swalRef.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: texts.deleteTitle || '',
            text: texts.deleteConfirm || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: texts.deleteYes || '',
            cancelButtonText: texts.deleteNo || '',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                setCharge();
                if (!helpers.ajaxPost) {
                    hideCharge();
                    return;
                }
                helpers.ajaxPost(routes.deleteUser, { id: id }).done(function(data) {
                    if (data && data.process == '1') {
                        $('#row' + id).remove();
                    } else {
                        window.vetegramHelpers.toast({
                            text: texts.deleteError || '',
                            position: 'bottom-right',
                            textAlign: 'center',
                            loader: false,
                            hideAfter: 4000,
                            icon: 'error'
                        });
                    }

                    hideCharge();
                });
            }
        });
    }

    function changeStatus(id, obj) {
        if (!routes.changeStatus) {
            return;
        }
        var status = 1;

        if ($(obj).is(':checked')) {
            status = 0;
        }

        if (!helpers.ajaxPost) {
            return;
        }
        helpers.ajaxPost(routes.changeStatus, { id: id, status: status }).done(function(data) {
            if (data && data.process == '1') {
                window.vetegramHelpers.toast({
                    text: texts.statusSuccess || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'success'
                });
            } else {
                window.vetegramHelpers.toast({
                    text: texts.statusError || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
            }
        });
    }

    function excedeLimite() {
        const swalRef = window.Swal || window.swal;
        if (!swalRef) {
            return;
        }
        swalRef.fire(texts.limitTitle || '', texts.limitMessage || '', 'error');
    }

    Users.searchRows = searchRows;
    Users.removeUser = removeUser;
    Users.changeStatus = changeStatus;
    Users.excedeLimite = excedeLimite;
})();
