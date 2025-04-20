<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'priority' => ['nullable', 'integer', 'in:1,2,3'],//TODO :)
            'status' => ['in:pending,in_progress,done,canceled,overdue'],//TODO
            'ttl' => ['integer', 'min:1', 'prohibited_if:due_date,!null'],
            'due_date' => ['nullable', 'date', 'after_or_equal:today', 'prohibited_if:ttl,!null'],
        ];
    }
}
