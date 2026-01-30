const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.grooming;
    if (!cfg) return;

    var helpers = window.vetegramHelpers || {};
    var ids = cfg.ids || {};
    var labels = cfg.labels || {};
    var routes = cfg.routes || {};
    var assetsBase = cfg.assetsBase || '';

    function getEl(id, fallbackId) {
        return document.getElementById(id || fallbackId);
    }

    function selectedPet() {
        var userSelect = $('#user');
        var roleId = userSelect.find('option:selected').attr('data-rol');
        if (roleId != 6) return;

        var pet = $('#pet').val();
        var vetId = $('#idvet').val();
        var id = 0;
        if (pet) {
            var pets = pet.split(':');
            id = pets[0];
        }

        $('.containerImg').remove();

        var request = helpers.ajaxPost
            ? helpers.ajaxPost(routes.getPetData, { id: id, id_vet: vetId })
            : $.post(routes.getPetData, { id: id, id_vet: vetId });

        request.done(function(data) {
            var options = '<option selected>' + (labels.selected || '') + '</option>';
            $.each(data.breeds || [], function(i, item) {
                var selected = item.id == data.breedSelected ? 'selected' : '';
                options += '<option value="' + item.id + '" ' + selected + '>' + item.title + '</option>';
            });

            var images = '';
            $.each(data.images || [], function(i, item) {
                images += '<div class="col containerImg">' +
                    '<a href="javascript:void(0);" data-id="' + item.id + '" data-appoint-action="grooming-select" class="thisimages fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2">' +
                    '<span class="petPhoto d-inline-block rounded-circle" style="background-image: url(' + assetsBase + item.image + ')"></span>' +
                    '<span>' + item.title + '</span>' +
                    '</a>' +
                    '</div>';
            });

            $('#breed').html(options);
            $('#containerGrooming').prepend(images);
        });
    }
    Appointments.selectedPet = selectedPet;

    function changeBreed() {
        var id = $('#breed').val();
        $('.containerImg').remove();

        var request = helpers.ajaxPost
            ? helpers.ajaxPost(routes.getPetDataImages, { id: id })
            : $.post(routes.getPetDataImages, { id: id });

        request.done(function(data) {
            var images = '';
            $.each(data.images || [], function(i, item) {
                images += '<div class="col containerImg">' +
                    '<a href="javascript:void(0);" data-id="' + item.id + '" data-appoint-action="grooming-select" class="thisimages fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2">' +
                    '<span class="petPhoto d-inline-block rounded-circle" style="background-image: url(' + assetsBase + item.image + ')"></span>' +
                    '<span>' + item.title + '</span>' +
                    '</a>' +
                    '</div>';
            });
            $('#containerGrooming').prepend(images);
        });
    }
    Appointments.changeBreed = changeBreed;

    function selectedImage(target) {
        var id = target.getAttribute('data-id');
        var imageSelected = getEl(ids.imageField, 'imageSelected');
        if (imageSelected) imageSelected.value = id;

        $('.unselectImage').remove();
        $('.thisimages').removeClass('border-info').addClass('border-secondary');

        $(target).removeClass('border-secondary').addClass('border-info');
        $(target).append('<span class="unselectImage" data-appoint-action="grooming-unselect"><i class="fa-solid fa-minus"></i></span>');

        if (id == '0') {
            $('#containerGroomingText').show();
        } else {
            $('#containerGroomingText').hide();
        }
    }
    Appointments.selectedImage = selectedImage;

    function removeSelectedImage(e) {
        if (e) e.stopPropagation();
        var imageSelected = getEl(ids.imageField, 'imageSelected');
        if (imageSelected) imageSelected.value = '';
        $('.unselectImage').remove();
        $('.thisimages').removeClass('border-info').addClass('border-secondary');
    }
    Appointments.removeSelectedImage = removeSelectedImage;

    function validaGrooming() {
        var isvalid = true;
        var imageSelected = getEl(ids.imageField, 'imageSelected');
        var selectedValue = imageSelected ? imageSelected.value : '';

        if (selectedValue === '') {
            window.vetegramHelpers.toast({
                text: labels.imageNotChoose || '',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'error'
            });
            isvalid = false;
        }
        if (selectedValue === '0') {
            if ($('#grooming_personalize').val() === '') {
                window.vetegramHelpers.toast({
                    text: labels.imageNotChoosePersonalize || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
                isvalid = false;
            }
        }

        if (isvalid) {
            $('#groomingModal').modal('hide');
        }
    }
    Appointments.validaGrooming = validaGrooming;

    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('[data-appoint-action="grooming-breed"]')) {
            changeBreed();
        }
    });

    document.addEventListener('click', function(e) {
        var select = e.target.closest('[data-appoint-action="grooming-select"]');
        if (select) {
            selectedImage(select);
        }

        var unselect = e.target.closest('[data-appoint-action="grooming-unselect"]');
        if (unselect) {
            removeSelectedImage(e);
        }

        var save = e.target.closest('[data-appoint-action="grooming-save"]');
        if (save) {
            validaGrooming();
        }
    });
})();
