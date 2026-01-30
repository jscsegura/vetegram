(function() {
    const config = window.PET_DETAIL_CONFIG || {};
    const routes = config.routes || {};
    const labels = config.labels || {};
    const helpers = window.vetegramHelpers || {};
    const allowedExtensions = (config.allowedExtensions || []).map((ext) => (ext || '').toString().toLowerCase());

    function showToast(text, icon = 'warning', hideAfter = 4000) {
        if (!text || !window.vetegramHelpers || !window.vetegramHelpers.toast) {
            return;
        }
        window.vetegramHelpers.toast({
            text: text,
            position: 'bottom-right',
            textAlign: 'center',
            loader: false,
            hideAfter: hideAfter,
            icon: icon
        });
    }

    function validateRequired(form) {
        let valid = true;
        if (!form) return true;
        const fields = form.querySelectorAll('.requerido');
        fields.forEach((field) => {
            const value = (field.value || '').toString().trim();
            if (value === '') {
                field.classList.add('is-invalid');
                valid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        return valid;
    }

    function validateImageInput(input) {
        if (!input || !input.files || input.files.length === 0) {
            showToast(labels.selectImage);
            return false;
        }

        const nameFile = input.files[0].name || '';
        const extension = nameFile.split('.').pop().toLowerCase();
        if (allowedExtensions.length && allowedExtensions.indexOf(extension) === -1) {
            showToast(labels.extNotValid);
            return false;
        }

        return true;
    }

    function handlePhotoSubmit(event) {
        if (event) event.preventDefault();
        const form = document.getElementById('formPhoto');
        const input = document.getElementById('petPhoto');
        if (!form || !input) return false;
        if (!validateImageInput(input)) return false;
        if (typeof setCharge2 === 'function') {
            setCharge2();
        }
        form.submit();
        return true;
    }

    function handleEditSubmit(event) {
        if (event) event.preventDefault();
        const form = document.getElementById('frmEditPet');
        if (!form) return false;
        const valid = validateRequired(form);
        if (!valid) return false;
        if (typeof setCharge2 === 'function') {
            setCharge2();
        }
        form.submit();
        return true;
    }

    function triggerFormSubmit(form, handler) {
        if (!form) return;
        if (typeof form.requestSubmit === 'function') {
            form.requestSubmit();
        } else if (handler) {
            handler();
        }
    }

    function getSwal() {
        return window.Swal || window.swal || null;
    }

    function handleDeletePet(id) {
        if (!id || !routes.deletePet) return;
        const SwalLib = getSwal();
        if (!SwalLib) {
            if (confirm(labels.deleteConfirm || '')) {
                if (typeof setCharge === 'function') setCharge();
                const request = helpers.ajaxPost ? helpers.ajaxPost(routes.deletePet, { id: id }) : $.post(routes.deletePet, { id: id });
                if (request && request.done) {
                    request.done(function(data) {
                        if (data && data.process == '1' && routes.petsIndex) {
                            location.href = routes.petsIndex;
                        } else {
                            showToast(labels.deleteError, 'error');
                        }
                        if (typeof hideCharge === 'function') hideCharge();
                    });
                }
            }
            return;
        }

        const swalWithBootstrapButtons = SwalLib.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: labels.deleteTitle || '',
            text: labels.deleteConfirm || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: labels.deleteYes || '',
            cancelButtonText: labels.deleteNo || '',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) return;
            if (typeof setCharge === 'function') setCharge();
            const request = helpers.ajaxPost ? helpers.ajaxPost(routes.deletePet, { id: id }) : $.post(routes.deletePet, { id: id });
            if (request && request.done) {
                request.done(function(data) {
                    if (data && data.process == '1' && routes.petsIndex) {
                        location.href = routes.petsIndex;
                    } else {
                        showToast(labels.deleteError, 'error');
                    }
                    if (typeof hideCharge === 'function') hideCharge();
                });
            }
        });
    }

    function handleAccessPet(id) {
        if (!id || !routes.getAccess) return;
        const SwalLib = getSwal();
        if (!SwalLib) {
            return;
        }

        const swalWithBootstrapButtons = SwalLib.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: labels.accessTitle || '',
            text: labels.accessConfirm || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: labels.accessYes || '',
            cancelButtonText: labels.accessNo || '',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) return;
            if (typeof setCharge === 'function') setCharge();
            const request = helpers.ajaxPost ? helpers.ajaxPost(routes.getAccess, { id: id }) : $.post(routes.getAccess, { id: id });
            if (request && request.done) {
                request.done(function(data) {
                    if (typeof hideCharge === 'function') hideCharge();
                    if (data && data.message == '1') {
                        SwalLib.fire(labels.accessSuccessTitle || '', labels.accessSuccessText || '', 'success');
                    } else {
                        SwalLib.fire(labels.accessErrorTitle || '', labels.accessErrorText || '', 'error');
                    }
                });
            }
        });
    }

    function handleReminderTrigger(button) {
        if (!button || typeof window.setIdAppointmentToReminder !== 'function') return;
        const id = button.getAttribute('data-reminder-id') || 0;
        const onlyForMe = parseInt(button.getAttribute('data-reminder-only') || '0', 10);
        const reload = parseInt(button.getAttribute('data-reminder-reload') || '0', 10);
        const petId = button.getAttribute('data-reminder-pet') || 0;
        const channel = button.getAttribute('data-reminder-channel') || '';
        window.setIdAppointmentToReminder(id, onlyForMe, reload, petId, channel);
    }

    function initPetDetailTooltips() {
        if (typeof bootstrap === 'undefined') {
            return;
        }
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        [...tooltipTriggerList].map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));
    }

    function initPetDetailDatepicker() {
        if (typeof dateDropper === 'undefined') {
            return;
        }
        new dateDropper({
            selector: '.dDropper',
            format: 'd/m/y',
            expandable: true,
            showArrowsOnHover: true
        });
    }

    document.addEventListener('click', function(event) {
        const reminderBtn = event.target.closest('[data-pet-action="reminder"]');
        if (reminderBtn) {
            handleReminderTrigger(reminderBtn);
            return;
        }

        const editBtn = event.target.closest('[data-pet-action="edit-submit"]');
        if (editBtn) {
            const form = document.getElementById('frmEditPet');
            triggerFormSubmit(form, handleEditSubmit);
            return;
        }

        const photoBtn = event.target.closest('[data-pet-action="photo-submit"]');
        if (photoBtn) {
            const form = document.getElementById('formPhoto');
            triggerFormSubmit(form, handlePhotoSubmit);
            return;
        }

        const deleteBtn = event.target.closest('[data-pet-action="delete"]');
        if (deleteBtn) {
            handleDeletePet(deleteBtn.getAttribute('data-pet-id'));
        }

        const accessBtn = event.target.closest('[data-pet-action="access"]');
        if (accessBtn) {
            handleAccessPet(accessBtn.getAttribute('data-pet-access-id'));
        }
    });

    document.addEventListener('change', function(event) {
        const target = event.target;
        if (target && target.matches('[data-pet-action="breed-change"]')) {
            if (window.vetegramPetCommon && window.vetegramPetCommon.getBreed) {
                window.vetegramPetCommon.getBreed();
            }
        }
    });

    const editForm = document.getElementById('frmEditPet');
    if (editForm) {
        editForm.addEventListener('submit', handleEditSubmit);
    }

    const photoForm = document.getElementById('formPhoto');
    if (photoForm) {
        photoForm.addEventListener('submit', handlePhotoSubmit);
    }

    document.addEventListener('DOMContentLoaded', function() {
        initPetDetailTooltips();
        initPetDetailDatepicker();
        if (window.vetegramPetCommon && window.vetegramPetCommon.initPetEditSelect) {
            window.vetegramPetCommon.initPetEditSelect();
        }
    });
})();
