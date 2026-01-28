<div class="modal fade" id="recipeModalToAdd" tabindex="-1" aria-labelledby="recipeModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.recipes') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4 p-md-5">
            <div id="printerRowsMedicinesAdd">
              <div class="position-relative hr2 rounded p-3 mb-4" id="medicineNotRow">
                <div class="d-flex flex-column flex-xl-row gap-3 mb-3 justify-content-start">
                    <label for="drugs" class="form-label small">{{ trans('dash.label.not.add.drugs') }}</label>
                </div>
              </div>
            </div>
            <a onclick="setRowMedicineAdd();" class="btn btn-outline-primary btn-sm px-4"><i class="fa-solid fa-plus me-2"></i>{{ trans('dash.label.add') }}</a>
        </div>

        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0 gap-2">
          <button type="button" onclick="saveRecipeAdd();" class="btn btn-primary btn-sm px-4">{{ trans('dash.label.btn.continue') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  function setRowMedicineAdd() {
    $('#medicineNotRow').hide();

    var random = getRamdomAdd();
    
    var btnDelete = '';
    btnDelete = '<a onclick="deleteRowMedicineAdd(this);" class="deleteR"><i class="fa-solid fa-xmark"></i></a>';
    
    var txt = '<div class="position-relative hr2 rounded p-3 mb-4 rowAddmedic">'+
                btnDelete +
                '<div class="d-flex flex-column flex-xl-row gap-3 mb-3 justify-content-start">'+
                  '<i class="fa-solid fa-prescription-bottle fa-fw mt-0 mt-xl-1 text-primary"></i>'+
                  '<div class="flex-grow-1">'+
                    '<label for="drugs" class="form-label small">{{ trans('dash.label.name') }}</label>'+
                    '<select class="form-select fc fsmall select3 requeridoModalMedicineAdd" id="medicineModalAp'+random+'" name="medicineModalAp[]" data-placeholder="Seleccionar" onchange="setInstructionAdd(this, \''+random+'\');">'+
                      medicines + 
                    '</select>'+
                  '</div>'+
                  '<div>'+
                    '<label for="duration" class="form-label small">Otro medicamento</label>'+
                    '<input type="text" class="form-control fc fsmall" maxlength="255">'+
                  '</div>'+
                  '<div>'+
                    '<label for="duration" class="form-label small">{{ trans('dash.label.duration') }}</label>'+
                    '<input type="text" class="form-control fc fsmall requeridoModalMedicineAdd" id="durationModalAp'+random+'" name="durationModalAp[]" maxlength="255">'+
                  '</div>'+
                  '<div>'+
                    '<label for="take" class="form-label small">{{ trans('dash.label.take') }}</label>'+
                    '<select class="form-select fc fsmall requeridoModalMedicineAdd" aria-label="Tomar" id="takeModalAp'+random+'" name="takeModalAp[]">'+
                      typesRecipe +
                    '</select>'+
                  '</div>'+
                  '<div>'+
                    '<label for="quantity" class="form-label small">{{ trans('dash.label.quantity') }}</label>'+
                    '<input type="text" class="form-control fc fsmall requeridoModalMedicineAdd" size="7" id="quantityModalAp'+random+'" name="quantityModalAp[]" maxlength="255">'+
                  '</div>'+
                '</div>'+
                '<div class="d-flex flex-column flex-xl-row gap-3 mb-1 justify-content-start">'+
                  '<i class="fa-solid fa-prescription-bottle fa-fw mt-1 text-white d-none d-xl-block"></i>'+
                  '<div class="flex-grow-1">'+
                    '<label for="indications" class="form-label small">{{ trans('dash.label.adicional') }}</label>'+
                    '<textarea class="form-control fc fsmall requeridoModalMedicineAdd" id="indicationsModalAp'+random+'" name="indicationsModalAp[]" rows="1"></textarea>'+
                  '</div>'+
                '</div>'+
              '</div>';

      $('#printerRowsMedicinesAdd').append(txt);

      $('#medicineModalAp'+random).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' )
      });
  }

  function setInstructionAdd(obj, identifier) {
    var element = $(obj).find('option:selected'); 
    var myTag = element.attr("data-instruction");

    $('#indicationsModalAp' + identifier).val(myTag);
  }

  function deleteRowMedicineAdd(obj) {
    $(obj).parent('div').remove();

    var count = document.getElementsByClassName('rowAddmedic').length;
    if(count == 0) {
      $('#medicineNotRow').show();
    }
  }

  function saveRecipeAdd() {
    var valid = true;

    $('.requeridoModalMedicineAdd').each(function(i, elem){
        var value = $(elem).val();
        var value = value.trim();
        if(value == ''){
            $(elem).addClass('is-invalid');
            valid = false;
        }else{
            $(elem).removeClass('is-invalid');
        }
    });

    if(valid == true) {
      $('#recipeModalToAdd').modal('hide');
    }
  }

  function getRamdomAdd() {
    var random = Math.random();
    random = random + "";
    random = random.replace(".", "");
    random = random.replaceAll(/0/g, "1");

    return random;
  }
</script>
@endpush