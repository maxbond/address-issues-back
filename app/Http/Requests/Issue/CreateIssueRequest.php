<?php

namespace App\Http\Requests\Issue;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\DTO\IssueData;
use Illuminate\Validation\Rule;

class CreateIssueRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address_id' => 'required|integer|exists:addresses,id',
            'status' => ['required', Rule::enum(IssueStatus::class)],
            'priority' => ['required', Rule::enum(IssuePriority::class)],
            'title' => 'required|string|max:200',
            'description' => 'string|nullable',
            'time_period_from' => 'nullable|date',
            'time_period_to' => 'nullable|date',
            'tracking_start' => 'nullable|date',
            'tracking_finish' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|integer|exists:tags,id',
            'executors' => 'nullable|array',
            'executors.*' => 'nullable|integer|exists:users,id',
            'phones' => 'nullable|array',
        ];
    }

    public function getDto(): IssueData
    {
        return IssueData::from($this->validated());
    }
}
