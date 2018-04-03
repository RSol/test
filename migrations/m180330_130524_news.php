<?php

use yii\db\Migration;

/**
 * Class m180330_130524_news
 */
class m180330_130524_news extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'title' => $this->string(255),
            'description' => $this->text(),
            'image' => $this->string(255),
            'status' => $this->smallInteger(),
            'created_at' => $this->date(),
        ]);

        $this->addForeignKey('{{%fk_user_news}}', '{{%news}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}
