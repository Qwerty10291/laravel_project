<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * @property $id
 * @property $name
 * @property $products_count
 * @property $created_at
 * @property $updated_at
 *
 * @property CategoryProduct[] $categoryProducts
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Category extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'products_count'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoryProducts()
    {
        return $this->hasMany(\App\Models\Product::class, 'id', 'category_id');
    }
    
}
