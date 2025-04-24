<?php

namespace App\Http\Requests;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'tags' => ['sometimes', 'nullable', 'array'],
            'priority' => ['sometimes', 'nullable', 'string', Rule::in(PriorityEnum::cases())],
            'status' => ['sometimes', Rule::in(TaskStatus::cases())],
            'ttl' => ['sometimes','nullable','integer', 'min:1', 'prohibited_if:due_date,!null'],
            'due_date' => ['sometimes','nullable', 'date_format:Y-m-d\TH:i', 'after_or_equal:today', 'prohibited_if:ttl,!null'],
        ];
    }
}
