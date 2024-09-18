<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProductController extends Controller
{
    public function List(Request $request) {
        $keyword = $request->input('keyword', '');
        $companyId = $request->input('company_id', null);

        // ProductモデルのsearchWithCompaniesメソッドを使って、companiesテーブルとproductテーブルを結合してデータを取得
        $products = Product::searchWithCompanies($keyword, $companyId);

        // companiesテーブルから全てのデータを取得する代わりに、結合した情報からユニークなcompany_idとcompany_nameを取得
        $companies = Product::getUniqueCompanies()->pluck('company_name', 'company_id');

        // ビューにデータを渡す
        return view('product_list', ['products' => $products, 'companies' => $companies]);
    }

    public function Regist(Request $request) {
        // バリデーションルールの追加（必須項目に関するチェック）
        $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id', // メーカーIDが存在するか確認
            'price' => 'required|numeric|min:0', // 価格は数値で、0以上であること
            'stock' => 'required|integer|min:0', // 在庫は整数で、0以上であること
        ]);

        DB::beginTransaction(); // トランザクション開始
        try {
            // 画像ファイルがアップロードされた場合
            if ($request->hasFile('img_path')) {
                // 画像ファイルを指定のパスに保存
                $imagePath = $request->file('img_path');
                $imageName = $imagePath->getClientOriginalName();
                $disk = Storage::build([
                    "driver" => "local",
                    "root" => public_path("product_docs"),
                ]);
                $disk->putFileAs("", $imagePath, $imageName);
            } else {
                $imageName = null;
            }

            // 商品を登録
            Product::registerProduct($request->all(), $imageName);

            DB::commit(); // 問題がなければコミット
            return redirect()->route('show_Registration');
        } catch (Exception $e) {
            DB::rollBack(); // エラーがあったらロールバック
            return redirect()->route('show_Registration')
                             ->withErrors('登録中にエラーが発生しました: ' . $e->getMessage());
        }
    }

    public function ChooseCompanies() {
        // モデルのメソッドを呼び出し、ユニークなcompany情報を取得
        $companies = Product::getUniqueCompanies()->pluck('company_name', 'company_id');

        return view('product_Registration', ['companies' => $companies]);
    }

    public function show_details($id) {
        // モデルのメソッドを使って商品詳細を取得
        $product = Product::getProductDetails($id);

        // companies の情報を product 結合から取得
        $companies = Product::getUniqueCompanies()->pluck('company_name', 'company_id');

        return view('product_details', ['product' => $product, 'companies' => $companies]);
    }

    public function show_edit($id) {
        // モデルのメソッドを使って商品詳細を取得
        $product = Product::getProductDetails($id);

        // companies の情報を product 結合から取得
        $companies = Product::getUniqueCompanies()->pluck('company_name', 'company_id');

        return view('product_edit', ['product' => $product, 'companies' => $companies]);
    }

    public function update(Request $request, $id) {
        // バリデーションルールの追加（新規登録と同じルール）
        $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        DB::beginTransaction(); // トランザクション開始
        try {
            $imageName = null;
            if ($request->hasFile('img_path')) {
                // 画像ファイルを指定のパスに保存
                $imagePath = $request->file('img_path');
                $imageName = $imagePath->getClientOriginalName();
                $disk = Storage::build([
                    "driver" => "local",
                    "root" => public_path("product_docs"),
                ]);
                $disk->putFileAs("", $imagePath, $imageName);
            }

            // 商品を更新
            Product::updateProduct($id, $request->all(), $imageName);

            DB::commit(); // 問題がなければコミット
            return redirect()->route('product_edit', ['id' => $id])
                             ->with('success', '商品情報が更新されました');
        } catch (Exception $e) {
            DB::rollBack(); // エラーがあったらロールバック
            return redirect()->route('product_edit', ['id' => $id])
                             ->withErrors('更新中にエラーが発生しました: ' . $e->getMessage());
        }
    }

    public function destroy($id) {
        DB::beginTransaction(); // トランザクション開始
        try {
            // 商品を削除
            Product::deleteProduct($id);

            DB::commit(); // 問題がなければコミット
            return redirect()->route('product_list')->with('success', '商品が削除されました');
        } catch (Exception $e) {
            DB::rollBack(); // エラーがあったらロールバック
            return redirect()->route('product_list')
                             ->withErrors('削除中にエラーが発生しました: ' . $e->getMessage());
        }
    }
}
