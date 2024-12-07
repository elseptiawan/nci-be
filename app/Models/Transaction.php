<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'transaction_type',
        'warehouse_id',
        'product_id',
        'user_id'
    ];

    public function warehouse() 
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function product() 
    {
        return $this->belongsTo(Product::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
