<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;

class SalesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:product,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // 購入処理の実行
        $result = Sales::processPurchase($request->input('product_id'), $request->input('quantity'));

        // 結果に応じてレスポンスを返却
        if ($result['success']) {
            return response()->json(['success' => $result['message']]);
        } else {
            return response()->json(['error' => $result['message']], 400);
        }
    }
}
