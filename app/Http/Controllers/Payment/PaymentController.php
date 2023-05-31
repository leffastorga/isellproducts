<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Models\Payment\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payments = $request->user()->payments()->with('method:id,name')->get();
        return $this->sendResponse($payments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        Payment::create([
            'payment_method_id' => $request->payment_method_id,
            'user_id' => Auth::id(),
            'data' => $request->data
        ]);
        Log::info('Email to the customer that added a new payment method');
        return $this->sendResponse('OK');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        if(Auth::id() !== $payment->user_id){
            abort(404);
        }
        return $this->sendResponse($payment);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        if(Auth::id() !== $payment->user_id){
            abort(404); //why am I using 404 instead of 403?
            //answer: https://github.com/orgs/community/discussions/30898
        }
        $payment->delete();
        Log::info('Email to the customer that deleted a payment method');
        return $this->sendResponse('OK');
    }
}
