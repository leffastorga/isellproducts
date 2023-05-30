<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('user:id,first_name,last_name')->latest()->paginate(10);
        return $this->sendResponse($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create([
            'code' => Str::random(8),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'created_by' => Auth::id(),
        ]);
        return $this->sendResponse($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->sendResponse($product->load('user:id,first_name,last_name'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'deactivated_at' => ($request->deactivate) ? now() : null
        ]);
        return $this->sendResponse($product->load('user:id,first_name,last_name'));
    }


}
