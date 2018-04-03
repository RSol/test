<?php

use yii\db\Migration;

/**
 * Class m180402_133622_notify_alert
 */
class m180402_133622_notify_alert extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notify_alert}}', [
            'id' => $this->primaryKey(),
            'model_id' => $this->integer(),
            'message' => $this->text(),
        ]);

        $this->createTable('{{%notify_alert_process}}', [
            'id' => $this->primaryKey(),
            'notify_alert_id' => $this->integer(),
            'user_id' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(1),
        ]);
        $this->addForeignKey('{{%fk_user_notify_alert_process}}', '{{%notify_alert_process}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk_user_notify_alert}}', '{{%notify_alert_process}}', 'notify_alert_id', '{{%notify_alert}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%notify_alert_process}}');
        $this->dropTable('{{%notify_alert}}');
    }
}
