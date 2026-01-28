<div class="modal fade" id="showRecipe" tabindex="-1" aria-labelledby="addRecipeShowLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.recipes') }}</h6>
                <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="card border-2 border-info-subtle docCol pushLeft mt-2 mb-3">
                    <div class="card-body p-2 p-md-3">
                        <table class="table mb-0 small align-middle rTable">
                            <thead>
                                <tr>
                                    <th class="text-primary-emphasis text-uppercase fw-medium"><small>{{ trans('dash.label.name') }}</small></th>
                                    <th class="text-primary-emphasis text-uppercase fw-medium"><small>{{ trans('dash.label.duration') }}</small></th>
                                    <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.take') }}</small></th>
                                    <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.quantity') }}</small></th>
                                    <th class="text-primary-emphasis text-uppercase fw-medium"><small>{{ trans('dash.label.notes') }}</small></th>
                                </tr>
                            </thead>
                            <tbody id="tbodyShowRecipe"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scriptBottom')
    <script>
        function setIdAppointmentToShow(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                }
            });

            setCharge();

            $('#tbodyShowRecipe').html('');
            
            $.post('{{ route('appoinment.getRecipeData') }}', {id:id, onlyDetail:true},
                function (data) {
                    $.each(data.recipe.detail, function(i, item) {
                        var txt = '<tr>'+
                                        '<td data-label="{{ trans('dash.label.name') }}:" class="fw-medium py-1 py-md-3">' + item.title + '</td>'+
                                        '<td data-label="{{ trans('dash.label.duration') }}:" class="py-1 py-md-3">' + item.duration + '</td>'+
                                        '<td data-label="{{ trans('dash.label.take') }}:" class="py-1 py-md-3 text-center">' + item.take + '</td>'+
                                        '<td data-label="{{ trans('dash.label.quantity') }}:" class="py-1 py-md-3 text-center">' + item.quantity + '</td>'+
                                        '<td data-label="{{ trans('dash.label.notes') }}:" class="py-1 py-md-3 d-flex"><span class="flex-1">' + item.instruction + '</span></td>'+
                                    '</tr>';
                        
                        $('#tbodyShowRecipe').append(txt);
                    });

                    hideCharge();
                }
            );
        }
    </script>
@endpush