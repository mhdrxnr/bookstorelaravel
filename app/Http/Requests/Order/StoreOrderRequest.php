<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'user_id' => 'required|exists:users,user_id',
            'totalPrice' => 'required|numeric',
            'status' => 'required|in:pending,completed,canceled',
            'books' => 'required|array',
            'books.*.bookID' => 'required|exists:books,book_id',
            'books.*.quantity' => 'required|integer|min:1',
            'books.*.unitPrice' => 'required|numeric'
        ];
    }
}
