@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">

        <form class="col-xl-7 mx-auto mt-4 mt-lg-0 mb-lg-5" id="frmMedicine" name="frmMedicine" method="post" action="{{ route('inventory.previewXml') }}" enctype="multipart/form-data" onsubmit="return validSend();">
            @csrf

            <h1 class="text-center text-md-start text-uppercase h4 fw-normal mb-3">
                <a href="{{ route('inventory.index') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                {{ trans('dashadmin.label.title.add') }} <span class="text-info fw-bold">{{ trans('dashadmin.label.title.product') }}</span>
            </h1>
            <div class="row gx-3">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="xml_file" class="form-label small">{{ trans('dashadmin.label.file') }}</label>
                        <input type="file" class="form-control fc requerido" id="xml_file" name="xml_file" accept=".xml">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary px-5">{{ trans('dashadmin.label.inventory.updatexml') }}</button>
        </form>

    </div>
</section>

@include('elements.footer')

@endsection

@push('scriptBottom')
<script>
    function validSend() {
        var validate = true;

        $('.requerido').each(function(i, elem) {
            var value = $(elem).val();
            var value = value.trim();
            if (value == '') {
                $(elem).addClass('is-invalid');
                validate = false;
            } else {
                $(elem).removeClass('is-invalid');
            }
        });

        if (validate == true) {
            setCharge();
        }

        return validate;
    }
</script>
@endpush