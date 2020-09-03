<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Category extends Model
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


    // this relationship will only return one level of child items
    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }

    // This is method where we implement recursive relationship
    public function childCategories()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id')->with('categories');
    }

    public function products(){
       return $this->hasMany('App\Models\Product', 'category_id', 'id');
    }
}
