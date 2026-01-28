@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    @php $weblang = \App::getLocale(); @endphp

    @include('elements.ownermenu')

    <section class="container-fluid pb-0 pb-lg-4 px-xl-5">
        <div class="row px-0 px-lg-3">
            <div id="vBanner" class="card bg-info-subtle border-0 mb-4 p-0 p-md-3">
                <div class="card-body p-4 p-lg-5">
                    <h1 class="text-center text-uppercase mb-3">{{ trans('dash.label.find') }} <span class="text-primary">{{ trans('dash.label.vets') }}</span></h1>
                    <form class="col-12 col-lg-7 mx-auto">
                        <div class="d-flex flex-column flex-sm-row gap-2 gap-md-3">
                            <div class="flex-grow-1">
                                <input type="text" name="criteria" id="magicSearch" class="form-control fw-normal" placeholder="Veterinaria, nombre doctor" autocomplete="off">
                            </div>
                            <div>
                                <button onclick="search();" class="btn btn-primary px-3 px-lg-4 w-100" type="button">{{ trans('dash.menu.search') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
        @if($criterio != '')
            <p class="fs-3 text-uppercase fw-normal mb-0 mt-1 text-center">{{ trans('dash.label.results') }}</p>
        @else
            @if($resultIs == 'doctor')
            @else
                <p class="fs-3 text-uppercase fw-normal mb-0 mt-1 text-center">{{ trans('dash.label.vets.suggested') }}</p>
            @endif
        @endif

        @if($resultIs == 'vets')
            @if(count($vets) > 0)
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 p-0 m-0 g-3 mb-lg-5">
                    @foreach ($vets as $vet)
                        @php $photo = asset('img/vet.png'); @endphp
                        <div class="col">
                            <div class="card rounded-3 border-2 border-secondary h-100">
                                <div class="card-body p-xl-4">
                                    <div class="d-flex flex-column flex-md-row align-items-center gap-2 gap-md-3">
                                        <div>
                                            <div class="vetPhoto rounded-circle mx-auto" style="background-image: url({{ $photo }})"></div>
                                        </div>
                                        <div>
                                            <a href="{{ route('search.index', App\Models\User::encryptor('encrypt', $vet->id)) }}" class="link-dark text-decoration-none text-center text-md-start">
                                                <h2 class="h4 mb-0 fw-medium">{{ $vet->company }}</h2>
                                            </a>
                                            <p class="mb-0 small mt-1 text-center text-md-start">
                                                <i class="fa-solid fa-location-dot me-2 opacity-50"></i>{{ App\Models\Countries::getResumeLocation($vet->country, $vet->province, $vet->canton, $vet->district) }}
                                            </p>
                                        </div>
                                        <div class="ms-md-auto">
                                            <a href="{{ route('search.index', App\Models\User::encryptor('encrypt', $vet->id)) }}" class="btn btn-primary btn-sm text-uppercase px-3">Ver<i class="fa-solid fa-plus ms-1"></i></a>
                                        </div>
                                    </div>

                                    <div class="row row-cols-1 row-cols-sm-2 mt-3">
                                        <div class="col">
                                            <div class="small paragraph0 resultBorder pb-3 pb-sm-0 pe-sm-3 h-100">
                                                <p>
                                                    {!! $vet->resume !!}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="d-flex flex-column gap-2 mt-3 mt-sm-0">
                                                @if($vet->phone != '')
                                                <div class="small fw-medium d-flex">
                                                    <i class="fa-solid fa-phone fa-fw text-primary me-2 mt-1"></i>{{ $vet->phone }}
                                                </div>
                                                @endif

                                                @if($vet->email != '')
                                                <div class="small fw-medium d-flex">
                                                    <i class="fa-solid fa-envelope fa-fw text-primary me-2 mt-1"></i>{{ $vet->email }}
                                                </div>
                                                @endif

                                                @if($vet->schedule != '')
                                                <div class="small fw-medium d-flex">
                                                    <i class="fa-solid fa-calendar-days fa-fw text-primary me-2 mt-1"></i>
                                                    <div class="paragraph0">
                                                        <p>{!! $vet->schedule !!}</p>
                                                    </div>
                                                </div>
                                                @endif

                                                @if($vet->website != '')
                                                <div class="small fw-medium d-flex">
                                                    <i class="fa-solid fa-globe fa-fw text-primary me-2 mt-1"></i>
                                                    <a href="{{ $vet->website }}" target="_blank" class="link-secondary text-decoration-none">{{ $vet->website }}</a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="col-12"><h2 class="h6 mb-0 fw-medium">{{ trans('dash.label.not.result') }}</h2></div>
            @endif
        @endif

        @if($resultIs == 'doctor')
            @if(count($doctors) > 0)
                <div class="row row-cols-1 row-cols-lg-2 p-0 m-0 g-3 mb-lg-5">

                    <div class="col">
                        <div class="card rounded-3 border-2 border-secondary h-100">
                            <div class="card-body p-4 p-lg-5">
                                <div class="d-flex flex-column flex-md-row align-items-center gap-2 gap-md-3">
                                    <div>
                                        <div class="vetPhoto rounded-circle mx-auto" style="background-image: url({{ asset('img/vet.png') }})"></div>
                                    </div>
                                    <div>
                                        <a href="" class="link-dark text-decoration-none text-center text-md-start">
                                            <h2 class="h3 mb-0 fw-medium">{{ $vet->company }}</h2>
                                        </a>
                                        <p class="mb-0 small mt-1 text-center text-md-start">
                                            <i class="fa-solid fa-location-dot me-2 opacity-50"></i>{{ App\Models\Countries::getResumeLocation($vet->country, $vet->province, $vet->canton, $vet->district) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="paragraph0 mt-3">
                                    <p>
                                        {!! $vet->resume !!}
                                    </p>
                                </div>

                                <div class="d-flex flex-column gap-2 mt-3">
                                    @if($vet->phone != '')
                                    <div class="fw-medium d-flex">
                                        <i class="fa-solid fa-phone fa-fw text-primary me-2 mt-1"></i>{{ $vet->phone }}
                                    </div>
                                    @endif

                                    @if($vet->email != '')
                                    <div class="fw-medium d-flex">
                                        <i class="fa-solid fa-envelope fa-fw text-primary me-2 mt-1"></i>{{ $vet->email }}
                                    </div>
                                    @endif

                                    @if($vet->schedule != '')
                                    <div class="fw-medium d-flex">
                                        <i class="fa-solid fa-calendar-days fa-fw text-primary me-2 mt-1"></i>
                                        <div class="paragraph0">
                                            <p>{!! $vet->schedule !!}</p>
                                        </div>
                                    </div>
                                    @endif

                                    @if($vet->website != '')
                                    <div class="fw-medium d-flex">
                                        <i class="fa-solid fa-globe fa-fw text-primary me-2 mt-1"></i>
                                        <a href="{{ $vet->website }}" target="_blank" class="link-secondary text-decoration-none">{{ $vet->website }}</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        
                        <div class="card rounded-3 border-2 border-secondary h-100">
                            <div class="card-body p-4 p-lg-5 doctorList">
                                <h4 class="fs-4 fw-medium mb-2">{{ trans('dash.label.our.vets') }}</h4>
                                @foreach ($doctors as $doctor)
                                    @php
                                        $photo = asset('img/default2.png');
                                        if($doctor->photo != '') {
                                            $photo = asset($doctor->photo);
                                        }
                                    @endphp
                                
                                    <div class="d-flex flex-column flex-sm-row gap-3 align-items-sm-center justify-content-between border-bottom border-2 border-secondary py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div>
                                                <div class="vetPhoto rounded-circle align-self-start" style="background-image: url({{ $photo }})"></div>
                                            </div>
                                            <div>
                                                <p class="fs-6 mb-0 fw-medium">{{ $doctor->name }}</p>
                                            </div>
                                        </div>
                                        @if($doctor->online_booking == 1)
                                        @if((Auth::guard('web')->check())&&(Auth::guard('web')->user()->rol_id == 8))
                                        <a href="{{ route('search.book', App\Models\User::encryptor('encrypt', $doctor->id)) }}" class="btn btn-primary btn-sm px-3 text-uppercase">{{ trans('dash.label.btn.schedule') }}</a>
                                        @else
                                        <a href="javascript:void(0);" onclick="$('#loginModal').modal('show');" class="btn btn-primary btn-sm px-3 text-uppercase">{{ trans('dash.label.btn.login') }}</a>
                                        @php $startSession = true; @endphp
                                        @endif
                                        @else
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm px-3 text-uppercase">{{ trans('dash.label.accept.clinic') }}</a>
                                        @endif
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                </div>
            @else
                <div class="col-12"><h2 class="h6 mb-0 fw-medium">{{ trans('dash.label.not.result') }}</h2></div>
            @endif
        @endif

        @if(($resultIs == 'vets')&&(count($vets) > 0))
        {{ $vets->links() }}
        @endif
        
    </section>

    @include('elements.footer')
 
    @if (isset($startSession))
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="fw-normal mb-0 text-secondary">{{ trans('auth.login.signin') }}</h6>
              <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <form id="loginForm" name="loginForm" method="post" action="" onsubmit="return startlogin();">
                    @csrf

                    <input type="hidden" name="rol" id="rol" value="8">
                    
                    <div class="mb-3">
                        <label for="emailInput" class="form-label small">{{ trans('auth.login.email') }}</label>
                        <div class="input-group">
                            <input type="email" class="form-control" id="emailInput" name="emailInput" required>
                            <span class="input-group-text">
                                <i class="fa-regular fa-envelope"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="passwordInput" class="form-label small">{{ trans('auth.login.password') }}</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="passwordInput" name="passwordInput" required>
                            <span class="input-group-text btn-toggle-password">
                                <i class="fa-regular fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mt-3" id="loginError" style="display: none; padding-bottom: 10px;">
                        <div class="alert alert-danger mb-0" id="loginErrorAlert">
                            <strong>Error!</strong> 
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary text-uppercase w-100" id="btnLogin">{{ trans('auth.login.signin') }}</button>
                </form>
            </div>
          </div>
        </div>
    </div>
    @endif

@endsection

@push('scriptHead')
<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<link rel="stylesheet" href="{{ asset('css/magicsearch.min.css') }}">
@endpush

@push('scriptBottom')
    <script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/front/magicsearch.min.js') }}"></script>

    <script>
        @if (isset($startSession))
        const passwordInput = document.getElementById('passwordInput');
        const passwordToggleBtn = document.querySelector('.btn-toggle-password');
        
        passwordToggleBtn.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggleBtn.innerHTML = '<i class="fa-regular fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                passwordToggleBtn.innerHTML = '<i class="fa-regular fa-eye"></i>';
            }
        });
        @endif

		function normalizeString(str) {
			return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
		}
        
		function search() {
			var criteria = $('#magicSearch').attr('data-id');

			// Normalizar el criterio de búsqueda
			criteria = normalizeString(criteria);

			criteria = btoa(criteria);

			location.href = '{{ route('search.index') }}/?search=' + criteria;
		}

		$(function() {
			var dataSource = {!! json_encode($querys) !!};

			// Normalizar cada campo del dataSource
			dataSource = dataSource.map(function(item) {
				item.company = normalizeString(item.company);
				item.address = normalizeString(item.address);
				return item;
			});

			$('#magicSearch').magicsearch({
				dataSource: dataSource,
				fields: ['socialname', 'company', 'email', 'website', 'address', 'resume', 'schedule'],
				id: 'id',
				format: '%company% · %address%',
				multiple: true,
				focusShow: false,
				noResult: 'No hay resultados',
				multiField: 'company',
				multiStyle: {
					space: 4,
					width: 80
				}
			});

		});
        
        @if (isset($startSession))
        function startlogin() {
            var validate = true;

            $('#emailInput').removeClass('is-invalid');
            $('#passwordInput').removeClass('is-invalid');

            if(!validaEmail($('#emailInput').val())){
                $('#emailInput').addClass('is-invalid');
                validate = false;
            }

            if($('#passwordInput').val() == ''){
                $('#passwordInput').addClass('is-invalid');
                validate = false;
            }

            if(validate == true) {
                setCharge();

                $.ajax({
                    url: '{{ route('login.loginAjax') }}',
                    type: 'POST',
                    data: new FormData(document.getElementById('loginForm')),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data, status, xhr) {  
                        if(data.login == 'success') {
                            location.reload();
                        }else{
                            $('#loginError').show();
                            $('#loginErrorAlert').html('<strong>Error!</strong> ' + data.error);
                        }

                        hideCharge();
                    },
                    error: function(xhr, status, error) {
                        hideCharge();
                    }
                });
            }

            return false;
        }

        function validaEmail(email) {
            var reg=/^[0-9a-z_\-\+.]+@[0-9a-z\-\.]+\.[a-z]{2,8}$/i;
            if(reg.test(email)){
                return true;
            }else{
                return false;
            }
        }
        @endif
    </script>
    
@endpush