<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%budget}}`.
 */
class m231007_175919_create_budget_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%budget}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'January' => $this->decimal(10, 2)->defaultValue(0.00),
            'February' => $this->decimal(10, 2)->defaultValue(0.00),
            'March' => $this->decimal(10, 2)->defaultValue(0.00),
            'April' => $this->decimal(10, 2)->defaultValue(0.00),
            'May' => $this->decimal(10, 2)->defaultValue(0.00),
            'June' => $this->decimal(10, 2)->defaultValue(0.00),
            'July' => $this->decimal(10, 2)->defaultValue(0.00),
            'August' => $this->decimal(10, 2)->defaultValue(0.00),
            'September' => $this->decimal(10, 2)->defaultValue(0.00),
            'October' => $this->decimal(10, 2)->defaultValue(0.00),
            'November' => $this->decimal(10, 2)->defaultValue(0.00),
            'December' => $this->decimal(10, 2)->defaultValue(0.00),
        ]);

        $this->addForeignKey(
            'fk-budget-product_id',
            '{{%budget}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-budget-product_id', '{{%budget}}');
        $this->dropTable('{{%budget}}');
    }
}
