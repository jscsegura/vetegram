<div class="modal fade" id="recipeModal" tabindex="-1" aria-labelledby="recipeModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.recipes') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4 p-md-5">
          <form id="frmMedicineModal" name="frmMedicineModal" action="" method="post">
            @csrf
            <input type="hidden" id="medicineIdAppointment" name="medicineIdAppointment" value="0">
            <input type="hidden" name="medicineIdPetAppointment" id="medicineIdPetAppointment" value="0">
            <div id="printerRowsMedicines"></div>
            <a onclick="setRowMedicine(true);" class="btn btn-outline-primary btn-sm px-4"><i class="fa-solid fa-plus me-2"></i>{{ trans('dash.label.add') }}</a>
          </form>
        </div>

        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0 gap-2">
          <button type="button" onclick="saveRecipe();" class="btn btn-primary btn-sm px-4">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  var medicines;
  var typesRecipe;
  function setIdAppointmentToMedicine(id, pet = 0) {
    $('#medicineIdAppointment').val(id);
    $('#medicineIdPetAppointment').val(pet);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
        }
    });

    setCharge();

    $('#printerRowsMedicines').html('');
    
    $.post('{{ route('appoinment.getRecipeData') }}', {},
      function (data) {
        medicines = '<option value=""></option><option value="0" data-instruction="">{{ trans('dash.label.other') }}</option>';
        $.each(data.medicines, function(i, item) {
          medicines = medicines + '<option value="'+item.id+'" data-instruction="'+item.instructions+'">'+item.title+'</option>';
        });

        typesRecipe = '<option value="">{{ trans('dash.label.selected') }}</option>';
        $.each(data.types, function(i, item) {
          typesRecipe = typesRecipe + '<option value="'+item.id+'">'+item.title+'</option>';
        });

        setRowMedicine(false);

        hideCharge();
      }
    );
  }

  function setRowMedicine(showdelete) {
    var random = getRamdom();
    
    var btnDelete = '';
    if(showdelete == true) {
      btnDelete = '<button onclick="deleteRowMedicine(this);" class="deleteR"><i class="fa-solid fa-xmark"></i></button>';
    }

    var txt = '<div class="position-relative hr2 rounded p-3 mb-4">'+
                btnDelete +
                '<div class="d-flex flex-column flex-xl-row gap-3 mb-3 justify-content-start">'+
                  '<i class="fa-solid fa-prescription-bottle fa-fw mt-0 mt-xl-1 text-primary"></i>'+
                  '<div class="flex-grow-1">'+
                    '<label for="drugs" class="form-label small">{{ trans('dash.label.name') }}</label>'+
                    '<select class="form-select fc fsmall select3 requeridoModalMedicine" id="medicineModalAp'+random+'" name="medicineModalAp[]" data-placeholder="Seleccionar" onchange="setInstruction(this, \''+random+'\');">'+
                      medicines +
                    '</select>'+
                  '</div>'+
                  '<div id="parentDiv' + random + '" style="display:none;">'+
                    '<label for="duration" class="form-label small">{{ trans('dash.label.other.drug') }}</label>'+
                    '<input type="text" class="form-control fc fsmall" maxlength="255" id="otherModalAp'+random+'" name="otherModalAp[]" onfocus="blur();">'+
                  '</div>'+
                  '<div>'+
                    '<label for="duration" class="form-label small">{{ trans('dash.label.duration') }}</label>'+
                    '<input type="text" class="form-control fc fsmall requeridoModalMedicine" id="durationModalAp'+random+'" name="durationModalAp[]" maxlength="255">'+
                  '</div>'+
                  '<div>'+
                    '<label for="take" class="form-label small">{{ trans('dash.label.take') }}</label>'+
                    '<select class="form-select fc fsmall requeridoModalMedicine" aria-label="Tomar" id="takeModalAp'+random+'" name="takeModalAp[]">'+
                      typesRecipe +
                    '</select>'+
                  '</div>'+
                  '<div>'+
                    '<label for="quantity" class="form-label small">{{ trans('dash.label.quantity') }}</label>'+
                    '<input type="text" class="form-control fc fsmall requeridoModalMedicine" size="7" id="quantityModalAp'+random+'" name="quantityModalAp[]" maxlength="255">'+
                  '</div>'+
                '</div>'+
                '<div class="d-flex flex-column flex-xl-row gap-3 mb-1 justify-content-start">'+
                  '<i class="fa-solid fa-prescription-bottle fa-fw mt-1 text-white d-none d-xl-block"></i>'+
                  '<div class="flex-grow-1">'+
                    '<label for="indications" class="form-label small">{{ trans('dash.label.adicional') }}</label>'+
                    '<textarea class="form-control fc fsmall requeridoModalMedicine" id="indicationsModalAp'+random+'" name="indicationsModalAp[]" rows="1"></textarea>'+
                  '</div>'+
                '</div>'+
              '</div>';

      $('#printerRowsMedicines').append(txt);

      $('#medicineModalAp'+random).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#recipeModal')
      });
  }

  function setInstruction(obj, identifier) {
    var element = $(obj).find('option:selected'); 
    var myTag = element.attr("data-instruction");
    var value = $(element).val();

    if(value == '0') {
      $('#otherModalAp' + identifier).attr('onfocus', '');
      $('#otherModalAp' + identifier).addClass('requeridoModalMedicine');
      $('#parentDiv' + identifier).show();
    }else{
      $('#otherModalAp' + identifier).val('');
      $('#otherModalAp' + identifier).attr('onfocus', 'blur();');
      $('#otherModalAp' + identifier).removeClass('requeridoModalMedicine');
      $('#otherModalAp' + identifier).removeClass('is-invalid');
      $('#parentDiv' + identifier).hide();
    }

    $('#indicationsModalAp' + identifier).val(myTag);
  }

  function deleteRowMedicine(obj) {
    $(obj).parent('div').remove();
  }

  function saveRecipe() {
    var valid = true;

    $('.requeridoModalMedicine').each(function(i, elem){
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

      setCharge();

      $.ajax({
          url: '{{ route('appoinment.saveRecipe') }}',
          type: 'POST',
          data: new FormData(document.getElementById('frmMedicineModal')),
          contentType: false,
          cache: false,
          processData: false,
          success: function(data, status, xhr) {  
            if(data.save == 1) {
              $('#printerRowsMedicines').html('');

              setRowMedicine(false);

              $.toast({
                  text: '{{ trans('dash.label.recipe.add.success') }}',
                  position: 'bottom-right',
                  textAlign: 'center',
                  loader: false,
                  hideAfter: 4000,
                  icon: 'success'
              });

              if (typeof reloadToComplete !== 'undefined') {
                location.reload();
              }
            }else{
              $.toast({
                text: '{{ trans('dash.label.recipe.add.error') }}',
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
                text: '{{ trans('dash.label.recipe.add.error') }}',
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

  function getRamdom() {
    var random = Math.random();
    random = random + "";
    random = random.replace(".", "");
    random = random.replaceAll(/0/g, "1");

    return random;
  }
</script>
@endpush