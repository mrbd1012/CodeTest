<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function productImages(){
        $this->hasMany('App\Models\ProductImage', 'product_id', 'id');
    }

    public function category(){
        $this->hasOne('App\Models\Category', 'category_id', 'id');
    }
}
