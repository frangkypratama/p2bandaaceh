<?php

namespace App\Http\Requests;

class StoreSbpRequest extends BaseSbpRequest
{
    public function rules(): array
    {
        return array_merge(
            $this->baseRules(),
            $this->bastRules()
        );
    }
}
