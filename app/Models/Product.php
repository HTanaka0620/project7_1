<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Models\Sales;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path'
    ];

    /**
     * Saleモデルとのリレーション
     */
    public function sales()
    {
        return $this->hasMany(Sales::class, 'product_id');
    }

    /**
     * 在庫の減算
     */
    public function decrementStock($quantity)
    {
        if ($this->stock < $quantity) {
            throw new \Exception("在庫が不足しています (商品ID: {$this->id}, 在庫: {$this->stock})。");
        }

        $this->decrement('stock', $quantity);
        $this->save();
    }

    /**
     * 商品検索と会社情報の結合
     */
    public static function searchWithCompanies($keyword = '', $companyId = null, $priceMin = null, $priceMax = null, $stockMin = null, $stockMax = null){
        return self::join('companies', 'product.company_id', '=', 'companies.id')
            ->select(
                'product.id', 
                'product.product_name', 
                'product.price', 
                'product.stock', 
                'product.comment', 
                'product.img_path', 
                'companies.company_name',
                'companies.id as company_id'
            )
            ->when($keyword, function ($query, $keyword) {
                return $query->where('product.product_name', 'like', "%{$keyword}%");
            })
            ->when($companyId, function ($query, $companyId) {
                return $query->where('product.company_id', $companyId);
            })
            ->when($priceMin, function ($query, $priceMin) {
                return $query->where('product.price', '>=', $priceMin);
            })
            ->when($priceMax, function ($query, $priceMax) {
                return $query->where('product.price', '<=', $priceMax);
            })
            ->when($stockMin, function ($query, $stockMin) {
                return $query->where('product.stock', '>=', $stockMin);
            })
            ->when($stockMax, function ($query, $stockMax) {
                return $query->where('product.stock', '<=', $stockMax);
            });
    }
            
    /**
     * ユニークな会社情報を取得
     */
    public static function getUniqueCompanies() {
        return self::join('companies', 'product.company_id', '=', 'companies.id')
                   ->select('companies.company_name', 'companies.id as company_id')
                   ->distinct()
                   ->get();
    }

    /**
     * 商品を登録する
     */
    public static function registerProduct(array $data, $imageName = null)
    {
        self::create([
            "company_id" => $data['company_id'],  
            "product_name" => $data['product_name'],
            "price" => $data['price'],  
            "stock" => $data['stock'],  
            "comment" => $data['comment'],  
            "img_path" => $imageName,    
        ]);
    }

    /**
     * 商品の詳細を取得
     */
    public static function getProductDetails($id)
    {
        return self::join('companies', 'product.company_id', '=', 'companies.id')
            ->select(
                'product.id', 
                'product.product_name', 
                'product.price', 
                'product.stock', 
                'product.comment', 
                'product.img_path', 
                'companies.company_name', 
                'product.company_id'
            )
            ->where('product.id', $id)
            ->first();
    }

    /**
     * 商品の更新
     */
    public static function updateProduct($id, array $data, $imageName = null)
    {
        $updateData = [
            'product_name' => $data['product_name'],
            'company_id' => $data['company_id'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'comment' => $data['comment'],
            'updated_at' => now(),
        ];

        if ($imageName) {
            $updateData['img_path'] = $imageName;
        }

        self::where('id', $id)->update($updateData);
    }

    /**
     * 商品の削除
     */
    public static function deleteProduct($id) {
        $product = self::find($id);

        if ($product) {
            $product->delete();
            Log::info("商品ID {$id} を削除しました。");
            return true;
        } else {
            Log::error("削除失敗。商品ID {$id} が存在しません。");
            return false;
        }
    }
}
