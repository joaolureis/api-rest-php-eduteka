<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the data to be validated from the request.
     */
    public function validationData(): array
    {
        return array_merge($this->all(), [
            'user' => $this->route('user'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');

        if (! User::whereKey($userId)->exists()) {
            return [
                'user' => 'required|exists:users,id',
            ];
        }

        return [
            'user' => 'required|exists:users,id',
            'name' => 'required',
            'email' => "required|email|unique:users,email,{$userId}",
            'date_of_birth' => 'required|date|before:today',
        ];
    }

    public function messages(): array
    {
        return [
            'user.exists' => 'Usuário não encontrado.',
        ];
    }
}
