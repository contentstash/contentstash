<?php

namespace ContentStash\Core\Http\Requests;

class StoreResourceRequest extends UpdateResourceRequest
{
    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'model' => 'required|string',
        ]);
    }
}
