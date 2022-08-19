<div class="form-floating mb-3">
    {!! Form::password(
        $name,
        array_merge(['class' => $errors->has($name) ? 'form-control  is-invalid' : 'form-control'], $attributes)
    ) !!}
    {!! Form::label($name, $label) !!}

    @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
