<?php

namespace App\Http\Requests\Issue;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\DTO\IssueData;
use Illuminate\Validation\Rule;

class UpdateIssueRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['nullable', Rule::enum(IssueStatus::class)],
            'priority' => ['nullable', Rule::enum(IssuePriority::class)],
            'title' => 'nullable|string|max:200',
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
