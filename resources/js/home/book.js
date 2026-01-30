(function () {
    const Home = window.Home = window.Home || {};
    const config = window.HOME_BOOK_CONFIG || {};
    const helpers = window.vetegramHelpers || {};
    const ajaxPost = helpers.ajaxPost || function (url, data, options) {
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
    const texts = config.texts || {};
    const routes = config.routes || {};
    const urls = config.urls || {};
    const assetsBase = config.assetsBase || '';
    const doctorRoleId = Number(config.doctorRoleId || 0);
    const doctorVetId = config.doctorVetId;

    if (typeof Home.dateDropper === 'function') {
        new dateDropper({
            selector: '.dDropper',
            format: 'dd/mm/y',
            expandable: true,
            showArrowsOnHover: true,
            onDropdownExit: changeDate
        });
    }

    function selectedHour(obj) {
        const id = $(obj).attr('data-id');

        $('#hourSelected').val(id);

        $('.deleteD').remove();
        $('.selectDays').removeClass('active');
        $(obj).addClass('active');
        $(obj).append('<span class="deleteD" onclick="removeSelected(event);"><i class="fa-solid fa-minus"></i></span>');
    }

    function removeSelected(event) {
        if (event) {
            event.stopPropagation();
        }
        $('#hourSelected').val(0);

        $('.deleteD').remove();
        $('.selectDays').removeClass('active');
    }

    function changeDate() {
        const value = $('#dateShow').val();
        if (!value) {
            return;
        }

        const parts = value.split('/');
        const date = parts[2] + '-' + parts[1] + '-' + parts[0];

        if (typeof Home.setCharge === 'function') {
            setCharge();
        }

        const base = urls.bookHoursBase || '';
        location.href = base + '/' + config.vetId + '/' + btoa(date);
    }

    function reserveHour() {
        const hourid = $('#hourSelected').val();

        if (Number(hourid) > 0) {
            if (typeof Home.setCharge === 'function') {
                setCharge();
            }

            ajaxPost(routes.reserveHour || '', { id: hourid }, {
                success: function (data) {
                    if (data.reserve !== '1') {
                        window.vetegramHelpers.toast({
                            text: texts.hourNotAvailable || '',
                            position: 'bottom-right',
                            textAlign: 'center',
                            loader: false,
                            hideAfter: 4000,
                            icon: 'warning'
                        });
                    }
                    if (data.reserve === '1') {
                        $('#bookModal').modal('show');
                    }
                    if (typeof Home.hideCharge === 'function') {
                        hideCharge();
                    }
                }
            });
        } else {
            window.vetegramHelpers.toast({
                text: texts.hourNotChoose || '',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'error'
            });
        }
    }

    function selectedPet(obj) {
        const id = $(obj).attr('data-id');

        $('#petSelected').val(id);

        $('.unselectPet').remove();
        $('.thispets').removeClass('border-info');
        $('.thispets').addClass('border-secondary');

        $(obj).removeClass('border-secondary');
        $(obj).addClass('border-info');

        $(obj).append('<span class="unselectPet" onclick="removeSelectedPet(event);"><i class="fa-solid fa-minus"></i></span>');

        if (doctorRoleId === 6) {
            $('.containerImg').remove();

            ajaxPost(routes.getPetData || '', { id: id, id_vet: doctorVetId }, {
                success: function (data) {
                    let options = '<option selected>' + (texts.selectedLabel || '') + '</option>';
                    let optionSelect = '';

                    $.each(data.breeds, function (i, item) {
                        optionSelect = (item.id === data.breedSelected) ? 'selected' : '';
                        options = options + '<option value="' + item.id + '" ' + optionSelect + '>' + item.title + '</option>';
                    });

                    let images = '';
                    $.each(data.images, function (i, item) {
                        images = images + '<div class="col containerImg">' +
                            '<a href="javascript:void(0);" data-id="' + item.id + '" onclick="selectedImage(this);" class="thisimages fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2">' +
                                '<span class="petPhoto d-inline-block rounded-circle" style="background-image: url(' + assetsBase + item.image + ')"></span>' +
                                '<span>' + item.title + '</span>' +
                            '</a>' +
                        '</div>';
                    });

                    $('#breed').html(options);
                    $('#containerGrooming').prepend(images);
                }
            });
        }
    }

    function selectedImage(obj) {
        const id = $(obj).attr('data-id');

        $('#imageSelected').val(id);

        $('.unselectImage').remove();
        $('.thisimages').removeClass('border-info');
        $('.thisimages').addClass('border-secondary');

        $(obj).removeClass('border-secondary');
        $(obj).addClass('border-info');

        $(obj).append('<span class="unselectImage" onclick="removeSelectedImage(event);"><i class="fa-solid fa-minus"></i></span>');

        const source = document.querySelector('.unselectPet');
        const target = document.querySelector('.unselectImage');

        if (source && target && window.getComputedStyle) {
            const styles = getComputedStyle(source);
            for (const property in styles) {
                if (typeof styles[property] === 'string' && styles[property] !== '') {
                    target.style[property] = styles[property];
                }
            }
        }

        if (id === '0' || id === 0) {
            $('#containerGroomingText').show();
        } else {
            $('#containerGroomingText').hide();
        }
    }

    function changeBreed(obj) {
        const id = $(obj).val();

        $('.containerImg').remove();
        ajaxPost(routes.getPetDataImages || '', { id: id }, {
            success: function (data) {
                let images = '';
                $.each(data.images, function (i, item) {
                    images = images + '<div class="col containerImg">' +
                        '<a href="javascript:void(0);" data-id="' + item.id + '" onclick="selectedImage(this);" class="thisimages fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2">' +
                            '<span class="petPhoto d-inline-block rounded-circle" style="background-image: url(' + assetsBase + item.image + ')"></span>' +
                            '<span>' + item.title + '</span>' +
                        '</a>' +
                    '</div>';
                });

                $('#containerGrooming').prepend(images);
            }
        });
    }

    function removeSelectedPet(event) {
        if (event) {
            event.stopPropagation();
        }
        $('#petSelected').val(0);

        $('.unselectPet').remove();
        $('.thispets').removeClass('border-info');
        $('.thispets').addClass('border-secondary');
    }

    function removeSelectedImage(event) {
        if (event) {
            event.stopPropagation();
        }
        $('#imageSelected').val('');

        $('.unselectImage').remove();
        $('.thisimages').removeClass('border-info');
        $('.thisimages').addClass('border-secondary');
    }

    function sendAppointment() {
        const hour = $('#hourSelected').val();
        const pet = $('#petSelected').val();

        const extValid = ['.jpg', '.JPG', '.jpeg', '.JPEG', '.png', '.PNG', '.gif', '.GIF', '.pdf', '.PDF', '.mp3', '.mp4', '.avi', '.zip', '.rar', '.doc', '.docx', '.ppt', '.pptx', '.pptm', '.pps', '.ppsm', '.ppsx', '.xls', '.xlsx'];

        let isvalid = true;
        const files = $('#bookAttach').get(0) ? $('#bookAttach').get(0).files : [];

        for (let i = 0; i < files.length; ++i) {
            const name = files[i].name || '';
            const extension = name.substring(name.lastIndexOf('.'));
            const position = jQuery.inArray(extension, extValid);
            if (position === -1) {
                isvalid = false;

                window.vetegramHelpers.toast({
                    text: texts.extNotValid || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'warning'
                });
            }
        }

        if (Number(hour) === 0) {
            window.vetegramHelpers.toast({
                text: texts.hourNotChoose || '',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'error'
            });
            isvalid = false;
        }
        if (Number(pet) === 0) {
            window.vetegramHelpers.toast({
                text: texts.petNotChoose || '',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'error'
            });
            isvalid = false;
        }

        if (doctorRoleId === 6) {
            if ($('#imageSelected').val() === '') {
                window.vetegramHelpers.toast({
                    text: texts.imageNotChoose || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
                isvalid = false;
            }
            if ($('#imageSelected').val() === '0') {
                if ($('#grooming_personalize').val() === '') {
                    window.vetegramHelpers.toast({
                        text: texts.imageNotChoosePersonalize || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                    isvalid = false;
                }
            }
        }

        if (isvalid) {
            if (typeof Home.setCharge2 === 'function') {
                setCharge2();
            }

            ajaxPost(routes.saveBook || '', new FormData(document.getElementById('frmUploaderAppoinment')), {
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.save === 1) {
                        location.href = (urls.bookMessageBase || '') + '/' + data.id;
                    } else {
                        window.vetegramHelpers.toast({
                            text: data.error,
                            position: 'bottom-right',
                            textAlign: 'center',
                            loader: false,
                            hideAfter: 4000,
                            icon: 'error'
                        });
                    }

                    if (typeof Home.hideCharge2 === 'function') {
                        hideCharge2();
                    }
                },
                error: function () {
                    window.vetegramHelpers.toast({
                        text: texts.appointmentSaveError || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });

                    if (typeof Home.hideCharge2 === 'function') {
                        hideCharge2();
                    }
                }
            });
        }
    }

    Home.selectedHour = selectedHour;
    Home.removeSelected = removeSelected;
    Home.changeDate = changeDate;
    Home.reserveHour = reserveHour;
    Home.selectedPet = selectedPet;
    Home.selectedImage = selectedImage;
    Home.changeBreed = changeBreed;
    Home.removeSelectedPet = removeSelectedPet;
    Home.removeSelectedImage = removeSelectedImage;
    Home.sendAppointment = sendAppointment;
})();
