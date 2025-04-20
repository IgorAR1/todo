<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'title' => ['required', 'sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'priority' => ['sometimes','nullable', 'integer', 'in:1,2,3'],//TODO
            'status' => ['sometimes', 'in:pending,in_progress,done,canceled,overdue'],//TODO
            'ttl' => ['sometimes', 'integer', 'min:1'],
            'due_date' => ['sometimes', 'nullable', 'date', 'after_or_equal:today'],
        ];
    }
}
