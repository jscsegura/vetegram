@php $weblang = \App::getLocale(); @endphp

<div class="docCol card rounded-3 border-2 border-secondary">
    <div class="card-body p-3 p-lg-4">
        <button id="notiPet" type="button" class="btn py-1 px-2 position-absolute" onclick="setIdAppointmentToReminder('{{ $pet->id }}', '0', '0', '1', 'sms-whatsapp');" data-bs-toggle="modal" data-bs-target="#reminderModal">
            <span>
                <i class="fa-solid fa-bell fs-5"></i>
                <span class="position-absolute start-50 translate-middle text-white" style="font-size: .6rem; top:14px;"><i class="fa-solid fa-plus"></i></span>
            </span>
        </button>
        @php
            $photo = asset('img/default.png');
            if((isset($pet->photo)) && ($pet->photo != '')) {
                $photo = asset('files/' . $pet->photo);
            }
        @endphp

        <div class="docPhoto position-relative rounded-circle mx-auto" style="background-image: url({{ $photo }});">
            <button type="button" class="pencilBtn" data-bs-toggle="modal" data-bs-target="#changePhoto">
                <i class="fa-solid fa-pen"></i>
            </button>
        </div>
        
        <h1 class="h3 text-uppercase text-center mt-2 mb-0">{{ $pet->name }}</h1>
        <p class="fw-medium text-center small text-uppercase text-black mb-0">Id: {{ str_pad($pet->id, 6, "0", STR_PAD_LEFT) }}</p>
        <p class="fw-medium text-center small text-black mb-2">
            <span data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" data-bs-offset="0,8" data-bs-title="{{ $owner->phone }} <br> {{ $owner->email }}">
                {{ $owner->name }}<i class="fa-solid fa-circle-info opacity-75 ms-2"></i>
            </span>
        </p>
                
        <table class="table info small mb-0">
            <tbody>
                <tr>
                    @if(isset($pet['getBreed']['title_' . $lang]))
                    <td style="width: 50%;">
                        <span class="fw-medium d-block">{{ trans('dash.label.element.breed') }}:</span>
                        {{ $pet['getBreed']['title_' . $lang] }}
                    </td>
                    @endif
                    <td>
                        <span class="fw-medium d-block">{{ trans('dash.label.element.age') }}:</span>
                        {{ ($pet->age != '') ? App\Models\Pet::getAgeValue($pet->age) : trans('dash.labe.no.info') }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="fw-medium d-block">{{ trans('dash.label.element.sex') }}:</span>
                        {{ ($pet->gender != '') ? trans('dash.label.sex.' . $pet->gender) : trans('dash.labe.no.info') }}
                    </td>
                    <td>
                        <span class="fw-medium d-block">{{ trans('dash.label.element.sterilized') }}:</span>
                        {{ ($pet->castrate == 1) ? trans('dash.label.yes') : trans('dash.label.not') }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="fw-medium d-block">Color:</span>
                        {{ ($pet->color != '') ? $pet->color : trans('dash.labe.no.info') }}
                    </td>
                    <td>
                        <span class="fw-medium d-block">{{ trans('dash.label.element.food') }}:</span>
                        {{ ($pet->alimentation != '') ? $pet->alimentation : trans('dash.labe.no.info') }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="fw-medium d-block">{{ trans('dash.label.element.blood') }}:</span>
                        {{ ($pet->blood != '') ? $pet->blood : trans('dash.labe.no.info') }}
                    </td>
                    <td>
                        <span class="fw-medium d-block">{{ trans('dash.label.element.disease') }}:</span>
                        {{ ($pet->disease != '') ? $pet->disease : trans('dash.labe.no.info') }}
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</div>

<div class="d-flex flex-column flex-xxl-row mt-3 gap-3">
    <a target="_blank" href="{{ route('pet.historyDownload', App\Models\User::encryptor('encrypt', $pet->id)) }}" class="btn btn-primary btn-sm text-uppercase px-3 py-2 d-block w-100">
        <i class="fa-solid fa-download me-1"></i>
        {{ trans('dash.label.element.historical') }}
    </a>

    <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm text-uppercase px-3 py-2 d-block w-100" data-bs-toggle="modal" data-bs-target="#petEditModal">
        <i class="fa-solid fa-edit me-1"></i>
        {{ trans('dash.label.btn.edit.pet') }}
    </a>
</div>

@if((Auth::guard('web')->user()->rol_id != 8) && ($credentials['access'] == false))
<a href="javascript:void(0);" onclick="getAccessToPet('{{ App\Models\User::encryptor('encrypt', $pet->id) }}');" class="btn btn-outline-success btn-sm text-uppercase px-3 py-2 d-block mt-3 w-100">
    <i class="fa-solid fa-fingerprint me-1"></i>
    {{ trans('dash.msg.access.pet') }}
</a>
@endif

@if(Auth::guard('web')->user()->rol_id == 8)
<a href="javascript:void(0);" onclick="removePet('{{ $pet->id }}');" class="btn btn-outline-danger btn-sm text-uppercase px-3 py-2 d-block mt-3">
    <i class="fa-solid fa-remove me-1"></i>
    {{ trans('dash.msg.delete.pet') }}
</a>
@endif

<div class="modal fade" id="petEditModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.btn.edit.pet') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
            <form name="frmEditPet" id="frmEditPet" method="post" action="{{ route('pets.editPet') }}" enctype="multipart/form-data" onsubmit="return sendFormEdit();">
                @csrf

                <input type="hidden" name="petId" id="petId" value="{{ $pet->id }}">
                <div class="mb-3">
                    <label for="name" class="form-label small">{{ trans('dash.label.element.name.pet') }}</label>
                    <input type="text" name="name" id="name" value="{{ $pet->name }}" class="form-control fc requerido">
                </div>

                <div class="mb-3">
                    <label for="animaltype" class="form-label small">{{ trans('dash.label.element.type.pet') }}</label>
                    <select name="animaltype" id="animaltype" class="form-select fc select4 requerido" onchange="getBreed();">
                        <option value="">{{ trans('auth.register.complete.select') }}</option>
                        @foreach ($allTypes as $type)
                            <option value="{{ $type->id }}" @if($type->id == $pet->type) selected='selected' @endif>{{ $type['title_' . $weblang] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="breed" class="form-label small">{{ trans('dash.label.element.breed') }}</label>
                    <select name="breed" id="breed" class="form-select fc select4 requerido">
                        <option value="">{{ trans('auth.register.complete.select') }}</option>
                        @foreach ($allBreed as $breed)
                            <option value="{{ $breed->id }}" @if($breed->id == $pet->breed) selected='selected' @endif>{{ $breed['title_' . $weblang] }}</option>
                        @endforeach
                    </select>
                </div>

                @if(Auth::guard('web')->user()->rol_id != 8)
                <div class="row row-cols-1 row-cols-md-2 mb-3 g-3">
                    <div class="col">
                        <label for="petage" class="form-label small">{{ trans('dash.label.element.birthdate') }}</label>
                        <input type="text" name="petage" id="petage" value="{{ $pet->age }}" class="form-control fc dDropper">
                    </div>
                    <div class="col">
                        <label class="form-label small d-block mb-2">{{ trans('dash.label.element.sex') }}</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sex" id="sexmale" value="macho" @if($pet->gender == 'macho') checked @endif>
                            <label class="form-check-label" for="sexmale">
                                {{ trans('dash.label.element.sex.male') }}
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sex" id="sexfemale" value="hembra" @if($pet->gender == 'hembra') checked @endif>
                            <label class="form-check-label" for="sexfemale">
                                {{ trans('dash.label.element.sex.female') }}
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <label for="color" class="form-label small">Color</label>
                        <input type="text" name="color" id="color" value="{{ $pet->color }}" class="form-control fc">
                    </div>
                    <div class="col">
                        <label class="form-label small d-block mb-2">{{ trans('dash.label.element.sterilized') }}</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="castrated" id="castratedyes" value="1" @if($pet->castrate == 1) checked @endif>
                            <label class="form-check-label" for="castratedyes">
                                {{ trans('dash.label.yes') }}
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="castrated" id="castratedno" value="0" @if($pet->castrate == 0) checked @endif>
                            <label class="form-check-label" for="castratedno">
                                {{ trans('dash.label.not') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="feeding" class="form-label small">{{ trans('dash.label.element.food') }}</label>
                    <input type="text" name="feeding" id="feeding" value="{{ $pet->alimentation }}" class="form-control fc">
                </div>
                <div class="mb-3">
                    <label for="blood" class="form-label small">{{ trans('dash.label.element.blood') }}</label>
                    <select id="blood" name="blood" class="form-select fc">
                        <option value="" selected>{{ trans('dash.label.selected') }}</option>
                        <option value="A+" @if ($pet->blood == "A+") selected @endif>A+</option>
                        <option value="O+" @if ($pet->blood == "O+") selected @endif>O+</option>
                        <option value="B+" @if ($pet->blood == "B+") selected @endif>B+</option>
                        <option value="AB+" @if ($pet->blood == "AB+") selected @endif>AB+</option>
                        <option value="A-" @if ($pet->blood == "A-") selected @endif>A-</option>
                        <option value="O-" @if ($pet->blood == "O-") selected @endif>O-</option>
                        <option value="B-" @if ($pet->blood == "B-") selected @endif>B-</option>
                        <option value="AB-" @if ($pet->blood == "AB-") selected @endif>AB-</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="disease" class="form-label small">{{ trans('dash.label.element.disease') }}</label>
                    <input type="text" name="disease" id="disease" value="{{ $pet->disease }}" class="form-control fc">
                </div>
                @endif
                
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" value="1" id="deadFlag" name="deadFlag" @if($pet->dead_flag == 1) checked @endif>
                    <label class="form-check-label" for="deadFlag">
                        <span class="ms-1">{{ trans('dash.label.element.dead') }}</span>
                        <i class="fa-solid fa-ribbon ms-1 opacity-50"></i>
                    </label>
                </div>
                
            </form>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button onclick="sendFormEditValidate();" id="agendarBtn" type="button" class="btn btn-primary btn-sm fw-medium px-4">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="changePhoto" tabindex="-1" aria-labelledby="pencilBtnLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.element.photo') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
            <form method="post" id="formPhoto" name="formPhoto" enctype="multipart/form-data" method="post" action="{{ route('pets.savePhoto') }}" onsubmit="return validaImage();">
                @csrf
                
                <input type="hidden" name="petIdImg" id="petIdImg" value="{{ $pet->id }}">
                <div>
                  <label for="profilePhoto" class="form-label small mb-1">{{ trans('dash.label.element.select.file') }}</label>
                  <input class="form-control" type="file" id="petPhoto" name="petPhoto" style="padding: .375rem .75rem;" accept="{{ App\Models\AppointmentAttachment::getExtensions(true) }}">
                </div>
            </form>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button type="button" onclick="sendFormPhoto();" class="btn btn-primary btn-sm px-4">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function sendFormPhoto() {
            $('#formPhoto').submit();
        }

        @php
        $exts = explode(',', App\Models\AppointmentAttachment::getExtensions(true));
        @endphp
        function validaImage() {
            var extValid = <?php echo json_encode($exts); ?>;

            var validate = true;

            var img = document.getElementById('petPhoto');

            if (img.files.length > 0) {
                
                var nameFile = img.files[0].name;
                
                var extension = nameFile.split('.').pop();
                
                var position = jQuery.inArray(extension, extValid);
                if(position == -1) {
                    validate = false;
                    
                    $.toast({
                    text: '{{ trans('dash.msg.ext.not.valid') }}',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'warning'
                    });
                }
            }else{
                validate = false;

                $.toast({
                text: '{{ trans('dash.msg.select.image') }}',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'warning'
                });
            }

            if(validate == true) {
                setCharge2();

                return true;
            }else{
                return false;
            }

        }

        function getBreed(obj) {

            var type = $('#animaltype').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('get.breed') }}',
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                data: {
                    type: type
                },
                beforeSend: function(){},
                success: function(data){
                    var html = '<option value="">{{ trans('auth.register.complete.select') }}</option>';
                    $.each(data.rows, function(i, item) {
                        html = html + '<option value="'+item.id+'">'+item.title+'</option>';
                    });

                    $('#breed').html(html);
                }
            });
        }

        function sendFormEditValidate() {
            $('#frmEditPet').submit();
        }

        function sendFormEdit() {
            var validate = true;

            $('.requerido').each(function(i, elem){
                var value = $(elem).val();
                var value = value.trim();
                if(value == ''){
                    $(elem).addClass('is-invalid');
                    validate = false;
                }else{
                    $(elem).removeClass('is-invalid');
                }
            });

            if(validate == true) {
                setCharge2();

                return true;
            }

            return false;
        }

        function removePet(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                    cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: '{{ trans('dash.msg.delete.pet') }}',
                text: '{{ trans('dash.msg.confir.delete.pet') }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '{{ trans('dash.label.yes.delete') }}',
                cancelButtonText: '{{ trans('dash.label.no.cancel') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                        }
                    });

                    setCharge();
                    
                    $.post('{{ route('pets.delete') }}', {id:id},
                        function (data){
                            if(data.process == '1') {
                                location.href = '{{ route('pets.index') }}';
                            }else{
                                $.toast({
                                    text: '{{ trans('dash.msg.error.delete.pet') }}',
                                    position: 'bottom-right',
                                    textAlign: 'center',
                                    loader: false,
                                    hideAfter: 4000,
                                    icon: 'error'
                                });
                            }

                            hideCharge();
                        }
                    );
                }
            });
        }

        function getAccessToPet(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                    cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: '{{ trans('dash.msg.access.pet') }}',
                text: '{{ trans('dash.msg.confir.access.pet') }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '{{ trans('dash.label.yes.access') }}',
                cancelButtonText: '{{ trans('dash.label.no.cancel') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                        }
                    });

                    setCharge();
                    
                    $.post('{{ route('pets.getAccess') }}', {id:id},
                        function (data){
                            hideCharge();

                            if(data.message == '1') {
                                swal.fire("{{ trans('dash.swal.msg.success') }}", "{{ trans('dash.swal.msg.access.complete') }}", "success");
                            }else{
                                swal.fire("{{ trans('dash.swal.msg.error') }}", "{{ trans('dash.swal.msg.access.error') }}", "error");
                            }
                        }
                    );
                }
            });
        }
    </script>
@endpush