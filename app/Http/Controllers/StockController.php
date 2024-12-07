<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Helpers\ApiResponseHelper;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $itemsPerPage = $request->input('items_per_page', 10); // Default to 10 items per page
        $page = $request->input('page', 1); // Default to page 1
        $warehouse = $request->input('warehouse');
        $search = $request->input('search');

        $stocks = Stock::latest()->when($search, function($query) use ($search) {
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%');
            });
        });

        if ($warehouse) {
            $stocks->where('warehouse_id', $warehouse);
        }

        $stocks = $stocks->with(['warehouse', 'product'])->paginate($itemsPerPage, ['*'], 'page', $page);

        return ApiResponseHelper::success($stocks, 'Stocks retrieved successfully');
    }
}
