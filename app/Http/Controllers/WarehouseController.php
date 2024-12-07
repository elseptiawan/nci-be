<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Helpers\ApiResponseHelper;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the warehouses.
     */
    public function index(Request $request)
    {
        $itemsPerPage = $request->input('items_per_page', 10); // Default to 10 items per page
        $page = $request->input('page', 1); // Default to page 1
        $search = $request->input('search'); // Default to page 1

        $warehouses = Warehouse::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        })->paginate($itemsPerPage, ['*'], 'page', $page);

        return ApiResponseHelper::success($warehouses, 'Warehouses retrieved successfully');
    }

    /**
     * Store a newly created warehouse in storage.
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
        $warehouse = Warehouse::create($validated);
        return ApiResponseHelper::success($warehouse, 'Warehouse created successfully', 201);
    }

    /**
     * Display the specified warehouse.
     */
    public function show($id)
    {
        $warehouse = Warehouse::find($id);

        if (!$warehouse) {
            return ApiResponseHelper::error('Warehouse not found', 404);
        }

        return ApiResponseHelper::success($warehouse, 'Warehouse retrieved successfully');
    }

    /**
     * Update the specified warehouse in storage.
     */
    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::find($id);

        if (!$warehouse) {
            return ApiResponseHelper::error('Warehouse not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return ApiResponseHelper::error('Request Validation Error', 422, $validator->errors());
        }

        $validated = $validator->validated();
        $warehouse->update($validated);
        return ApiResponseHelper::success($warehouse, 'Warehouse updated successfully');
    }

    /**
     * Remove the specified warehouse from storage.
     */
    public function destroy($id)
    {
        $warehouse = Warehouse::find($id);

        if (!$warehouse) {
            return ApiResponseHelper::error('Warehouse not found', 404);
        }

        $warehouse->delete();
        return ApiResponseHelper::success([], 'Warehouse deleted successfully');
    }
}
