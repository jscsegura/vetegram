(function() {
    const helpers = window.vetegramHelpers || {};
    const config = window.SCHEDULE_EXTRA_INDEX_CONFIG || {};
    const routes = config.routes || {};
    const texts = config.texts || {};

    document.addEventListener('DOMContentLoaded', function() {
        if (!window.bootstrap || !window.bootstrap.Tooltip) {
            return;
        }
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                delay: {
                    show: 0,
                    hide: 100
                }
            });
        });
    });

    function searchRows() {
        var search = $('#searchExtra').val();
        if (!routes.searchBase) {
            return;
        }
        location.href = routes.searchBase + '/' + btoa(search);
    }

    function removeExtraAvailability(id) {
        const swalRef = window.Swal || window.swal;
        if (!swalRef || !routes.delete) {
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
                helpers.ajaxPost(routes.delete, { id: id })
                    .done(function(data) {
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
                    })
                    .always(function() {
                        hideCharge();
                    });
            }
        });
    }

    document.addEventListener('click', function(e) {
        const searchBtn = e.target.closest('[data-schedule-action="extra-search"]');
        if (searchBtn) {
            e.preventDefault();
            searchRows();
            return;
        }
        const deleteBtn = e.target.closest('[data-schedule-action="extra-delete"]');
        if (deleteBtn) {
            e.preventDefault();
            const rowId = deleteBtn.getAttribute('data-row-id');
            if (rowId) {
                removeExtraAvailability(rowId);
            }
        }
    });
})();
