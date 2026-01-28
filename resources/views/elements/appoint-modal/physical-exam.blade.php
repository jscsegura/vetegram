@if((isset($physicalComplete)) && ($physicalComplete == true))
<div class="modal fade" id="physicalExam" tabindex="-1" aria-labelledby="physicalExamLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.exam.physical') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-lg-4 p-xl-5">
            <div class="row g-3">
                <div class="col-12 col-xl-5 phyWrap">
                    <ul class="phyBtn row row-cols-2 row-cols-lg-4 row-cols-xl-2 g-3 pb-3 pb-xl-0 pe-xl-4 mb-0" role="tablist">
                        @php $counter = 0; @endphp
                        @foreach ($categories as $category)
                            @if(in_array($category->id, $rowCategories))
                                <li class="col">
                                    <button type="button" class="p-2 lh-sm w-100 h-100 text-break {{ ($counter == 0) ? 'active' : '' }}" data-bs-target="#pTab{{ $category->id }}" data-bs-toggle="pill">{{ $category['title_' . $weblang] }}</button>
                                </li>
                                @php $counter++; @endphp
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="col-12 col-xl-7 ps-xl-4">
                    <form action="">
                        <div class="tab-content" id="physicalTab">

                            @php 
                                $counter = 0; $rowInitial = [];
                                if($appointment->physical != '') {
                                    $physicalInitial = json_decode($appointment->physical, true); 
                                    foreach ($physicalInitial as $value) {
                                        $rowInitial[$value['idopt']] = ["idopt" => $value['idopt'], "opt" => $value['opt'], "idsubopt" => $value['idsubopt'], "subopt" => $value['subopt'], "value" => $value['value']];
                                    }
                                }
                            @endphp
                            @foreach ($categories as $category)
                                @if(in_array($category->id, $rowCategories))
                                <div class="tab-pane fade show {{ ($counter == 0) ? 'active' : '' }}"  id="pTab{{ $category->id }}" role="tabpanel">
                                    <h2 class="h4 text-uppercase text-primary fw-medium mb-3">{{ $category['title_' . $weblang] }}</h2>
                                    <div class="row row-cols-2">
                                        @foreach ($category['options'] as $options)
                                            @if(in_array($options['id'], $rowOptions))
                                                @php $suboptions = App\Models\PhysicalSuboption::getSubOptions($options->id) @endphp

                                                @if(count($suboptions) > 0)
                                                    <div class="col">
                                                        <label class="form-label small">{{ $options['title_' . $weblang] }}</label>
                                                        @foreach ($suboptions as $sub)
                                                            @switch($options['type'])
                                                                @case(1)
                                                                    <div class="mb-3">
                                                                        <label for="sub{{ $sub->id }}" class="form-label small">{{ $sub['title_' . $weblang] }}</label>
                                                                        <input type="text" id="sub{{ $sub->id }}" name="sub{{ $sub->id }}" class="form-control fc inputPhysical" value="{{ (isset($rowInitial[$options['id']]['value'])) ? $rowInitial[$options['id']]['value'] : '' }}" id-cat="{{ $category->id }}" id-opt="{{ $options->id }}" id-subopt="{{ $sub->id }}" data-cat="{{ $category['title_' . $weblang] }}" data-opt="{{ $options['title_' . $weblang] }}" data-subopt="{{ $sub['title_' . $weblang] }}">
                                                                    </div>
                                                                    @break
                                                                @case(2)
                                                                    <div class="mb-3">
                                                                        <label for="sub{{ $sub->id }}" class="form-label small">{{ $sub['title_' . $weblang] }}</label>
                                                                        <input type="number" id="sub{{ $sub->id }}" name="sub{{ $sub->id }}" class="form-control fc inputPhysical" value="{{ (isset($rowInitial[$options['id']]['value'])) ? $rowInitial[$options['id']]['value'] : '' }}" id-cat="{{ $category->id }}" id-opt="{{ $options->id }}" id-subopt="{{ $sub->id }}" data-cat="{{ $category['title_' . $weblang] }}" data-opt="{{ $options['title_' . $weblang] }}" data-subopt="{{ $sub['title_' . $weblang] }}">
                                                                    </div>
                                                                    @break
                                                                @case(3)
                                                                    <div class="form-check py-1">
                                                                        <input class="form-check-input inputPhysical" type="radio" name="sub{{ $options->id }}" id="sub{{ $sub->id }}" value="{{ $sub->id }}" @if((isset($rowInitial[$options['id']]['idsubopt'])) && ($sub->id == $rowInitial[$options['id']]['idsubopt'])) checked @endif id-cat="{{ $category->id }}" id-opt="{{ $options->id }}" id-subopt="{{ $sub->id }}" data-cat="{{ $category['title_' . $weblang] }}" data-opt="{{ $options['title_' . $weblang] }}" data-subopt="{{ $sub['title_' . $weblang] }}">
                                                                        <label class="form-check-label" for="sub{{ $sub->id }}">
                                                                            {{ $sub['title_' . $weblang] }}
                                                                        </label>
                                                                    </div>
                                                                    @break
                                                                @default
                                                            @endswitch
                                                        @endforeach
                                                    </div>
                                                @else
                                                    @switch($options['type'])
                                                        @case(1)
                                                            <div class="col">
                                                                <div class="mb-3">
                                                                    <label for="opt{{ $options->id }}" class="form-label small">{{ $options['title_' . $weblang] }}</label>
                                                                    <input type="text" id="opt{{ $options->id }}" name="opt{{ $options->id }}" class="form-control fc inputPhysical" value="{{ (isset($rowInitial[$options['id']]['value'])) ? $rowInitial[$options['id']]['value'] : '' }}" id-cat="{{ $category->id }}" id-opt="{{ $options->id }}" id-subopt="" data-cat="{{ $category['title_' . $weblang] }}" data-opt="{{ $options['title_' . $weblang] }}" data-subopt="">
                                                                </div>
                                                            </div>
                                                            @break
                                                        @case(2)
                                                            <div class="col">
                                                                <div class="mb-3">
                                                                    <label for="opt{{ $options->id }}" class="form-label small">{{ $options['title_' . $weblang] }}</label>
                                                                    <input type="number" id="opt{{ $options->id }}" name="opt{{ $options->id }}" class="form-control fc inputPhysical" value="{{ (isset($rowInitial[$options['id']]['value'])) ? $rowInitial[$options['id']]['value'] : '' }}" id-cat="{{ $category->id }}" id-opt="{{ $options->id }}" id-subopt="" data-cat="{{ $category['title_' . $weblang] }}" data-opt="{{ $options['title_' . $weblang] }}" data-subopt="">
                                                                </div>
                                                            </div>
                                                            @break
                                                        @case(3)
                                                            <div class="col">
                                                                <div class="form-check py-1">
                                                                    <input class="form-check-input inputPhysical" type="radio" name="opt{{ $category->id }}" id="opt{{ $options->id }}" value="{{ $options->id }}" @if((isset($rowInitial[$options['id']]['idopt'])) && ($options->id == $rowInitial[$options['id']]['idopt'])) checked @endif id-cat="{{ $category->id }}" id-opt="{{ $options->id }}" id-subopt="" data-cat="{{ $category['title_' . $weblang] }}" data-opt="{{ $options['title_' . $weblang] }}" data-subopt="">
                                                                    <label class="form-check-label" for="opt{{ $options->id }}">
                                                                        {{ $options['title_' . $weblang] }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @break
                                                        @default
                                                    @endswitch
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                @php $counter++; @endphp
                                @endif
                            @endforeach

                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0 gap-2">
          <button type="button" class="btn btn-primary btn-sm px-4" data-bs-dismiss="modal">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>
@endif

@push('scriptBottom')
<script>
    function printerInitialPhysical () {
        @if($appointment->physical != '')
        var physicalInitial = <?php echo $appointment->physical; ?>;
        @else
        var physicalInitial = [];
        @endif

        $('#printerPhysicalOptions').html('');
        
        var totalAdd = 0;
        var arrayOfArrays = [];

        $(physicalInitial).each(function(i, elem){
            var row = '';
            if(elem.subopt != '') {
                if(elem.value != '') {
                    row = '<div class="cyanBg py-2 px-3 rounded">'+elem.cat+' <i class="fa-solid fa-arrow-right-long small mx-1"></i>  '+elem.opt+' <i class="fa-solid fa-arrow-right-long small mx-1"></i> '+elem.subopt+': <strong>'+elem.value+'</strong></div>';
                }else{
                    row = '<div class="cyanBg py-2 px-3 rounded">'+elem.cat+' <i class="fa-solid fa-arrow-right-long small mx-1"></i>  '+elem.opt+': <strong>'+elem.subopt+'</strong></div>';
                }
            }else{
                if(elem.value != '') {
                    row = '<div class="cyanBg py-2 px-3 rounded">'+elem.cat+' <i class="fa-solid fa-arrow-right-long small mx-1"></i> '+elem.opt+': <strong>'+elem.value+'</strong></div>';
                }else{
                    row = '<div class="cyanBg py-2 px-3 rounded">'+elem.cat+' <i class="fa-solid fa-arrow-right-long small mx-1"></i> <strong>'+elem.opt+'</strong></div>';
                }
            }

            if(row != '') {
                $('#printerPhysicalOptions').append(row);
                totalAdd++;

                var groupArray = {'idcat':elem.idcat, 'cat':elem.cat, 'idopt':elem.idopt, 'opt':elem.opt, 'idsubopt':elem.idsubopt, 'subopt':elem.subopt, 'value': elem.value};
                arrayOfArrays.push(groupArray);
            }
        });

        if(totalAdd > 0) {
            @if((isset($physicalComplete)) && ($physicalComplete == true))
            $('#printerPhysicalOptions').append('<button type="button" class="editR4" data-bs-toggle="modal" data-bs-target="#physicalExam"><i class="fa-solid fa-pencil"></i></button>');
            @endif
            $('#physicalExamButton').hide();
            $('#printerPhysicalOptions').show();
        }else{
            @if((isset($physicalComplete)) && ($physicalComplete == true))
            $('#physicalExamButton').show();
            @endif
            $('#printerPhysicalOptions').hide();
        }

        $('#physicalExamData').val(JSON.stringify(arrayOfArrays));

    }
    printerInitialPhysical();

    $(document).ready(function () {
        $('#physicalExam').on('hidden.bs.modal', function () {
            var totalAdd = 0;

            $('#printerPhysicalOptions').html('');

            var arrayOfArrays = [];
            
            $('.inputPhysical').each(function(i, elem){
                var type = $(elem).attr('type');

                var value = '';

                var row = '';

                var category  = $(elem).attr('data-cat');
                var option    = $(elem).attr('data-opt');
                var suboption = $(elem).attr('data-subopt');
                
                var idcategory  = $(elem).attr('id-cat');
                var idoption    = $(elem).attr('id-opt');
                var idsuboption = $(elem).attr('id-subopt');
                
                switch(type){
                    case 'text':
                        if($(elem).val() != '') {
                            value = $(elem).val();

                            if(suboption != '') {
                                row = '<div class="cyanBg py-2 px-3 rounded">'+category+' <i class="fa-solid fa-arrow-right-long small mx-1"></i>  '+option+' <i class="fa-solid fa-arrow-right-long small mx-1"></i> '+suboption+': <strong>'+value+'</strong></div>';
                            }else{
                                row = '<div class="cyanBg py-2 px-3 rounded">'+category+' <i class="fa-solid fa-arrow-right-long small mx-1"></i> '+option+': <strong>'+value+'</strong></div>';
                            }
                        }
                        break;
                    case 'number':
                        if($(elem).val() != '') {
                            value = $(elem).val();

                            if(suboption != '') {
                                row = '<div class="cyanBg py-2 px-3 rounded">'+category+' <i class="fa-solid fa-arrow-right-long small mx-1"></i>  '+option+' <i class="fa-solid fa-arrow-right-long small mx-1"></i> '+suboption+': <strong>'+value+'</strong></div>';
                            }else{
                                row = '<div class="cyanBg py-2 px-3 rounded">'+category+' <i class="fa-solid fa-arrow-right-long small mx-1"></i> '+option+': <strong>'+value+'</strong></div>';
                            }
                        }
                        break;
                    case 'radio':
                        if ($(elem).is(':checked')) {
                            if(suboption != '') {
                                row = '<div class="cyanBg py-2 px-3 rounded">'+category+' <i class="fa-solid fa-arrow-right-long small mx-1"></i>  '+option+': <strong>'+suboption+'</strong></div>';
                            }else{
                                row = '<div class="cyanBg py-2 px-3 rounded">'+category+' <i class="fa-solid fa-arrow-right-long small mx-1"></i> <strong>'+option+'</strong></div>';
                            }
                        }
                        break;
                }

                if(row != '') {
                    $('#printerPhysicalOptions').append(row);
                    totalAdd++;

                    var groupArray = {'idcat':idcategory, 'cat':category, 'idopt':idoption, 'opt':option, 'idsubopt':idsuboption, 'subopt':suboption, 'value': value};
                    arrayOfArrays.push(groupArray);
                }
            });

            if(totalAdd > 0) {
                $('#printerPhysicalOptions').append('<button type="button" class="editR4" data-bs-toggle="modal" data-bs-target="#physicalExam"><i class="fa-solid fa-pencil"></i></button>');
                $('#physicalExamButton').hide();
                $('#printerPhysicalOptions').show();
            }else{
                $('#physicalExamButton').show();
                $('#printerPhysicalOptions').hide();
            }

            $('#physicalExamData').val(JSON.stringify(arrayOfArrays));

            updateRecipe();
        });
    });
</script>
@endpush