{{-- Required for association field --}}
@php
    $errorName = str_replace('[', '.', $name);
    $errorName = str_replace(']', '', $errorName);
@endphp

<div class="form-floating mb-3">
    {!! Form::text(
        $name,
        $value,
        array_merge(['class' => $errors->has($errorName) ? 'form-control  is-invalid' : 'form-control'], $attributes)
    ) !!}
    {!! Form::label($name, $label, ['class' => $labelClass]) !!}

    @if ($errors->has($errorName))
        <div class="invalid-feedback">
            {{ $errors->first($errorName) }}
        </div>
    @endif

    @if ($errors->has('slug') && in_array($errorName, ['title', 'name']))
        <div class="invalid-feedback">
            {{ $errors->first('slug') }}
        </div>
    @endif

    @isset($attributes['formText'])
        <small class="form-text text-muted">
            {{ $attributes['formText'] }}
        </small>
    @endisset
</div>
