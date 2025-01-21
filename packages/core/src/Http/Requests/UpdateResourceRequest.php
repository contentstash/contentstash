<?php

namespace ContentStash\Core\Http\Requests;

class UpdateResourceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data' => 'required|array',
            'data.*' => 'required|array',
            'data.*.name' => 'required|string',
            'data.*.nullable' => 'boolean',
            'data.*.attributeType' => 'required|string',
        ];
    }
}
