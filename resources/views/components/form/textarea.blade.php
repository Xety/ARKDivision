<div class="form-floating mb-3">
    @isset($attributes['editor'])
        <div id="{{ $attributes['editor'] }}">
    @endisset

    {!! Form::textarea(
        $name,
        $value,
        array_merge(['class' => $errors->has($name) ? 'form-control form-control-danger' : 'form-control', 'rows' => 5], $attributes)
    ) !!}

    @if ($label !== false)
        {!! Form::label($name, $label, ['class' => $labelClass]) !!}
    @endif

    @isset($attributes['editor'])
        </div>
    @endisset

    @if ($errors->has($name))
    <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
