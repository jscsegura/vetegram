@if((isset($Modalreminder))&&($Modalreminder == true))
@include('elements.appoint-modal.reminder')
@endif

@if((isset($Modalrecipe))&&($Modalrecipe == true))
@include('elements.appoint-modal.recipe')
@endif

@if((isset($ModalrecipeToAdd))&&($ModalrecipeToAdd == true))
@include('elements.appoint-modal.recipe-add')
@endif

@if((isset($ModalrecipeEdit))&&($ModalrecipeEdit == true))
@include('elements.appoint-modal.recipe-edit')
@endif

@if((isset($Modalattach))&&($Modalattach == true))
@include('elements.appoint-modal.attach')
@endif

@if((isset($Modalnote))&&($Modalnote == true))
@include('elements.appoint-modal.notes')
@endif

@if((isset($ModalsendRecipe))&&($ModalsendRecipe == true))
@include('elements.appoint-modal.send-recipe')
@endif

@if((isset($Modalcancel))&&($Modalcancel == true))
@include('elements.appoint-modal.cancel')
@endif

@if((isset($ModalOnlycancel))&&($ModalOnlycancel == true))
@include('elements.appoint-modal.only-cancel')
@endif

@if((isset($ModalOnlyReschedule))&&($ModalOnlyReschedule == true))
@include('elements.appoint-modal.only-reschedule')
@endif

@if((isset($ModalSearchUser))&&($ModalSearchUser == true))
@include('elements.appoint-modal.search-user')
@endif

@if((isset($ModalCreatePet))&&($ModalCreatePet == true))
@include('elements.appoint-modal.create-pet')
@endif

@if((isset($ModalCreateUser))&&($ModalCreateUser == true))
@include('elements.appoint-modal.create-user')
@endif

@if((isset($ModalAddVaccine))&&($ModalAddVaccine == true))
@include('elements.appoint-modal.add-vaccine')
@endif

@if((isset($ModalAddDesparat))&&($ModalAddDesparat == true))
@include('elements.appoint-modal.add-desparat')
@endif

@if((isset($ModalExternalAddVaccine))&&($ModalExternalAddVaccine == true))
@include('elements.appoint-modal.add-external-vaccine')
@endif

@if((isset($ModalShowRecipe))&&($ModalShowRecipe == true))
@include('elements.appoint-modal.show-recipe')
@endif

@if((isset($grooming))&&($grooming == true))
@include('elements.appoint-modal.grooming')
@endif

@if((isset($ModalsendAttach))&&($ModalsendAttach == true))
@include('elements.appoint-modal.send-attach')
@endif

@if((isset($PhysicalExam))&&($PhysicalExam == true))
@include('elements.appoint-modal.physical-exam')
@endif

@push('scriptBottom')
<script>
  window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
  window.APPOINT_MODAL_CONFIG.assetsBase = "{{ rtrim(asset('js/appointments/modals/'), '/') }}/";
</script>
<script src="{{ asset('js/appointments/modals/index.js') }}"></script>
@endpush
