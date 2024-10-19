<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class Sales extends Model
{
    use HasFactory;
    
    protected $table = 'sales';

    protected $fillable = [
        'product_id',
        'quantity',
        'sale_date'
    ];  

    /**
     * Productモデルとのリレーション
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * 購入処理を行う
     */
    public static function processPurchase($productId, $quantity)
    {
        DB::beginTransaction();
        try {
            // 商品情報を取得
            $product = Product::findOrFail($productId);

            // 在庫の減算処理
            $product->decrementStock($quantity);

            // salesテーブルに購入記録を追加
            self::create([
                'product_id' => $productId,
            ]);

            // トランザクションをコミット
            DB::commit();

            return ['success' => true, 'message' => '購入が完了しました。'];
        } catch (\Exception $e) {
            // エラーが発生した場合、トランザクションをロールバック
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
