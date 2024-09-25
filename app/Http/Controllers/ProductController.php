<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProductController extends Controller
{
    // 商品一覧の表示
    public function List(Request $request) {
        $keyword = $request->input('keyword', '');
        $companyId = $request->input('company_id', null);

        // ProductモデルのsearchWithCompaniesメソッドを使ってデータ取得
        $products = Product::searchWithCompanies($keyword, $companyId);
        $companies = Product::getUniqueCompanies()->pluck('company_name', 'company_id');

        return view('product_list', ['products' => $products, 'companies' => $companies]);
    }

    // 新規登録処理
    public function Regist(ProductRequest $request) {
        DB::beginTransaction();
        try {
            if ($request->hasFile('img_path')) {
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

            Product::registerProduct($request->all(), $imageName);
            DB::commit();

            return redirect()->route('show_Registration')->with('success', '商品が登録されました');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('show_Registration')->withErrors('登録中にエラーが発生しました: ' . $e->getMessage());
        }
    }

    // 新規登録画面の表示
    public function ChooseCompanies() {
        $companies = Product::getUniqueCompanies()->pluck('company_name', 'company_id');
        return view('product_registration', compact('companies'));
    }

    // 商品詳細表示
    public function show_details($id) {
        $product = Product::getProductDetails($id);
        return view('product_details', compact('product'));
    }

    // 商品編集画面の表示
    public function show_edit($id) {
        $product = Product::getProductDetails($id);
        $companies = Product::getUniqueCompanies()->pluck('company_name', 'company_id');
        return view('product_edit', compact('product', 'companies'));
    }

    // 商品の更新処理
    public function update(ProductRequest $request, $id) {
        DB::beginTransaction();
        try {
            $imageName = null;
            if ($request->hasFile('img_path')) {
                $imagePath = $request->file('img_path');
                $imageName = $imagePath->getClientOriginalName();
                $disk = Storage::build([
                    "driver" => "local",
                    "root" => public_path("product_docs"),
                ]);
                $disk->putFileAs("", $imagePath, $imageName);
            }

            Product::updateProduct($id, $request->all(), $imageName);
            DB::commit();

            return redirect()->route('product_edit', ['id' => $id])->with('success', '商品情報が更新されました');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('product_edit', ['id' => $id])->withErrors('更新中にエラーが発生しました: ' . $e->getMessage());
        }
    }

    // 商品削除処理
    public function destroy($id) {
        DB::beginTransaction();
        try {
            Product::deleteProduct($id);
            DB::commit();

            return redirect()->route('product_list')->with('success', '商品が削除されました');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('product_list')->withErrors('削除中にエラーが発生しました: ' . $e->getMessage());
        }
    }
}
