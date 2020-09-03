<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public function product(){
        $this->hasOne('App\Models\Product', 'product_id', 'id');
    }
}
