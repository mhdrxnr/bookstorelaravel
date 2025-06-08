<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userID' => 'sometimes|exists:users,user_id',
            'firstName' => 'sometimes|string|max:255',
            'lastName' => 'sometimes|string|max:255',
            'number' => 'sometimes|numeric|min:10',
            'wilaya' => 'sometimes|string|max:100',
            'address' => 'nullable|string',
        ];
    }
}
