<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'company_name',
        'street_address',
        'represeentaive_name'
    ];  

    // メーカー一覧を取得するメソッド
    public static function getAllCompanies()
    {
        return self::pluck('company_name', 'id');
    }
}
