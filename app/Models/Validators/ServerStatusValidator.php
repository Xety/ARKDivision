<?php
namespace Xetaravel\Models\Validators;

use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ServerStatusValidator
{
    /**
     * Get the validator for an incoming registration request.
     *
     * @param array $data The data to validate.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function create(array $data): Validator
    {
        $rules = [
            'type' => [
                'required',
                Rule::in(['starting', 'initializing', 'started', 'stopping', 'stopped'])
            ]
        ];

        return FacadeValidator::make($data, $rules);
    }
}
