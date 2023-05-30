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
            return false;
        }
    }
}
