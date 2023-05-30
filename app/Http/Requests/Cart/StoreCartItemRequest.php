<?php

namespace App\Http\Requests\Cart;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCartItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return ($this->user()->id === $this->cart->user_id); //only can add items to my cart
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('cart_items')->where(fn (Builder $query) => $query->where('cart_id', '=', $this->cart->id))
                //product_id can't be duplicated in the same cart
            ],
            'quantity' => 'required|numeric|min:1'
        ];
    }
}
