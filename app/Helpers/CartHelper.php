<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class CartHelper extends Base {


    public function updateCart($cart): bool{
        try {
            $total = 0.00;
            $items = $cart->items()->get();
            if($items->count() > 0){
                foreach ($items as $item){
                    $total = $total + ($item->quantity * $item->product->price);
                }
            }

            $cart->update(['total' => $total]);
            return true;
        } catch (\Throwable $throwable){
            $detail = $this->createDetails($throwable, $cart);
            Log::critical('Error updating cart', $detail);
            //EMAIL TO ADMINS THAT SOMETHING IS WRONG
            return false;
        }
    }

    public function copyCartToOrder($cart, $order): bool{
        try {
            $items = $cart->items()->with('product')->get();
            foreach ($items as $item){
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price_unit' => $item->product->price,
                    'price_total' => ($item->quantity * $item->product->price)
                ]);
            }
            //after copy to orden, then clean the cart
            $cart->items()->delete();
            $cart->update(['total' => 0.00]);
            return true;
        } catch (\Throwable $throwable){
            $detail = $this->createDetails($throwable, $cart);
            Log::critical('Error copying cart to order', $detail);
            //EMAIL TO ADMINS THAT SOMETHING IS WRONG
            return false;
        }
    }
}
