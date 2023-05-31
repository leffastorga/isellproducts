<?php

namespace App\Http\Controllers\Order;

use App\Helpers\CartHelper;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Order\GetMyOrdersRequest;
use App\Http\Requests\Order\GetOrderRequest;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Cart\Cart;
use App\Models\Order\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends BaseController
{
    protected CartHelper $cartHelper;
    public function __construct(){
        $this->cartHelper = new CartHelper();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetOrderRequest $request)
    {
        $user = $request->user_id;
        $status = $request->status;
        $paginate = $request->paginate ?? 5;
        $sort_by = $request->sort_by ?? 'id';
        $order = $request->order ?? 'DESC';

        $orders = Order::query()->when($user, function ($query) use ($user){
                    return $query->where('user_id', '=', $user);
                })->when($status, function ($query) use ($status){
                    return $query->where('status', '=', $status);
                })->orderByRaw($sort_by . ' ' . $order)
                    ->with(['user:id,first_name,last_name,email', 'items.product'])
                    ->paginate($paginate);

        return $this->sendResponse($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $cart = Cart::find($request->cart_id);
        if($cart->items()->count() === 0){
            return $this->sendError('EMPTY_CART');
        }
        $order = Order::create([
            'uuid' => Str::uuid(),
            'user_id' => Auth::id(),
            'payment_id' => $request->payment_id,
            'total' => $cart->total,
            'status' => 'PENDING'
        ]);
        if(!$this->cartHelper->copyCartToOrder($cart, $order)){
            return $this->sendError('ERROR_CHECKOUT', '', 422);
        }
        Log::info('email send to customer and admins ecommerce - NEW ORDER');
        return $this->sendResponse($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return $this->sendResponse($order->load('items.product'));
    }

    public function update(UpdateOrderRequest $request, Order $order){
        $order->update(['status' => $request->status]);
        if($request->status === 'PAID'){
            Log::info('Email to the user that order has been successfully processed.');
        }
        return $this->sendResponse($order);
    }


    public function myOrders(GetMyOrdersRequest $request){
        $status = $request->status;
        $paginate = $request->paginate ?? 5;
        $sort_by = $request->sort_by ?? 'id';
        $order = $request->order ?? 'DESC';
        $orders = $request->user()
                            ->orders()
                            ->when($status, function ($query) use ($status){
                                    return $query->where('status', '=', $status);
                                })->orderByRaw($sort_by . ' ' . $order)
                                    ->with(['items.product'])
                                    ->paginate($paginate);

        return $this->sendResponse($orders);
    }
}
