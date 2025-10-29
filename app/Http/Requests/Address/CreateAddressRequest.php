<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\AddressData;

class CreateAddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'street_id' => 'required|integer|exists:streets,id',
            'house' => 'required|string|max:20',
            'flat' => 'nullable|string|max:20',
            'floor' => 'nullable|integer|max:128|min:1',
            'entrance' => 'nullable|integer|max:128|min:1',
            'entrance_is_locked' => 'nullable|boolean',
            'has_gate' => 'nullable|boolean',
            'comment' => 'nullable|string|max:100',
        ];
    }

    public function getDto(): AddressData
    {
        return AddressData::from($this->validated());
    }
}
