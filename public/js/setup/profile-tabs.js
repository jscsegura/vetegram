(function() {
    const module = window.SetupCompleteProfile = window.SetupCompleteProfile || {};
    const tabs = module.tabs = module.tabs || {};
    const config = module.config || window.SETUP_COMPLETE_PROFILE_CONFIG || {};
    module.state = module.state || {};
    if (typeof module.state.isProfileComplete === 'undefined') {
        module.state.isProfileComplete = !!config.isProfileComplete;
    }

    tabs.getActiveStepId = function() {
        const activeStep = document.querySelector('.tab-pane.show.active');
        return activeStep ? activeStep.id : null;
    };

    tabs.updateActionButtons = function() {
        const activeStep = tabs.getActiveStepId();
        if (!activeStep) {
            return;
        }
        if (module.state.isProfileComplete) {
            const btn = document.querySelector(`.wizard-next-btn[data-step="${activeStep}"]`);
            if (btn) {
                btn.disabled = false;
            }
            return;
        }
        const ready = module.validation && module.validation.stepIsReady
            ? module.validation.stepIsReady(activeStep)
            : true;
        const btn = document.querySelector(`.wizard-next-btn[data-step="${activeStep}"]`);
        if (btn) {
            btn.disabled = !ready;
        }
    };

    tabs.setNextLoading = function(stepId, isLoading) {
        const btn = document.querySelector(`.wizard-next-btn[data-step="${stepId}"]`);
        if (!btn) return;
        const defaultLabel = btn.getAttribute('data-default-label') || btn.textContent;
        const loadingLabel = btn.getAttribute('data-loading-label') || defaultLabel;
        btn.disabled = isLoading;
        btn.textContent = isLoading ? loadingLabel : defaultLabel;
    };

    tabs.changeTab = async function(tabId, options = {}) {
        if (!options.skipDraft && module.draft && module.draft.saveDraft) {
            await module.draft.saveDraft();
        }
        const tabContent = document.getElementById('formSteps');
        if (!tabContent) {
            return;
        }
        const tabPane = tabContent.querySelector(`#${tabId}`);
        if (!tabPane) {
            return;
        }

        const allTabs = tabContent.querySelectorAll('.tab-pane');
        allTabs.forEach(tab => tab.classList.remove('show', 'active'));

        tabPane.classList.add('show', 'active');

        const allSteps = document.querySelectorAll('.step-btn');
        allSteps.forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-secondary');
        });
        const activeBtn = document.querySelector(`.step-btn[data-step="${tabId}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('btn-outline-secondary');
            activeBtn.classList.add('btn-primary');
        }
        window.scrollTo({ top: 0, behavior: 'smooth' });
        if (tabId === 'step4' && module.map && module.map.onStep4Active) {
            module.map.onStep4Active();
        }
        if (tabId === 'step5') {
            $('#schedule_enabled').val('1');
        }
        tabs.updateActionButtons();
    };

    tabs.nextStep = async function(currentStep, nextStepId) {
        if (module.validation && module.validation.validateStep) {
            if (!module.validation.validateStep(currentStep)) {
                return;
            }
        }
        tabs.setNextLoading(currentStep, true);
        if (module.draft && module.draft.saveDraft) {
            await module.draft.saveDraft();
        }
        tabs.setNextLoading(currentStep, false);
        tabs.changeTab(nextStepId, { skipDraft: true });
    };

    tabs.init = function() {
        $('#frmProfile').on('input change', 'input, select, textarea', function() {
            tabs.updateActionButtons();
        });
        tabs.updateActionButtons();

        $('#step5').on('change', 'select[name^="schedule["]', function() {
            $('#schedule_enabled').val('1');
        });
    };
})();
