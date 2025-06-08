<?php

namespace App\Http\Requests\OrderDetail;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderDetailRequest extends FormRequest
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
            'orderID' => 'required|exists:orders,order_id',
            'bookID' => 'required|exists:books,book_id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ];
    }
}
