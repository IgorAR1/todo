<?php

namespace App\Http\Requests;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTaskRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['nullable', 'string', Rule::in(PriorityEnum::cases())],
            'status' => ['sometimes', Rule::in(TaskStatus::cases())],
            'tags' => ['nullable', 'array'],
            'shares' => 'nullable|array',
                'shares.*.user_id' => 'required|exists:users,id',
                'shares.*.user_role' => 'required|string|in:editor,observer',
            'ttl' => ['sometimes','nullable','integer', 'min:1', 'prohibited_if:due_date,!null'],
            'due_date' => ['sometimes','nullable', 'date_format:Y-m-d\TH:i', 'after_or_equal:today', 'prohibited_if:ttl,!null'],
        ];
    }
}
