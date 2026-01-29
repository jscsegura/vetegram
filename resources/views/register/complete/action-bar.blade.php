@php
    $step = $step ?? '';
    $backStep = $backStep ?? null;
    $nextStep = $nextStep ?? null;
    $nextLabel = $nextLabel ?? trans('auth.register.complete.next.save');
    $submit = $submit ?? false;
@endphp

<div class="wizard-action-bar" data-step="{{ $step }}">
    <div class="wizard-action-bar-inner col-xl-9 mx-auto px-2">
        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
            @if ($backStep)
                <button type="button" class="btn btn-outline-secondary" onclick="changeTab('{{ $backStep }}')">{{ trans('auth.register.complete.previous') }}</button>
            @endif
            @if ($submit)
                <button type="submit" class="btn btn-primary wizard-next-btn" data-step="{{ $step }}" data-default-label="{{ $nextLabel }}" data-loading-label="{{ trans('auth.register.complete.saving') }}">{{ $nextLabel }}</button>
            @else
                <button type="button" class="btn btn-primary wizard-next-btn" data-step="{{ $step }}" data-default-label="{{ $nextLabel }}" data-loading-label="{{ trans('auth.register.complete.saving') }}" onclick="nextStep('{{ $step }}','{{ $nextStep }}')">{{ $nextLabel }}</button>
            @endif
        </div>
    </div>
</div>
