<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * 商品検索と会社情報の結合
     *
     * @param string $keyword 商品名検索キーワード
     * @param int|null $companyId メーカーID（nullの場合は全メーカ検索）
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchWithCompanies($keyword = '', $companyId = null){
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
            ->get();
    }

    /**
     * ユニークな会社情報を取得
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getUniqueCompanies() {
        return self::join('companies', 'product.company_id', '=', 'companies.id')
                   ->select('companies.company_name', 'companies.id as company_id')
                   ->distinct()
                   ->get();
    }

    /**
     * 商品を登録する
     *
     * @param array $data 登録する商品のデータ
     * @param string|null $imageName 画像のパス
     * @return void
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
     *
     * @param int $id
     * @return Model|null
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
     *
     * @param int $id
     * @param array $data 更新するデータ
     * @param string|null $imageName 画像のパス
     * @return void
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
     *
     * @param int $id
     * @return void
     */
    public static function deleteProduct($id){
        self::where('id', $id)->delete();
    }
}
