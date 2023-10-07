<?php

namespace app\models;

use yii\db\ActiveRecord;

class Budget extends ActiveRecord
{
    public static function tableName()
    {
        return 'budget';
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
