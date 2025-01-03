<?php

namespace ContentStash\Core\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModelResource extends JsonResource
{
    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
