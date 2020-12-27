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

    protected $fillable = ['photo','purchase_price','sale_price','stock'];

    public $translatedAttributes = ['product_name','description'];

    protected $appends = ['file_path'];

    public function getFilePathAttribute()
    {
        return 'uploads/products/'. $this->photo;
    }
}
