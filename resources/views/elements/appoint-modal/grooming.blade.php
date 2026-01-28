<div class="modal fade" id="groomingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.data.appoinment') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
            <input type="hidden" name="imageSelected" id="imageSelected" value="0">
            <div class="mb-3">
                <label class="form-label">{{ trans('dash.label.element.breed') }}</label>
                <select class="form-select fc" id="breed" name="breed" aria-label="Select" onchange="changeBreed(this);">
                    <option selected>{{ trans('dash.label.selected') }}</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ trans('dash.label.element.select.cut') }}</label>
                <div class="row row-cols-1 row-cols-sm-2 g-2 g-md-3 mb-3" id="containerGrooming">
                    
                    <div class="col">
                        <a href="javascript:void(0);" data-id="0" onclick="selectedImage(this);" class="thisimages fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2">
                            <span class="petPhoto d-inline-block rounded-circle" style="background-image: url({{ asset('img/default.png') }})"></span>
                            <span>{{ trans('dash.label.other') }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mb-3" id="containerGroomingText" style="display: none;">
                <label class="form-label">{{ trans('dash.label.element.select.cut.other') }}</label>
                <input type="text" name="grooming_personalize" id="grooming_personalize" value="" class="form-control fc" maxlength="254">
            </div>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
            <button type="button" onclick="validaGrooming();" class="btn btn-primary btn-sm px-4">{{ trans('dash.label.btn.continue') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
    var assets = '{{ asset('/') }}';

    function selectedPet() {
        var rolid = $('#user').find('option:selected').attr('data-rol');
        if(rolid == 6) {
            var pet = $('#pet').val();
            var id_vet = $('#idvet').val();

            var id = 0;

            if(pet != '') {
                var pets = pet.split(":");
                var id = pets[0];
            }

            $('.containerImg').remove();

            $.post('{{ route('search.getPetData') }}', {id:id, id_vet:id_vet},
                function (data){
                    var options = '<option selected>{{ trans('dash.label.selected') }}</option>';
                    var optionSelect = '';

                    $.each(data.breeds, function(i, item) {
                        if(item.id == data.breedSelected) {
                            optionSelect = 'selected';
                        }else{
                            optionSelect = '';
                        }
                        options = options + '<option value="'+item.id+'" '+optionSelect+'>'+item.title+'</option>';
                    });

                    var images = '';
                    $.each(data.images, function(i, item) {
                        images = images + '<div class="col containerImg">' +
                            '<a href="javascript:void(0);" data-id="'+item.id+'" onclick="selectedImage(this);" class="thisimages fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2">' +
                                '<span class="petPhoto d-inline-block rounded-circle" style="background-image: url('+assets+item.image+')"></span>' +
                                '<span>'+item.title+'</span>' +
                            '</a>' +
                        '</div>';
                    });
                    
                    $('#breed').html(options);
                    $('#containerGrooming').prepend(images);
                }
            );
        }
    }

    function changeBreed (obj) {
        var id = $(obj).val();

        $('.containerImg').remove();
        $.post('{{ route('search.getPetDataImages') }}', {id:id},
            function (data){
                var images = '';
                $.each(data.images, function(i, item) {
                    images = images + '<div class="col containerImg">' +
                        '<a href="javascript:void(0);" data-id="'+item.id+'" onclick="selectedImage(this);" class="thisimages fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2">' +
                            '<span class="petPhoto d-inline-block rounded-circle" style="background-image: url('+assets+item.image+')"></span>' +
                            '<span>'+item.title+'</span>' +
                        '</a>' +
                    '</div>';
                });
                
                $('#containerGrooming').prepend(images);
            }
        );
    }

    function selectedImage(obj) {
        var id = $(obj).attr('data-id');

        $('#imageSelected').val(id);

        $('.unselectImage').remove();
        $('.thisimages').removeClass('border-info');
        $('.thisimages').addClass('border-secondary');

        $(obj).removeClass('border-secondary');
        $(obj).addClass('border-info');

        $(obj).append('<span class="unselectImage" onclick="removeSelectedImage(event);"><i class="fa-solid fa-minus"></i></span>');

        if(id == 0) {
            $('#containerGroomingText').show();
        }else{
            $('#containerGroomingText').hide();
        }
    }

    function removeSelectedImage() {
        event.stopPropagation();
        $('#imageSelected').val('');

        $('.unselectImage').remove();
        $('.thisimages').removeClass('border-info');
        $('.thisimages').addClass('border-secondary');
    }

    function validaGrooming() {
        var isvalid = true;

        if($('#imageSelected').val() == '') {
            $.toast({
                text: '{{ trans('dash.image.not.choose') }}',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'error'
            });
            isvalid = false;
        }
        if($('#imageSelected').val() == '0') {
            if($('#grooming_personalize').val() == '') {
                $.toast({
                    text: '{{ trans('dash.image.not.choose.personalize') }}',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
                isvalid = false;
            }
        }

        if(isvalid == true) {
            $('#groomingModal').modal('hide');
        }
    }
</script>
@endpush