<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Transaction, Stock};
use App\Helpers\ApiResponseHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $itemsPerPage = $request->input('items_per_page', 10); // Default to 10 items per page
        $page = $request->input('page', 1); // Default to page 1
        $search = $request->input('search', 1);

        $transaction = Transaction::latest()
                    ->when($search, function($query) use ($search) {
                        $query->whereHas('product', function ($q) use ($search) {
                            $q->where('name', 'like', '%'.$search.'%');
                        });
                    })
                    ->with(['product', 'warehouse', 'user'])
                    ->paginate($itemsPerPage, ['*'], 'page', $page);

        return ApiResponseHelper::success($transaction, 'Transactions retrieved successfully');
    }

    public function createTransaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_type' => 'required|string|in:in,out',
            'warehouse_id' => 'required|integer',
            'product_id' => 'required|integer',
            'user_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ], [
            'transaction_type.in' => 'The transaction type must be either "in" or "out".',
        ]);
    
        if ($validator->fails()) {
            return ApiResponseHelper::error('Request Validation Error', 422, $validator->errors());
        }

        $stock = Stock::firstOrCreate([
            'warehouse_id' => $request->warehouse_id,
            'product_id' => $request->product_id
        ]);

        DB::beginTransaction();

        try{
            if ($request->transaction_type === 'in') {
                $stock->qty += $request->quantity;
            } else {
                if ($stock->qty < $request->quantity) {
                    return ApiResponseHelper::error('The Product is Out of Stocks', 422);
                    DB::rollBack(); 
                }
                $stock->qty -= $request->quantity;
            }
            $stock->save();
    
            $transaction = Transaction::create([
                'transaction_type' => $request->transaction_type,
                'warehouse_id' => $request->warehouse_id,
                'product_id' => $request->product_id,
                'user_id' => $request->user_id,
            ]);

            DB::commit();
            return ApiResponseHelper::success($transaction, 'Success Create Transaction', 200);
        } catch (\Exception $e) {
            DB::rollBack(); 
            return ApiResponseHelper::error($e->getMessage(), 500);
        }
    }
}
