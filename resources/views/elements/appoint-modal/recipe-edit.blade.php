<div class="modal fade" id="recipeModalEdit" tabindex="-1" aria-labelledby="recipeModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.recipes') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4 p-md-5">
          <form id="frmMedicineModalEdit" name="frmMedicineModalEdit" action="" method="post">
            @csrf
            <input type="hidden" id="medicineIdAppointmentEdit" name="medicineIdAppointmentEdit" value="0">
            <div id="printerRowsMedicinesEdit"></div>
            <a onclick="setRowMedicineEdit();" class="btn btn-outline-primary btn-sm px-4"><i class="fa-solid fa-plus me-2"></i>{{ trans('dash.label.add') }}</a>
          </form>
        </div>

        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0 gap-2">
          <button type="button" onclick="saveRecipeEdit();" class="btn btn-primary btn-sm px-4">{{ trans('dash.label.save.changes') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  var medicines;
  var typesRecipe;
  function setIdAppointmentToRecipeEdit(id) {
    $('#medicineIdAppointmentEdit').val(id);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
        }
    });

    setCharge();

    $('#printerRowsMedicinesEdit').html('');
    
    $.post('{{ route('appoinment.getRecipeData') }}', {id:id, get:true},
      function (data) {
        medicines = '<option value="" selected></option><option value="0" data-instruction="">{{ trans('dash.label.other') }}</option>';
        $.each(data.medicines, function(i, item) {
          medicines = medicines + '<option value="'+item.id+'" data-instruction="'+item.instructions+'">'+item.title+'</option>';
        });

        typesRecipe = '<option value="">{{ trans('dash.label.selected') }}</option>';
        $.each(data.types, function(i, item) {
          typesRecipe = typesRecipe + '<option value="'+item.id+'">'+item.title+'</option>';
        });

        $.each(data.recipe.detail, function(i, item) {
            setRowMedicineEdit(item.id, item.id_medicine, item.duration, item.id_take, item.quantity, item.instruction, item.title);
        });

        hideCharge();
      }
    );
  }

  function setRowMedicineEdit(id = 0, id_medicine = '', duration = '', id_take = 0, quantity = '', instruction = '', title = '') {
        
    if(id != 0) {
        var random = id;
    }else{
        var random = getRamdomEdit();
    }

    var btnDelete = '';
    btnDelete = '<button onclick="deleteRowMedicineEdit(this);" class="deleteR"><i class="fa-solid fa-xmark"></i></button>';

    var txt = '<div class="position-relative hr2 rounded p-3 mb-4 containerRowRecipe">'+
                btnDelete +
                '<div class="d-flex flex-column flex-xl-row gap-3 mb-3 justify-content-start">'+
                  '<i class="fa-solid fa-prescription-bottle fa-fw mt-0 mt-xl-1 text-primary"></i>'+
                  '<div class="flex-grow-1">'+
                    '<input type="hidden" name="medicineModalApId[]" id="medicineModalApId'+random+'" value="'+id+'">'+
                    '<label for="drugs" class="form-label small">{{ trans('dash.label.name') }}</label>'+
                    '<select class="form-select fc fsmall select3 requeridoModalMedicineEdit" id="medicineModalAp'+random+'" name="medicineModalAp[]" data-placeholder="Seleccionar" onchange="setInstructionEdit(this, \''+random+'\');">'+
                      medicines + 
                    '</select>'+
                  '</div>'+
                  '<div id="parentDiv' + random + '" style="display:none;">'+
                    '<label for="duration" class="form-label small">{{ trans('dash.label.other.drug') }}</label>'+
                    '<input type="text" class="form-control fc fsmall" maxlength="255" id="otherModalAp'+random+'" name="otherModalAp[]" onfocus="blur();">'+
                  '</div>'+
                  '<div>'+
                    '<label for="duration" class="form-label small">{{ trans('dash.label.duration') }}</label>'+
                    '<input type="text" class="form-control fc fsmall requeridoModalMedicineEdit" id="durationModalAp'+random+'" name="durationModalAp[]" value="'+duration+'" maxlength="255">'+
                  '</div>'+
                  '<div>'+
                    '<label for="take" class="form-label small">{{ trans('dash.label.take') }}</label>'+
                    '<select class="form-select fc fsmall requeridoModalMedicineEdit" aria-label="Tomar" id="takeModalAp'+random+'" name="takeModalAp[]">'+
                      typesRecipe +
                    '</select>'+
                  '</div>'+
                  '<div>'+
                    '<label for="quantity" class="form-label small">{{ trans('dash.label.quantity') }}</label>'+
                    '<input type="text" class="form-control fc fsmall requeridoModalMedicineEdit" size="7" id="quantityModalAp'+random+'" name="quantityModalAp[]" value="'+quantity+'" maxlength="255">'+
                  '</div>'+
                '</div>'+
                '<div class="d-flex flex-column flex-xl-row gap-3 mb-1 justify-content-start">'+
                  '<i class="fa-solid fa-prescription-bottle fa-fw mt-1 text-white d-none d-xl-block"></i>'+
                  '<div class="flex-grow-1">'+
                    '<label for="indications" class="form-label small">{{ trans('dash.label.adicional') }}</label>'+
                    '<textarea class="form-control fc fsmall requeridoModalMedicineEdit" id="indicationsModalAp'+random+'" name="indicationsModalAp[]" rows="1">'+instruction+'</textarea>'+
                  '</div>'+
                '</div>'+
              '</div>';

      $('#printerRowsMedicinesEdit').append(txt);

      if(($.isNumeric(id_medicine)) && (id_medicine == 0)) {
        $("#medicineModalAp" + random).val(0).trigger('change');
        $('#otherModalAp' + random).attr('onfocus', '');
        $('#otherModalAp' + random).addClass('requeridoModalMedicineEdit');
        $('#otherModalAp' + random).val(title);
      }else if(($.isNumeric(id_medicine)) && (id_medicine > 0)) {
        $("#medicineModalAp" + random).val(id_medicine).trigger('change');
        $('#otherModalAp' + random).val('');
        $('#otherModalAp' + random).attr('onfocus', 'blur();');
        $('#otherModalAp' + random).removeClass('requeridoModalMedicineEdit');
      }
      
      $('#indicationsModalAp' + random).val(instruction);

      if(id_take != 0) {
        $("#takeModalAp" + random).val(id_take).change();
      }

      $('#medicineModalAp'+random).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#recipeModalEdit')
      });
  }

  function setInstructionEdit(obj, identifier) {
    var element = $(obj).find('option:selected'); 
    var myTag = element.attr("data-instruction");
    var value = $(element).val();
    
    if(value == '0') {
      $('#otherModalAp' + identifier).attr('onfocus', '');
      $('#otherModalAp' + identifier).addClass('requeridoModalMedicineEdit');
      $('#parentDiv' + identifier).show();
    }else{
      $('#otherModalAp' + identifier).val('');
      $('#otherModalAp' + identifier).attr('onfocus', 'blur();');
      $('#otherModalAp' + identifier).removeClass('requeridoModalMedicineEdit');
      $('#otherModalAp' + identifier).removeClass('is-invalid');
      $('#parentDiv' + identifier).hide();
    }

    $('#indicationsModalAp' + identifier).val(myTag);
  }

  function deleteRowMedicineEdit(obj) {
    $(obj).parent('div').remove();
  }

  function saveRecipeEdit() {
    var valid = true;

    $('.requeridoModalMedicineEdit').each(function(i, elem){
        var value = $(elem).val();
        var value = value.trim();
        if(value == ''){
            $(elem).addClass('is-invalid');
            valid = false;
        }else{
            $(elem).removeClass('is-invalid');
        }
    });

    var count = document.getElementsByClassName('containerRowRecipe').length;
    if(count == 0) {
        $.toast({
            text: '{{ trans('dash.label.add.require.medicine') }}',
            position: 'bottom-right',
            textAlign: 'center',
            loader: false,
            hideAfter: 4000,
            icon: 'warning'
        });
        valid = false;
    }

    if(valid == true) {

      setCharge();

      $.ajax({
          url: '{{ route('appoinment.updateRecipe') }}',
          type: 'POST',
          data: new FormData(document.getElementById('frmMedicineModalEdit')),
          contentType: false,
          cache: false,
          processData: false,
          success: function(data, status, xhr) {  
            if(data.save == 1) {
              location.reload();
            }else{
              $.toast({
                text: '{{ trans('dash.label.error.add.recipe') }}',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'error'
              });
            }

            hideCharge();
          },
          error: function(xhr, status, error) {
            $.toast({
                text: '{{ trans('dash.label.error.add.recipe') }}',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'error'
            });

            hideCharge();
          }
        });

      }
  }

  function getRamdomEdit() {
    var random = Math.random();
    random = random + "";
    random = random.replace(".", "");
    random = random.replaceAll(/0/g, "1");

    return random;
  }
</script>
@endpush