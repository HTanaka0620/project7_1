<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'product_id',
        'sale_date'
    ];

    /**
     * Productモデルとのリレーション
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
