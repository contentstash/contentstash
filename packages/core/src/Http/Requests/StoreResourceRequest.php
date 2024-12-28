<?php

namespace ContentStash\Core\Http\Requests;

class StoreResourceRequest extends FormRequest
{
    // /**
    //  * Determine if the user is authorized to make this request.
    //  */
    // public function authorize(): bool
    // {
    //     return false;
    // }

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
            // 'data.*.phpType' => 'required|string',
            // 'data.*.type' => 'required|string',
            // 'data.*.increments' => 'required|boolean',
            'data.*.nullable' => 'required|boolean',
            // 'data.*.default' => 'required|string',
            // 'data.*.primary' => 'required|boolean',
            // 'data.*.unique' => 'required|boolean',
            // 'data.*.fillable' => 'required|boolean',
            // 'data.*.appended' => 'required|boolean',
            // 'data.*.cast' => 'required|string',
            // 'data.*.virtual' => 'required|boolean',
            // 'data.*.hidden' => 'required|boolean',
            // 'data.*.defaultValue' => 'required|string',
            'data.*.attributeType' => 'required|string',
        ];
    }
}
