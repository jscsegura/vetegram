(function() {
    const config = window.PHOTO_SIGNATURE_CONFIG || {};
    const routes = config.routes || {};
    const labels = config.labels || {};
    const helpers = window.vetegramHelpers || {};
    const allowedExtensions = (config.allowedExtensions || []).map((ext) => (ext || '').toString().toLowerCase());

    const ids = config.ids || {};
    const signatureModalId = ids.signatureModal || 'signatureModal';
    const signatureCanvasId = ids.signatureCanvas || 'signature-pad';
    const clearBtnId = ids.clearBtn || 'clear';
    const saveBtnId = ids.saveBtn || 'saveSignature';
    const photoFormId = ids.photoForm || 'formPhoto';
    const photoInputId = ids.photoInput || 'profilePhoto';

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
        const form = document.getElementById(photoFormId);
        const input = document.getElementById(photoInputId);
        if (!form || !input) return false;
        if (!validateImageInput(input)) return false;
        if (typeof setCharge2 === 'function') {
            setCharge2();
        }
        form.submit();
        return true;
    }

    let signaturePad = null;
    let resizeHandlerBound = false;

    function resizeCanvas(canvas) {
        if (!canvas) return;
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        const ctx = canvas.getContext('2d');
        if (ctx) {
            ctx.scale(ratio, ratio);
        }
    }

    function initSignaturePad() {
        if (typeof SignaturePad === 'undefined') return null;
        const canvas = document.getElementById(signatureCanvasId);
        if (!canvas) return null;

        if (!signaturePad) {
            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)'
            });

            const clearBtn = document.getElementById(clearBtnId);
            if (clearBtn) {
                clearBtn.addEventListener('click', function() {
                    signaturePad.clear();
                });
            }

            const saveBtn = document.getElementById(saveBtnId);
            if (saveBtn) {
                saveBtn.addEventListener('click', function() {
                    if (!signaturePad || signaturePad.isEmpty()) {
                        showToast(labels.drawSignature, 'warning', 3000);
                        return;
                    }

                    const signature = signaturePad.toDataURL('image/png');
                    if (!routes.setSignature) return;
                    if (typeof setCharge === 'function') {
                        setCharge();
                    }
                    const request = helpers.ajaxPost ? helpers.ajaxPost(routes.setSignature, { signature: signature }) : $.post(routes.setSignature, { signature: signature });
                    if (request && request.done) {
                        request.done(function() {
                            location.reload();
                        });
                    }
                });
            }
        }

        resizeCanvas(canvas);
        if (!resizeHandlerBound) {
            resizeHandlerBound = true;
            window.addEventListener('resize', function() {
                resizeCanvas(canvas);
            });
        }

        return signaturePad;
    }

    function initSignatureModal() {
        const modal = document.getElementById(signatureModalId);
        if (!modal) return;
        modal.addEventListener('shown.bs.modal', function() {
            initSignaturePad();
        });
    }

    function changeNotified() {
        if (!routes.setNotifications) return;
        const email = document.getElementById('notifiedEmail');
        const smsEl = document.getElementById('notifiedSms');
        const whatsappEl = document.getElementById('notifiedWhatsapp');

        const mailer = email && email.checked ? 1 : 0;
        const sms = smsEl && smsEl.checked ? 1 : 0;
        const whatsapp = whatsappEl && whatsappEl.checked ? 1 : 0;

        const request = helpers.ajaxPost
            ? helpers.ajaxPost(routes.setNotifications, { mailer: mailer, sms: sms, whatsapp: whatsapp })
            : $.post(routes.setNotifications, { mailer: mailer, sms: sms, whatsapp: whatsapp });

        if (request && request.done) {
            request.done(function() {
                showToast(labels.notifiedChange, 'success');
            });
        }
    }

    document.addEventListener('click', function(event) {
        const photoBtn = event.target.closest('[data-photo-action="photo-submit"]');
        if (photoBtn) {
            const form = document.getElementById(photoFormId);
            if (form && typeof form.requestSubmit === 'function') {
                form.requestSubmit();
            } else {
                handlePhotoSubmit();
            }
        }
    });

    document.addEventListener('submit', function(event) {
        const target = event.target;
        if (target && target.id === photoFormId) {
            handlePhotoSubmit(event);
        }
    });

    document.addEventListener('change', function(event) {
        const target = event.target;
        if (target && target.matches('[data-profile-action="notified-change"]')) {
            changeNotified();
        }
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSignatureModal);
    } else {
        initSignatureModal();
    }
})();
