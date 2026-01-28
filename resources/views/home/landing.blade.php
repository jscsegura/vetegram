<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://vetegram.com/staging/css/magicsearch.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/landing.css') }}">
	<title>Vetegram</title>
</head>

<body>
	@php
		$weblang = \App::getLocale();
		$aboutTitle = data_get($about, 'title_' . $weblang, '');
		$aboutDesc = data_get($about, 'description_' . $weblang, '');
		$aboutImage = data_get($about, 'image', '');
	@endphp
	<header id="header" class="container-fluid sticky-lg-top bg-primary">
		<div class="container px-1">
			<nav id="navBarMain" class="navbar navbar-expand-lg justify-content-end" data-bs-theme="dark">
				<div class="py-2 me-auto order-0">
					<!-- <svg id="logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 224" style="enable-background:new 0 0 1000 224;" xml:space="preserve">
						<path style="fill:#fff;" d="M146.4,160c0,1.5-1.2,2.8-2.8,2.8c-1.5,0-2.8-1.2-2.8-2.8s1.2-2.8,2.8-2.8 C145.2,157.2,146.4,158.5,146.4,160" />
						<path style="fill:#fff;" d="M223.2,112c0-61.6-50-111.6-111.6-111.6S0,50.4,0,112c0,0.9,0,1.7,0,2.6c0,0,0,0.1,0,0.1l22.3-22.4 l-0.1-0.2l33.4-34.5h0.3c5.1-5.4,10.3-10.2,15.3-14.4c9.1-7.6,17.5-13.3,24.3-17.5c0.5,4.1,0.7,10.3-1.5,17.1 c-2.2,7-1.7,9.4-1.2,12.8c0.2,1.1,1.1,2,2.3,2h86.2c0.2,0.7,0.4,1.3,0.8,1.9c0.4,0.6,0.9,1,1.5,1.4c-3.6,6.8-8.1,13-13.4,18.5 C165,85.1,159,90,152.5,94c-6.7-0.7-13.2-2.1-19.4-4.2c-6.2-2.1-12-4.9-17.5-8.2c3.9,3.7,8.2,7.1,12.8,10c4.6,2.9,9.4,5.5,14.6,7.5 c-11,5-23.3,7.9-36.3,7.9c-2.1,0-4.2-0.1-6.3-0.2c-2.1-0.2-4.2-0.4-6.2-0.7v116.2c5.7,0.9,11.5,1.4,17.4,1.4c10.1,0,20-1.4,29.3-3.9 c0.3-0.1,0.5-0.1,0.8-0.2v-34.2c0-0.3-0.1-0.5-0.4-0.6l0,0c-0.8-0.6-1.5-1-1.7-1.1c-0.2-0.1-0.4-0.2-0.6-0.3c-3-1.3-4.9,0-8-0.7 c-6.4-1.5-11.9-10.5-10-15.8c1.1-2.9,3.5-2.2,7-6.4c0.7-0.9,1.3-1.7,1.7-2.4c0.8-1.5,1.1-2.8,1.5-4.1c0.4-1.5,1-3,2.5-5 c4.2-5.5,8.8-5.4,9.2-9.2c0.2-2.5-1.7-3.3-3.1-7.6c-1.2-3.6-1-6.8-0.8-9c3.6,2.2,8,5.2,12.8,9.2c4.8,4,9.8,9,14.6,15.2l3.9,4.6 l27.2,31c3.6-4.3,6.8-8.9,9.7-13.7C217.4,152.7,223.2,133,223.2,112z" />
						<path style="fill:#4bc6f9;" d="M189.4,55.8c-0.1-1.2-1.1-2.1-2.2-2.2c-1.7-0.2-3.1,1.2-2.9,2.9c0.1,1.2,1.1,2.1,2.2,2.2 C188.2,59,189.6,57.5,189.4,55.8" />
						<path style="fill:#fff;" d="M93.5,32.4c-0.8,0.9-1.6,1.7-2.4,2.6c-0.8,0.9-1.5,1.8-2.2,2.7c-1.4,1.8-2.7,3.7-3.8,5.8 c-1.1,2-2,4.1-2.8,6.3c-0.8,2.2-1.5,4.4-2.1,6.7c-0.1-2.4,0.2-4.8,0.8-7.1c0.6-2.3,1.5-4.6,2.6-6.7c1.1-2.1,2.6-4.1,4.3-5.8 C89.5,35.1,91.4,33.6,93.5,32.4" />
						<path style="fill:#fff;" d="M982.5,62.3h-4.1v11h-2.7v-11h-4.1v-2.2h11V62.3z M997.3,73.2l-0.6-9.1l-4.1,9.1h-1.3l-4.2-9.1l-0.6,9.1h-2.7l0.9-13.2h2.8 l4.4,9.5l4.3-9.5h2.8l0.9,13.2H997.3z" />
						<polygon style="fill:#fff;" points="247,78.9 272,78.9 292.7,133.4 313.2,78.9 338.1,78.9 303.5,162.8 281.8,162.8 " />
						<polygon style="fill:#fff;" points="412.8,143.5 412.8,162.8 349.8,162.8 349.8,78.9 412,78.9 412,98.2 373.2,98.2 373.2,110.9  407.7,110.9 407.7,130.2 373.2,130.2 373.2,143.5 " />
						<polygon style="fill:#fff;" points="495.3,98.2 471.2,98.2 471.2,162.8 447.8,162.8 447.8,98.2 423.7,98.2 423.7,78.9 495.3,78.9 " />
						<polygon style="fill:#fff;" points="572.6,143.5 572.6,162.8 509.6,162.8 509.6,78.9 571.8,78.9 571.8,98.2 532.9,98.2 532.9,110.9 567.5,110.9 567.5,130.2 532.9,130.2 532.9,143.5 " />
						<path style="fill:#fff;" d="M672.6,120.9c0,25.4-16.8,43.1-43.2,43.1c-27.2,0-45.3-17.2-45.3-43.1s17.8-43.1,45.3-43.1 c12.9,0,24,3.7,31.4,9.9l-15.3,14.5c-2.8-3.2-8.2-5.1-15.8-5.1c-12.9,0-21.5,9.5-21.5,23.8c0,14.3,8.5,23.8,21.3,23.8 c9.7,0,16.4-4.9,18.4-12.6h-16.4v-19.3h40.8C672.4,115.5,672.6,118.1,672.6,120.9" />
						<path style="fill:#fff;" d="M720.7,135.4h-10.2v27.4h-23.3V78.9h39.3c18.4,0,30.6,11.3,30.6,28.2c0,10.2-5,18.5-13.5,23.3 l20.7,32.3H737L720.7,135.4z M710.5,116.1h11.2c6.8,0,11.3-3.6,11.3-9c0-5.3-3.5-9-9.1-9h-13.5V116.1z" />
						<path style="fill:#fff;" d="M830.1,151.3h-32.6l-4.3,11.4h-24.9L803,78.9h21.6l34.7,83.9h-24.9L830.1,151.3z M822.8,132.1l-9-24 l-9.1,24H822.8z" />
						<polygon style="fill:#fff;" points="948.1,162.8 945.5,117.8 925.9,162.8 913.7,162.8 894.2,118 891.5,162.8 868.1,162.8 874.4,78.9 900.6,78.9 919.8,124 939.1,78.9 965.3,78.9 971.5,162.8 " />
						<path style="fill:#fff;" d="M103.9,73c-0.5,1.4-1.9,2.3-3.5,2.1c-1.6-0.2-2.8-1.5-2.9-3.1c-0.1-1.4,0.7-2.7,1.9-3.3 c0.4-0.2,0.9-0.3,1.4-0.3c1.9,0,3.4,1.5,3.4,3.4C104.2,72.2,104.1,72.6,103.9,73" />
					</svg> -->
					<object data="{{asset('img/logo.svg')}}" style="height: 64px; mix-blend-mode: multiply;"></object>
				</div>
				<button class="navbar-toggler order-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div id="mainNav" class="collapse navbar-collapse order-4 order-lg-2">
					<ul class="navbar-nav ms-auto mt-3 mt-lg-0">
						<li class="nav-item px-1 px-lg-3">
							<a class="nav-link px-0 text-uppercase" href="#mainBanner">{{ trans('landing.label.Inicio') }}</a>
						</li>
						<li class="nav-item px-1 px-lg-3">
							<a class="nav-link px-0 text-uppercase" href="#section2">{{ trans('landing.label.Servicios') }}</a>
						</li>
						<li class="nav-item px-1 px-lg-3">
							<a class="nav-link px-0 text-uppercase" href="#section3">{{ trans('landing.label.Nosotros') }}</a>
						</li>
						<li class="nav-item px-1 px-lg-3">
							<a class="nav-link px-0 text-uppercase" href="#section4">{{ trans('landing.label.Contacto') }}</a>
						</li>
						<li class="nav-item px-1 px-lg-3">
							@if (Config::get('app.locale') == 'en')
							<a class="nav-link px-0 text-uppercase border border-1 border-white rounded-2 px-3 d-table mb-2 mb-lg-0 mt-2 mt-lg-0" href="{{ route('change.language', ['es'])}}">ES</a>
							@else
							<a class="nav-link px-0 text-uppercase border border-1 border-white rounded-2 px-3 d-table mb-2 mb-lg-0 mt-2 mt-lg-0" href="{{ route('change.language', ['en'])}}">EN</a>
							@endif
						</li>
					</ul>
				</div>
				<div class="ms-0 ms-lg-3 me-3 me-lg-0 order-2 order-lg-4">
					<a id="enterBtn" href="{{ route('home.index') }}" class="btn btn-dark rounded-3 py-2 px-3 fw-medium text-uppercase">
						<i class="fa-solid fa-circle-user me-0 me-md-2 text-primary"></i>
						<span class="small d-none d-md-inline-block">{{ trans('landing.label.Ingresar') }}</span>
					</a>
				</div>
			</nav>
		</div>
	</header>


	<div id="wrapSection">
		<div class="position-relative z-1">
			<div id="mainBanner" class="section carousel slide" data-bs-ride="carousel">
				<div class="carousel-inner">
					@php $counter = 0; @endphp
					@foreach ($sliders as $slider)
					<div class="carousel-item @if($counter == 0) active @endif">
						<picture>
							<source media="(min-width: 768px)" srcset="{{ asset('files/' . $slider->image) }}">
							<img src="{{ asset('files/' . $slider->image_movil) }}" alt="Banner" class="d-block w-100">
						</picture>
						<div class="carousel-caption text-center mb-0 mb-lg-5">
							<h5 class="h1 fw-normal mb-0">{{ $slider['title_' . $weblang] }}</h5>
						</div>
					</div>
					@php $counter++; @endphp
					@endforeach
				</div>
				<button class="carousel-control-prev d-none d-md-block" type="button" data-bs-target="#mainBanner" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next d-none d-md-block" type="button" data-bs-target="#mainBanner" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
			</div>
			<div id="vBanner">
				<h1 class="text-center text-uppercase mb-2 mb-lg-3 text-white">{{ trans('landing.menu.search') }} <span class="text-primary">{{ trans('landing.label.veterinaries') }}</span></h1>
				<form class="col-12">
					<div class="d-flex flex-column flex-sm-row gap-2 gap-md-3">
						<div class="flex-grow-1">
							<input type="text" name="criteria" id="magicSearch" class="form-control fw-normal" placeholder="{{ trans('landing.placeholder.search') }}" autocomplete="off">
						</div>
						<div>
							<button onclick="search();" class="btn btn-primary px-3 px-lg-4 w-100" type="button">{{ trans('landing.menu.search') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div id="section2" class="section container-fluid py-1 py-md-5">
			<div class="container py-4 py-md-5">
				<h2 class="display-4 text-dark text-uppercase text-center mb-3 mb-md-4">{{ trans('landing.label.Nuestros') }} <span class="text-primary fw-semibold">{{ trans('landing.label.servicios') }}</span></h2>
				<div class="row row-cols-1 row-cols-lg-3 g-4">
					@foreach ($services as $service)
					<div class="col">
						<div class="card text-center rounded-4 overflow-hidden h-100">
							<img src="{{ asset('files/' . $service->image) }}" alt="Imagen" class="card-img-top">
							<div class="p-4">
								<h3 class="text-uppercase text-secondary fw-semibold">{{ $service['title_' . $weblang] }}</h3>
								<p class="fs-5 lh-sm mb-0">{{ $service['description_' . $weblang] }}</p>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>

		<div id="section3" class="section bg-info py-1 py-md-5">
			<div class="container py-4 py-md-5 px-4">
				<h2 class="display-4 text-dark text-uppercase text-center mb-4 mb-md-5">{{ trans('landing.label.Sobre') }} <span class="text-primary fw-semibold">{{ trans('landing.label.nosotros') }}</span></h2>
				<div class="row g-4 col-xl-10 mx-xl-auto align-items-center">
					<div class="col-md-7">
						<h3 class="h2 fw-normal text-dark text-uppercase mb-3">{{ $aboutTitle }}</h3>
						<div class="fs-5 lh-base">
							<p class="mb-0">{!! $aboutDesc !!}</p>
						</div>
					</div>
					<div class="col-md-5">
						<img class="img-fluid rounded-4" src="{{ asset('files/' . $aboutImage) }}" alt="Nosotros">
					</div>
				</div>

				<div class="row g-5 mt-2 mt-md-4 col-xl-11 mx-xl-auto">
					@foreach ($abouts as $row)
					<div class="col-md-6 col-lg-3 item-box text-center">
						<div class="icon-container mb-4">
							<i class="{{ $row->image }} icon display-2 m-auto"></i>
						</div>
						<h5 class="h4 text-dark text-uppercase mb-3">{{ $row['title_' . $weblang] }}</h5>
						<p class="mb-0 fs-5">{{ $row['description_' . $weblang] }}</p>
					</div>
					@endforeach
				</div>

			</div>
		</div>

		<div id="section4" class="section parallax py-1 py-md-5">
			<div class="container py-4 px-4 px-md-0">
				<div class="row" data-bs-theme="dark">
					<div class="col-lg-5">
						<div class="bg-dark-op p-4 p-lg-5 rounded-4">
							<h2 class="display-5 text-white text-uppercase text-center text-lg-start fw-medium mb-4">{{ trans('landing.label.Contacto') }}</h2>
							<form id="myForm" action="#" method="post">
								<div class="mb-3">
									<label for="fname" class="form-label text-white">{{ trans('landing.label.Nombre.completo') }}</label>
									<input type="text" id="fname" name="fname" class="form-control">
								</div>
								<div class="mb-3">
									<label for="email" class="form-label text-white">{{ trans('landing.Correo.electronico') }}</label>
									<input type="email" id="email" name="email" class="form-control">
								</div>
								<div class="mb-3">
									<label for="message" class="form-label text-white">{{ trans('landing.label.Mensaje') }}</label>
									<textarea class="form-control" id="message" name="message" rows="3"></textarea>
								</div>
								<button type="button" onclick="validaFrmContact();" class="btn btn-outline-light px-4 py-2 rounded-3 text-uppercase" id="btnsender">{{ trans('landing.label.Enviar') }}</button>
							</form>

							<div class="mt-3" style="display: none;" id="printerSend">
								<div class="alert alert-success mb-0">
									<strong>{{ trans('landing.label.Enviado') }}</strong> {{ trans('landing.contact.success') }}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<footer class="container-fluid py-4 py-md-5">
		<div class="container">
			<div class="row row-cols-1 row-cols-lg-3 g-4 g-md-5 text-center text-lg-start">
				<div class="col">
					<!-- <svg id="logo2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 224" style="enable-background:new 0 0 1000 224;" xml:space="preserve">
						<path style="fill:#4BC6F9;" d="M146.4,160c0,1.5-1.2,2.8-2.8,2.8c-1.5,0-2.8-1.2-2.8-2.8s1.2-2.8,2.8-2.8 C145.2,157.2,146.4,158.5,146.4,160"></path>
						<path style="fill:#4BC6F9;" d="M223.2,112c0-61.6-50-111.6-111.6-111.6S0,50.4,0,112c0,0.9,0,1.7,0,2.6c0,0,0,0.1,0,0.1l22.3-22.4 l-0.1-0.2l33.4-34.5h0.3c5.1-5.4,10.3-10.2,15.3-14.4c9.1-7.6,17.5-13.3,24.3-17.5c0.5,4.1,0.7,10.3-1.5,17.1 c-2.2,7-1.7,9.4-1.2,12.8c0.2,1.1,1.1,2,2.3,2h86.2c0.2,0.7,0.4,1.3,0.8,1.9c0.4,0.6,0.9,1,1.5,1.4c-3.6,6.8-8.1,13-13.4,18.5 C165,85.1,159,90,152.5,94c-6.7-0.7-13.2-2.1-19.4-4.2c-6.2-2.1-12-4.9-17.5-8.2c3.9,3.7,8.2,7.1,12.8,10c4.6,2.9,9.4,5.5,14.6,7.5 c-11,5-23.3,7.9-36.3,7.9c-2.1,0-4.2-0.1-6.3-0.2c-2.1-0.2-4.2-0.4-6.2-0.7v116.2c5.7,0.9,11.5,1.4,17.4,1.4c10.1,0,20-1.4,29.3-3.9 c0.3-0.1,0.5-0.1,0.8-0.2v-34.2c0-0.3-0.1-0.5-0.4-0.6l0,0c-0.8-0.6-1.5-1-1.7-1.1c-0.2-0.1-0.4-0.2-0.6-0.3c-3-1.3-4.9,0-8-0.7 c-6.4-1.5-11.9-10.5-10-15.8c1.1-2.9,3.5-2.2,7-6.4c0.7-0.9,1.3-1.7,1.7-2.4c0.8-1.5,1.1-2.8,1.5-4.1c0.4-1.5,1-3,2.5-5 c4.2-5.5,8.8-5.4,9.2-9.2c0.2-2.5-1.7-3.3-3.1-7.6c-1.2-3.6-1-6.8-0.8-9c3.6,2.2,8,5.2,12.8,9.2c4.8,4,9.8,9,14.6,15.2l3.9,4.6 l27.2,31c3.6-4.3,6.8-8.9,9.7-13.7C217.4,152.7,223.2,133,223.2,112z"></path>
						<path style="fill:#FFFFFF;" d="M189.4,55.8c-0.1-1.2-1.1-2.1-2.2-2.2c-1.7-0.2-3.1,1.2-2.9,2.9c0.1,1.2,1.1,2.1,2.2,2.2 C188.2,59,189.6,57.5,189.4,55.8"></path>
						<path style="fill:#4BC6F9;" d="M93.5,32.4c-0.8,0.9-1.6,1.7-2.4,2.6c-0.8,0.9-1.5,1.8-2.2,2.7c-1.4,1.8-2.7,3.7-3.8,5.8 c-1.1,2-2,4.1-2.8,6.3c-0.8,2.2-1.5,4.4-2.1,6.7c-0.1-2.4,0.2-4.8,0.8-7.1c0.6-2.3,1.5-4.6,2.6-6.7c1.1-2.1,2.6-4.1,4.3-5.8 C89.5,35.1,91.4,33.6,93.5,32.4"></path>
						<path style="fill:#FFFFFF;" d="M982.5,62.3h-4.1v11h-2.7v-11h-4.1v-2.2h11V62.3z M997.3,73.2l-0.6-9.1l-4.1,9.1h-1.3l-4.2-9.1l-0.6,9.1h-2.7l0.9-13.2h2.8 l4.4,9.5l4.3-9.5h2.8l0.9,13.2H997.3z"></path>
						<polygon style="fill:#152630;" points="247,78.9 272,78.9 292.7,133.4 313.2,78.9 338.1,78.9 303.5,162.8 281.8,162.8 "></polygon>
						<polygon style="fill:#152630;" points="412.8,143.5 412.8,162.8 349.8,162.8 349.8,78.9 412,78.9 412,98.2 373.2,98.2 373.2,110.9  407.7,110.9 407.7,130.2 373.2,130.2 373.2,143.5 "></polygon>
						<polygon style="fill:#152630;" points="495.3,98.2 471.2,98.2 471.2,162.8 447.8,162.8 447.8,98.2 423.7,98.2 423.7,78.9 495.3,78.9 "></polygon>
						<polygon style="fill:#152630;" points="572.6,143.5 572.6,162.8 509.6,162.8 509.6,78.9 571.8,78.9 571.8,98.2 532.9,98.2 532.9,110.9 567.5,110.9 567.5,130.2 532.9,130.2 532.9,143.5 "></polygon>
						<path style="fill:#152630;" d="M672.6,120.9c0,25.4-16.8,43.1-43.2,43.1c-27.2,0-45.3-17.2-45.3-43.1s17.8-43.1,45.3-43.1 c12.9,0,24,3.7,31.4,9.9l-15.3,14.5c-2.8-3.2-8.2-5.1-15.8-5.1c-12.9,0-21.5,9.5-21.5,23.8c0,14.3,8.5,23.8,21.3,23.8 c9.7,0,16.4-4.9,18.4-12.6h-16.4v-19.3h40.8C672.4,115.5,672.6,118.1,672.6,120.9"></path>
						<path style="fill:#152630;" d="M720.7,135.4h-10.2v27.4h-23.3V78.9h39.3c18.4,0,30.6,11.3,30.6,28.2c0,10.2-5,18.5-13.5,23.3 l20.7,32.3H737L720.7,135.4z M710.5,116.1h11.2c6.8,0,11.3-3.6,11.3-9c0-5.3-3.5-9-9.1-9h-13.5V116.1z"></path>
						<path style="fill:#152630;" d="M830.1,151.3h-32.6l-4.3,11.4h-24.9L803,78.9h21.6l34.7,83.9h-24.9L830.1,151.3z M822.8,132.1l-9-24 l-9.1,24H822.8z"></path>
						<polygon style="fill:#152630;" points="948.1,162.8 945.5,117.8 925.9,162.8 913.7,162.8 894.2,118 891.5,162.8 868.1,162.8 874.4,78.9 900.6,78.9 919.8,124 939.1,78.9 965.3,78.9 971.5,162.8 "></polygon>
						<path style="fill:#4BC6F9;" d="M103.9,73c-0.5,1.4-1.9,2.3-3.5,2.1c-1.6-0.2-2.8-1.5-2.9-3.1c-0.1-1.4,0.7-2.7,1.9-3.3 c0.4-0.2,0.9-0.3,1.4-0.3c1.9,0,3.4,1.5,3.4,3.4C104.2,72.2,104.1,72.6,103.9,73"></path>
					</svg> -->
					<object data="{{asset('img/logo.svg')}}" style="height: 64px; mix-blend-mode: multiply;"></object>
				</div>
				<div class="col">
					<h4 class="h5 text-uppercase text-dark">{{ trans('landing.label.Informacion') }}</h4>
					<div class="fs-5 mb-2">
						<i class="fa-solid fa-envelope fa-fw text-primary me-1"></i>
						<a href="mailto:info@vetegramcr.com" class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">info@vetegramcr.com</a>
					</div>

					<div class="fs-5">
						<i class="fa-solid fa-phone-flip fa-fw text-primary me-1"></i>
						<a href="tel:8822-8082" class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">8822-8082</a>
					</div>
				</div>
				<div class="col">
					<h4 class="h5 text-uppercase text-dark">{{ trans('landing.label.Siguenos') }}</h4>
					<div class="d-flex gap-2 justify-content-center justify-content-lg-start">
						<a href="https://www.facebook.com/" target="_blank" class="link-primary fs-2">
							<i class="fa-brands fa-facebook"></i>
						</a>
						<a href="https://instagram.com" target="_blank" class="link-primary fs-2">
							<i class="fa-brands fa-instagram"></i>
						</a>
					</div>
				</div>
			</div>

		</div>
	</footer>

	<div class="container-fluid border-top p-3">
		<p class="mb-0 text-center fw-light">Vetegram ©<?php echo date("Y"); ?>. Todos los derechos reservados.</p>
	</div>

	<button id="btTop" class="btTop" title="Botón para subir al inicio de la página">
        <i class="fa-solid fa-arrow-up-long"></i>
    </button>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://vetegram.com/staging/js/front/magicsearch.min.js"></script>

	<script>
		//scroll
		const scrollSpy = new bootstrap.ScrollSpy(document.body, {
			target: '#navBarMain',
			threshold: '0,1',
			rootMargin: '-30% 0% -70%',
			smoothScroll: true,
		})

        //Top
        let mybutton = document.getElementById("btTop");

        window.onscroll = function () {
            scrollFunction();
        };

        function scrollFunction() {
            if (
                document.body.scrollTop > 300 ||
                document.documentElement.scrollTop > 300
            ) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        mybutton.addEventListener("click", backToTop);

        function backToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

		function validaFrmContact() {
			var validate = true;

			$('#fname').removeClass('is-invalid');
			$('#email').removeClass('is-invalid');
			$('#message').removeClass('is-invalid');

			if($('#fname').val() == ''){
				$('#fname').addClass('is-invalid');
				validate = false;
			}

			if(!validaEmail($('#email').val())){
				$('#email').addClass('is-invalid');
				validate = false;
			}

			if($('#message').val() == ''){
				$('#message').addClass('is-invalid');
				validate = false;
			}

			if(validate) {
				var fname = $('#fname').val();
				var email = $('#email').val();
				var message = $('#message').val();

				$('#btnsender').html('{{ trans('landing.label.Enviando') }}');
				$('#btnsender').attr('disabled', true);

				$.ajax({
					type: 'POST',
					url: '{{ route('home.contact') }}',
					dataType: "json",
					headers: {
						"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
					},
					data: {
						fname: fname,
						email: email,
						message: message
					},
					beforeSend: function(){},
					success: function(data){
						$('#btnsender').html('{{ trans('landing.label.Enviar') }}');
						$('#btnsender').attr('disabled', false);

						$('#printerSend').css('display', 'block');
					}
				});
			}
		}

		function validaEmail(email) {
			var reg=/^[0-9a-z_\-\+.]+@[0-9a-z\-\.]+\.[a-z]{2,8}$/i;
			if(reg.test(email)){
				return true;
			}else{
				return false;
			}
		}

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
	</script>

</body>

</html>
