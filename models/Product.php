<?php

namespace app\models;

use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public static function tableName()
    {
        return 'products';
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getBudgets()
    {
        return $this->hasMany(Budget::class, ['product_id' => 'id']);
    }
}