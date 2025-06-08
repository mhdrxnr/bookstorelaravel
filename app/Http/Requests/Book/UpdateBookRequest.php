<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'title'=>'sometimes|string|min:10|max:50',
            'author'=>'sometimes|string|min:10|max:50',
            'price'=>'sometimes|numeric|min:0',
            'description'=>'nullable|string|min:30|max:100',
            'categoryID'=>'exists:categories,category_id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ];
    }
}
