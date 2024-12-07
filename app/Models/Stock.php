<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'warehouse_id',
        'product_id',
        'qty'
    ];

    protected $attributes = [
        'qty' => 0,
    ];

    public function warehouse() 
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function product() 
    {
        return $this->belongsTo(Product::class);
    }
}
