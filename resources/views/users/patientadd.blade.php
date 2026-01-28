@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@php $weblang = \App::getLocale(); @endphp

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        
        <form class="col-xl-9 mx-auto mt-4 mt-lg-0 mb-lg-5" id="frmProfile" name="frmProfile" method="post" action="{{ route('adminpatient.store') }}" onsubmit="return validSend();">
            <h1 class="text-center text-md-start text-uppercase h4 fw-normal mb-3">
                <a href="{{ route('adminpatient.index') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                {{ trans('dashadmin.label.title.add') }} <span class="text-info fw-bold">{{ trans('dashadmin.label.title.patient') }}</span>
            </h1>

            @csrf

            <div class="row g-xl-5">
                <div class="col-md-3">
                    <div class="mb-4">
                        <label for="dname" class="form-label small">{{ trans('auth.register.complete.namepet') }}</label>
                        <input type="text" class="form-control fc requerido" id="dname" name="dname">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-4">
                        <label for="dname" class="form-label small">{{ trans('auth.register.complete.type') }}</label>
                        <select class="form-select fc select2 requerido" id="type" name="type" onchange="getBreed(this);">
                            <option value="">{{ trans('auth.register.complete.select') }}</option>
                            @foreach ($animalTypes as $type)
                                <option value="{{ $type->id }}">{{ $type['title_' . $weblang] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-4">
                        <label for="dname" class="form-label small">{{ trans('auth.register.complete.breed') }}</label>
                        <select class="form-select fc select2 requerido" name="breed" id="breed">
                            <option value="">{{ trans('auth.register.complete.select') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-4">
                        <label for="canton" class="form-label small">{{ trans('dash.label.owner') }}</label>
                        <select class="form-select fc select2 requerido" name="owner" id="owner">
                            <option value="">{{ trans('auth.register.complete.select') }}</option>
                            @foreach ($owners as $owner)
                                <option value="{{ $owner->id }}">{{ $owner->name }}</option>    
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-5">{{ trans('dashadmin.label.inventory.save') }}</button>
        </form>

    </div>
</section>

@include('elements.footer')

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.select2').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    });

    function getBreed(obj) {
        var type = $('#type').val();

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

    function validSend() {
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
            setCharge();
        }

        return validate;
    }
</script>
@endpush