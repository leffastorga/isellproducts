<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class CartController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->sendResponse($request->user()->cart);
    }
}
