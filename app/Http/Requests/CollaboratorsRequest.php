<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollaboratorsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'users'=> 'required|array',
                'users.*.id' => 'required|exists:users,id',
                'users.*.role' => 'required|string|in:editor,observer',
        ];
    }
}
