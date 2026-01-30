@php $weblang = \App::getLocale(); @endphp

<div class="docCol card rounded-3 border-2 border-secondary">
    <div class="card-body p-3 p-lg-4">
        <button id="notiPet" type="button" class="btn py-1 px-2 position-absolute" data-pet-action="reminder" data-reminder-id="{{ $pet->id }}" data-reminder-only="0" data-reminder-reload="0" data-reminder-pet="1" data-reminder-channel="sms-whatsapp" data-bs-toggle="modal" data-bs-target="#reminderModal">
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
<a href="javascript:void(0);" data-pet-action="access" data-pet-access-id="{{ App\Models\User::encryptor('encrypt', $pet->id) }}" class="btn btn-outline-success btn-sm text-uppercase px-3 py-2 d-block mt-3 w-100">
    <i class="fa-solid fa-fingerprint me-1"></i>
    {{ trans('dash.msg.access.pet') }}
</a>
@endif

@if(Auth::guard('web')->user()->rol_id == 8)
<a href="javascript:void(0);" data-pet-action="delete" data-pet-id="{{ $pet->id }}" class="btn btn-outline-danger btn-sm text-uppercase px-3 py-2 d-block mt-3">
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
            <form name="frmEditPet" id="frmEditPet" method="post" action="{{ route('pets.editPet') }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="petId" id="petId" value="{{ $pet->id }}">
                <div class="mb-3">
                    <label for="name" class="form-label small">{{ trans('dash.label.element.name.pet') }}</label>
                    <input type="text" name="name" id="name" value="{{ $pet->name }}" class="form-control fc requerido">
                </div>

                <div class="mb-3">
                    <label for="animaltype" class="form-label small">{{ trans('dash.label.element.type.pet') }}</label>
                    <select name="animaltype" id="animaltype" class="form-select fc select4 requerido" data-pet-action="breed-change">
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
          <button id="agendarBtn" type="button" class="btn btn-primary btn-sm fw-medium px-4" data-pet-action="edit-submit">{{ trans('dash.text.btn.save') }}</button>
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
            <form method="post" id="formPhoto" name="formPhoto" enctype="multipart/form-data" method="post" action="{{ route('pets.savePhoto') }}">
                @csrf
                
                <input type="hidden" name="petIdImg" id="petIdImg" value="{{ $pet->id }}">
                <div>
                  <label for="profilePhoto" class="form-label small mb-1">{{ trans('dash.label.element.select.file') }}</label>
                  <input class="form-control" type="file" id="petPhoto" name="petPhoto" style="padding: .375rem .75rem;" accept="{{ App\Models\AppointmentAttachment::getExtensions(true) }}">
                </div>
            </form>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button type="button" class="btn btn-primary btn-sm px-4" data-pet-action="photo-submit">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @php
        $exts = explode(',', App\Models\AppointmentAttachment::getExtensions(true));
    @endphp
    <script>
        window.PET_DETAIL_CONFIG = {
            routes: {
                deletePet: "{{ route('pets.delete') }}",
                getAccess: "{{ route('pets.getAccess') }}",
                petsIndex: "{{ route('pets.index') }}"
            },
            labels: {
                extNotValid: "{{ trans('dash.msg.ext.not.valid') }}",
                selectImage: "{{ trans('dash.msg.select.image') }}",
                deleteTitle: "{{ trans('dash.msg.delete.pet') }}",
                deleteConfirm: "{{ trans('dash.msg.confir.delete.pet') }}",
                deleteYes: "{{ trans('dash.label.yes.delete') }}",
                deleteNo: "{{ trans('dash.label.no.cancel') }}",
                deleteError: "{{ trans('dash.msg.error.delete.pet') }}",
                accessTitle: "{{ trans('dash.msg.access.pet') }}",
                accessConfirm: "{{ trans('dash.msg.confir.access.pet') }}",
                accessYes: "{{ trans('dash.label.yes.access') }}",
                accessNo: "{{ trans('dash.label.no.cancel') }}",
                accessSuccessTitle: "{{ trans('dash.swal.msg.success') }}",
                accessSuccessText: "{{ trans('dash.swal.msg.access.complete') }}",
                accessErrorTitle: "{{ trans('dash.swal.msg.error') }}",
                accessErrorText: "{{ trans('dash.swal.msg.access.error') }}"
            },
            allowedExtensions: <?php echo json_encode($exts); ?>
        };
    </script>
@endpush
