<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'shares' => 'required|array',
            'shares.*.user_id' => 'required|exists:users,id',
            'shares.*.user_role' => ['required', 'string', Rule::in(RoleEnum::cases())],
        ];
    }
}
