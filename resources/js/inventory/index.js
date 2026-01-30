const Inventory = window.Inventory = window.Inventory || {};
const inventoryIndexConfig = window.INVENTORY_INDEX_CONFIG || {};
const inventoryIndexTexts = inventoryIndexConfig.texts || {};
const inventoryIndexRoutes = inventoryIndexConfig.routes || {};
const inventoryIndexSelectors = inventoryIndexConfig.selectors || {};
const helpers = window.vetegramHelpers || {};

const inventoryIndex = {
    searchInput: inventoryIndexSelectors.searchInput || '#searchMedicine',
    rowPrefix: inventoryIndexSelectors.rowPrefix || '#row'
};

function initInventoryTooltips() {
    if (typeof bootstrap === 'undefined') {
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
}

document.addEventListener('DOMContentLoaded', initInventoryTooltips);

function inventoryAjaxPost(url, data, options = {}) {
    if (helpers.ajaxPost) {
        return helpers.ajaxPost(url, data, options);
    }
    if (typeof $ === 'undefined') {
        return null;
    }
    const token = helpers.getCsrfToken ? helpers.getCsrfToken() : '';
    return $.ajax(Object.assign({
        type: 'POST',
        url: url,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': token
        },
        data: data
    }, options));
}

function searchRows() {
    const search = $(inventoryIndex.searchInput).val() || '';
    if (!inventoryIndexRoutes.searchBase) {
        return;
    }
    location.href = `${inventoryIndexRoutes.searchBase}/${btoa(search)}`;
}
Inventory.searchRows = searchRows;

function removeMedicine(id) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
            cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: inventoryIndexTexts.deleteTitle || '',
        text: inventoryIndexTexts.deleteConfirm || '',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: inventoryIndexTexts.deleteYes || '',
        cancelButtonText: inventoryIndexTexts.deleteNo || '',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }
        if (!inventoryIndexRoutes.deleteUrl) {
            return;
        }

        setCharge();

        inventoryAjaxPost(inventoryIndexRoutes.deleteUrl, { id: id }, {
            success: function(data) {
                if (data && data.process === '1') {
                    $(`${inventoryIndex.rowPrefix}${id}`).remove();
                } else {
                    window.vetegramHelpers.toast({
                        text: inventoryIndexTexts.deleteError || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                }
                hideCharge();
            },
            error: function() {
                window.vetegramHelpers.toast({
                    text: inventoryIndexTexts.deleteError || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
                hideCharge();
            }
        });
    });
}
Inventory.removeMedicine = removeMedicine;

function changeStatus(id, obj) {
    if (!inventoryIndexRoutes.changeEnabledUrl) {
        return;
    }
    const status = $(obj).is(':checked') ? 1 : 0;

    inventoryAjaxPost(inventoryIndexRoutes.changeEnabledUrl, { id: id, status: status }, {
        success: function(data) {
            if (data && data.process === '1') {
                window.vetegramHelpers.toast({
                    text: inventoryIndexTexts.enabledSuccess || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'success'
                });
            } else {
                window.vetegramHelpers.toast({
                    text: inventoryIndexTexts.enabledError || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
            }
        },
        error: function() {
            window.vetegramHelpers.toast({
                text: inventoryIndexTexts.enabledError || '',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'error'
            });
        }
    });
}
Inventory.changeStatus = changeStatus;
