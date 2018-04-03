<?php

use yii\db\Migration;

/**
 * Class m180403_100050_profile_notify
 */
class m180403_100050_profile_notify extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%profile}}', 'is_notify_alert', $this->smallInteger()->defaultValue(1));
        $this->addColumn('{{%profile}}', 'is_notify_email', $this->smallInteger()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%profile}}', 'is_notify_alert');
        $this->dropColumn('{{%profile}}', 'is_notify_email');
    }
}
