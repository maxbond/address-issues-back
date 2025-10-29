<?php

namespace App\Http\Requests\Issue;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\IssueCommentData;

class CreateIssueCommentRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comment' => 'required|string|max:200',
        ];
    }

    public function getDto(): IssueCommentData
    {
        return IssueCommentData::from($this->validated());
    }
}
