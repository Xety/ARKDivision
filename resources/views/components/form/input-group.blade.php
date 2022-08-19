{{-- Required for association field --}}
@php
    $errorName = str_replace('[', '.', $name);
    $errorName = str_replace(']', '', $errorName);
@endphp

<div class="input-group mb-3 text-start {{ $errors->has($errorName) ? 'has-validation' : '' }}">
    <span
        for="{{ $name }}"
        style="{{ isset($attributes['spanStyle']) ? $attributes['spanStyle'] : '' }}"
        class="{{ isset($attributes['spanClass']) ? $attributes['spanClass'] : 'input-group-text' }}">
        {!! isset($attributes['span']) ? $attributes['span'] : $label !!}
    </span>
    <div class="form-floating {{ $errors->has($errorName) ? 'is-invalid' : '' }}">
        @if (isset($attributes['type']) && $attributes['type'] == 'password')
            {!! Form::password(
                $name,
                array_merge(['class' => $errors->has($errorName) ? 'form-control  is-invalid' : 'form-control'], $attributes)
            ) !!}
        @else
            {!! Form::text(
                $name,
                $value,
                array_merge(['class' => $errors->has($errorName) ? 'form-control  is-invalid' : 'form-control'], $attributes)
            ) !!}
        @endif

        {!! Form::label($name, $label) !!}
    </div>
</div>

@if ($errors->has($errorName))
    <div class="invalid-feedback">
        {{ $errors->first($errorName) }}
    </div>
@endif
