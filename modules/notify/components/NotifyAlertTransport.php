<?php

namespace app\modules\notify\components;


use app\models\News;

class NotifyAlertTransport implements NotifyTransportInterface
{
    /**
     * @param $model News
     * @throws \yii\db\Exception
     */
    public function run($model)
    {
        if (!$model instanceof News) {
            return;
        }
        if (!$model->status) {
            return;
        }

        \Yii::$app->db->createCommand()
            ->insert('{{%notify_alert}}', [
                'model_id' => $model->id,
                'message' => 'New news {link}',
            ])->execute();
    }
}
