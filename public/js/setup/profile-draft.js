(function() {
    const module = window.SetupCompleteProfile = window.SetupCompleteProfile || {};
    const draft = module.draft = module.draft || {};
    const config = module.config || window.SETUP_COMPLETE_PROFILE_CONFIG || {};
    const routes = module.routes || config.routes || {};
    const helpers = module.helpers || window.vetegramHelpers || {};

    function getCsrfToken() {
        if (helpers.getCsrfToken) {
            return helpers.getCsrfToken();
        }
        if (typeof $ !== 'undefined') {
            return $('meta[name="csrf-token"]').attr('content') || '';
        }
        return '';
    }

    draft.saveDraft = async function(options = {}) {
        const form = document.getElementById('frmProfile');
        if (!form) {
            return;
        }
        const stepId = options.stepId || (module.tabs && module.tabs.getActiveStepId ? module.tabs.getActiveStepId() : null);
        let actionUrl = form.action;
        if (stepId && routes.stepSave && routes.stepSave[stepId]) {
            actionUrl = routes.stepSave[stepId];
        }
        const formData = new FormData(form);
        const activeStep = stepId || (module.tabs && module.tabs.getActiveStepId ? module.tabs.getActiveStepId() : null);
        const allowProfilePhoto = activeStep === 'step1';
        const allowClinicLogo = activeStep === 'step2';
        if (options.omitFiles || !allowProfilePhoto) {
            formData.delete('profilePhoto');
        }
        if (options.omitFiles || !allowClinicLogo) {
            formData.delete('clinicLogo');
        }
        formData.append('draft', '1');
        try {
            await fetch(actionUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                credentials: 'same-origin',
                body: formData
            });
        } catch (_e) {}
    };

    draft.init = function() {
        let step4SaveTimer = null;
        $('#step4').on('input change', 'input, select, textarea', function() {
            if (step4SaveTimer) {
                clearTimeout(step4SaveTimer);
            }
            step4SaveTimer = setTimeout(() => {
                draft.saveDraft({ omitFiles: true });
            }, 800);
        });
    };
})();
