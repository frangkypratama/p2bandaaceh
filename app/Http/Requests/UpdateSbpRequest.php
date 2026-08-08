<?php

namespace App\Http\Requests;

class UpdateSbpRequest extends BaseSbpRequest
{
    public function rules(): array
    {
        $sbp = $this->route('sbp');
        $bastId = $sbp?->bast?->id;

        return array_merge(
            $this->baseRules(),
            ['delete_bast' => 'nullable|boolean'],
            $this->bastRules($bastId)
        );
    }

    protected function ignoreSbpId(): ?int
    {
        return $this->route('sbp')?->id;
    }
}
