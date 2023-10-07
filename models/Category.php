<?php

namespace app\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'categories';
    }

    public function getProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }

    public function getBudgets()
    {
        return $this->hasMany(Budget::class, ['product_id' => 'id'])
            ->via('products');
    }
}