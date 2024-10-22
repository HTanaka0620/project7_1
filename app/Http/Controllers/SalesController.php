<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'product_id' => 'required|exists:product,id',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction(); // トランザクション開始

        try {
            // 商品の在庫管理は Product モデルで処理
            $product = Product::findOrFail($request->input('product_id'));
            $product->decrementStock($request->input('quantity'));

            // 購入記録の追加は Sales モデルで処理
            Sales::create([
                'product_id' => $request->input('product_id'),
            ]);

            // トランザクションをコミット
            DB::commit();

            return response()->json(['success' => '購入が完了しました。']);
        } catch (\Exception $e) {
            // エラーが発生した場合、トランザクションをロールバック
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
