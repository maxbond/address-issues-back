<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\StreetData;

class CreateStreetRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'location_id' => 'required|integer|exists:locations,id',
            'name' => 'required|string|max:50',
        ];
    }

    public function getDto(): StreetData
    {
        return StreetData::from($this->validated());
    }
}
