<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Helpers\ApiResponseHelper;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $itemsPerPage = $request->input('items_per_page', 10); // Default to 10 items per page
        $page = $request->input('page', 1); // Default to page 1
        $search = $request->input('search');

        $products = Product::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        })->paginate($itemsPerPage, ['*'], 'page', $page);

        return ApiResponseHelper::success($products, 'Products retrieved successfully');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return ApiResponseHelper::error('Request Validation Error', 422, $validator->errors());
        }

        $validated = $validator->validated();
        $product = Product::create($validated);
        return ApiResponseHelper::success($product, 'Product created successfully', 201);
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return ApiResponseHelper::error('Product not found', 404);
        }

        return ApiResponseHelper::success($product, 'Product retrieved successfully');
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return ApiResponseHelper::error('Product not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return ApiResponseHelper::error('Request Validation Error', 422, $validator->errors());
        }

        $validated = $validator->validated();
        $product->update($validated);
        return ApiResponseHelper::success($product, 'Product updated successfully');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return ApiResponseHelper::error('Product not found', 404);
        }

        $product->delete();
        return ApiResponseHelper::success([], 'Product deleted successfully');
    }
}
