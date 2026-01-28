<div id="wrapPtabs" class="overflow-auto mb-3 mb-md-4 mt-4 mt-xl-0">
    <ul id="petTabs" class="nav nav-tabs flex-nowrap small gap-1 gap-lg-2">
        <li class="nav-item">
            <a class="nav-link text-uppercase px-3 px-lg-4 {{ ($thismenu == 'petappointment') ? 'active' : '' }}" aria-current="page" href="{{ route('pet.detail', App\Models\User::encryptor('encrypt', $pet->id)) }}">{{ trans('dash.title.appointment') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-uppercase px-3 px-lg-4 {{ ($thismenu == 'petattach') ? 'active' : '' }}" href="{{ route('pet.attach', App\Models\User::encryptor('encrypt', $pet->id)) }}">{{ trans('dash.label.attachments') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-uppercase px-3 px-lg-4 {{ ($thismenu == 'petrecipes') ? 'active' : '' }}" href="{{ route('pet.recipes', App\Models\User::encryptor('encrypt', $pet->id)) }}">{{ trans('dash.label.recipes.all') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-uppercase px-3 px-lg-4 me-3 {{ ($thismenu == 'petvaccines') ? 'active' : '' }}" href="{{ route('pet.vaccines', App\Models\User::encryptor('encrypt', $pet->id)) }}">{{ trans('dash.label.title.vaccine') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-uppercase px-3 px-lg-4 me-3 {{ ($thismenu == 'petdesparations') ? 'active' : '' }}" href="{{ route('pet.desparat', App\Models\User::encryptor('encrypt', $pet->id)) }}">{{ trans('dash.label.title.desperation') }}</a>
        </li>
    </ul>
</div>