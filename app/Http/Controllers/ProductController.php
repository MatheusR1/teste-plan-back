<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductResquest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('brand')->orderBy('id')->get();

        return $this->sendResponse($products, 'products found');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
       $productCreate =  Product::create($request->all());

       if ($productCreate) {
           return $this->sendResponse($productCreate, 'products Created successfully', 201);
       }

       return $this->sendError($productCreate, 'Failed to store product', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateProductResquest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductResquest $request, Product $product)
    {        
        $updated = $product->updateOrFail($request->all());

        if ($updated) return $this->sendResponse($updated, 'updated successfully');

        return $this->sendError($updated, 'update failed', 500);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $status = $product->deleteOrFail();

        if (!$status) {
           return $this->sendResponse($status, 500);
        }

        return $this->sendResponse($status, 'product deleted');
    }
}
