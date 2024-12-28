<?php

namespace ContentStash\Core\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class FormRequest extends BaseFormRequest
{
    /**
     * Determine if the request is an Inertia request.
     */
    protected function isInertiaRequest(): bool
    {
        return $this->header('x-inertia') == true;
    }

    /**
     * {@inheritDoc}
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->isInertiaRequest()) {
            return parent::failedValidation($validator);
        }
        throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
