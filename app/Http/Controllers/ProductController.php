<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Companies;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function List(Request $request) {
        $keyword = $request->input('keyword', '');
        $companyId = $request->input('company_id', null);

        // Productモデルのsearchメソッドを使ってデータを取得
        $product = Product::search($keyword, $companyId);

        // companiesテーブルから全てのデータを取得
        $companies = Companies::pluck('company_name', 'id');

        // ビューにデータを渡す
        return view('product_list', ['product' => $product, 'companies' => $companies]);
    }

    public function Regist(Request $request) {
        // 画像ファイルがアップロードされた場合
        if ($request->hasFile('img_path')) {
            // 画像ファイルを指定のパスに保存
            $imagePath = $request->file('img_path');
            $imageName = $imagePath->getClientOriginalName();
            $disk = Storage::build([
                "driver" => "local",
                "root" => public_path("product_docs"),
            ]);
            $disk->putFileAs("",$imagePath,$imageName);
        } else {
            $imageName = null;
        }

        // モデルのメソッドを使って商品を登録
        Product::registerProduct($request->all(), $imageName);

        return redirect()->route('show_Registration');  
    }

    public function ChooseCompanies() {
        $companies = Companies::pluck('company_name', 'id');
        return view('product_Registration', ['companies' => $companies]);
    }

    public function show_details($id) {
        // モデルのメソッドを使って商品詳細を取得
        $product = Product::getProductDetails($id);

        $companies = Companies::pluck('company_name', 'id');

        return view('product_details', ['product' => $product, 'companies' => $companies]);
    }

    public function show_edit($id) {
        // モデルのメソッドを使って商品詳細を取得
        $product = Product::getProductDetails($id);

        $companies = Companies::pluck('company_name', 'id');

        return view('product_edit', ['product' => $product, 'companies' => $companies]);
    }

    public function update(Request $request, $id) {
        // バリデーションルールの追加（必要に応じて調整）
        $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'comment' => 'nullable|string',
            'img_path' => 'nullable',
        ]);

        $imageName = null;
        if ($request->hasFile('img_path')) {
            // 画像ファイルを指定のパスに保存
            $imagePath = $request->file('img_path');
            $imageName = $imagePath->getClientOriginalName();
            $disk = Storage::build([
                "driver" => "local",
                "root" => public_path("product_docs"),
            ]);
            $disk->putFileAs("",$imagePath,$imageName);
        }

        // モデルのメソッドを使って商品を更新
        Product::updateProduct($id, $request->all(), $imageName);

        return redirect()->route('product_edit', ['id' => $id])
                         ->with('success', '商品情報が更新されました');
    }

    public function destroy($id) {
        // モデルのメソッドを使って商品を削除
        Product::deleteProduct($id);

        return redirect()->route('product_list')->with('success', '商品が削除されました');
    }
}
