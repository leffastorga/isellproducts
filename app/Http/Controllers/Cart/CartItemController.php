<?php

namespace App\Http\Controllers\Cart;

use App\Helpers\CartHelper;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Cart\StoreCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;

class CartItemController extends BaseController
{

    protected CartHelper $cartHelper;
    public function __construct(){
        $this->cartHelper = new CartHelper();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartItemRequest $request, Cart $cart)
    {
        $cart->items()->create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity
        ]);
        if(!$this->cartHelper->updateCart($cart)){
            return $this->sendError('ERROR_CART', 'Something went wrong updating the cart. Try again.');
        }
        return $this->sendResponse('OK');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemRequest $request, Cart $cart, CartItem $item)
    {
        $item->update(['quantity' => $request->quantity]);
        if(!$this->cartHelper->updateCart($cart)){
            return $this->sendError('ERROR_CART', 'Something went wrong updating the cart. Try again.');
        }
        return $this->sendResponse('OK');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart, CartItem $item)
    {
        $item->delete();
        if(!$this->cartHelper->updateCart($cart)){
            return $this->sendError('ERROR_CART', 'Something went wrong updating the cart. Try again.');
        }
        return $this->sendResponse('OK');
    }
}
