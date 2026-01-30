(function() {
    const config = window.PET_COMMON_CONFIG || {};
    const routes = config.routes || {};
    const texts = config.texts || {};
    const selectors = config.selectors || {};
    const helpers = window.vetegramHelpers || {};
    const ajaxPost = helpers.ajaxPost || function(url, data, options) {
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

    const petCommon = {
        animalType: selectors.animalType || '#animaltype',
        breedSelect: selectors.breedSelect || '#breed',
        petEditModal: selectors.petEditModal || '#petEditModal'
    };

    function initSelect2(selector, options = {}) {
        if (!helpers.initSelect2) {
            return;
        }
        helpers.initSelect2(selector, options);
    }

    function initPetEditSelect() {
        initSelect2('.select4', {
            dropdownParent: $(petCommon.petEditModal)
        });
    }

    function getBreed() {
        if (!routes.getBreed) {
            return;
        }
        const type = $(petCommon.animalType).val();

        ajaxPost(routes.getBreed, { type: type }, {
            success: function(data) {
                let html = `<option value="">${texts.selectLabel || ''}</option>`;
                $.each(data.rows || [], function(i, item) {
                    html = html + '<option value="' + item.id + '">' + item.title + '</option>';
                });

                $(petCommon.breedSelect).html(html);
            }
        });
    }

    function removeAttachment(obj) {
        const id = $(obj).attr('data-id');
        if (!routes.deleteAttach) {
            return;
        }

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: texts.deleteAttachTitle || '',
            text: texts.deleteAttachConfirm || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: texts.deleteYes || '',
            cancelButtonText: texts.deleteNo || '',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            setCharge();
            if (!helpers.ajaxPost) {
                hideCharge();
                return;
            }
            helpers.ajaxPost(routes.deleteAttach, { id: id }).done(function(data) {
                if (data && data.process == '1') {
                    $(obj).parent('div').remove();
                } else if (data && data.process == '500') {
                    window.vetegramHelpers.toast({
                        text: texts.deleteAttachPermError || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                } else {
                    window.vetegramHelpers.toast({
                        text: texts.deleteAttachError || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                }

                hideCharge();
            });
        });
    }

    window.vetegramPetCommon = {
        initSelect2: initSelect2,
        initPetEditSelect: initPetEditSelect,
        getBreed: getBreed,
        removeAttachment: removeAttachment
    };
})();
