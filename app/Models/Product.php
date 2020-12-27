<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $fillable = ['photo','purchase_price','sale_price','stock','category_id'];

    public $translatedAttributes = ['product_name','description'];

    protected $appends = ['file_path', 'profit_percent'];

    public function getFilePathAttribute()
    {
        return 'uploads/products/'. $this->photo;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function getProfitPercentAttribute()
    {
        $increas = $this->sale_price - $this->purchase_price; //الفرق بين الرقمين
        return $res = number_format($increas / $this->purchase_price * 100,2);
    }
}
