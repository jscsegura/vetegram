(function() {
    const config = window.APPOINTMENTS_EDIT_CONFIG || {};
    const helpers = window.vetegramHelpers || {};
    const module = window.AppointmentsEdit = window.AppointmentsEdit || {};
    const texts = config.texts || {};
    const routes = config.routes || {};
    const selectors = config.selectors || {};

    module.config = config;
    module.texts = texts;
    module.routes = routes;
    module.helpers = helpers;
    module.state = module.state || {
        appointmentId: config.appointmentId || null,
        recipeModal: selectors.recipeModal || '#recipeModal',
        reloadToComplete: true
    };

    module.ajaxPost = helpers.ajaxPost || function(url, data, options) {
        if (!window.$) {
            return null;
        }
        return $.ajax(Object.assign({
            type: 'POST',
            url: url,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': helpers.getCsrfToken ? helpers.getCsrfToken() : ''
            },
            data: data
        }, options));
    };

    module.initSelects = function() {
        if (!helpers.initSelect2 || typeof $ === 'undefined') {
            return;
        }
        helpers.initSelect2('.select2');
        helpers.initSelect2('.select3', { dropdownParent: $(module.state.recipeModal) });
    };

    module.initDatepicker = function() {
        if (typeof dateDropper === 'undefined') {
            return;
        }
        new dateDropper({
            selector: '.dDropper',
            format: 'd/m/y',
            expandable: true,
            showArrowsOnHover: true
        });
    };

    module.init = function() {
        module.initSelects();
        module.initDatepicker();
    };

    document.addEventListener('DOMContentLoaded', function() {
        module.init();
    });

    const router = window.vetegramActionRouter;
    if (router && router.register) {
        router.register('updateRecipe', function() {
            if (module.recipe && module.recipe.updateRecipe) {
                return module.recipe.updateRecipe.apply(null, arguments);
            }
        });
        router.register('updateOther', function() {
            if (module.recipe && module.recipe.updateOther) {
                return module.recipe.updateOther.apply(null, arguments);
            }
        });
        router.register('removeRecipe', function() {
            if (module.recipe && module.recipe.removeRecipe) {
                return module.recipe.removeRecipe.apply(null, arguments);
            }
        });
        router.register('removeFile', function() {
            if (module.attachments && module.attachments.removeFile) {
                return module.attachments.removeFile.apply(null, arguments);
            }
        });
        router.register('setToCancel', function() {
            if (module.ui && module.ui.setToCancel) {
                return module.ui.setToCancel.apply(null, arguments);
            }
        });
    }
})();
