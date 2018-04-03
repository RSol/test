<?php
/**
 * Created by PhpStorm.
 * User: rsol
 * Date: 02.04.18
 * Time: 17:14
 */

namespace app\modules\notify\widgets;


use app\models\News;
use app\models\User;
use app\modules\notify\assets\NotifyAsset;
use yii\bootstrap\Alert;
use yii\bootstrap\Widget;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class NotifyAlert extends Widget
{
    public $maxCount = 5;

    public function run()
    {
        if (\Yii::$app->user->isGuest) {
            return;
        }
        $this->fillNew();

        $alerts = (new Query())
            ->select(['nap.id', 'model_id', 'message'])
            ->from('{{%notify_alert_process}} AS nap')
            ->leftJoin('{{%notify_alert}} AS na', 'notify_alert_id = na.id')
            ->where([
                'user_id' => \Yii::$app->user->id,
                'status' => 1,
            ])
            ->limit($this->maxCount)
            ->orderBy('id')
            ->all();

        $this->process($alerts);
    }

    public function process($alerts)
    {
        if (!is_array($alerts)) {
            return;
        }

        NotifyAsset::register(\Yii::$app->view);

        $news = News::find()
            ->where([
                'id' => ArrayHelper::getColumn($alerts, 'model_id')
            ])
            ->indexBy('id')
            ->all();

        foreach ($alerts as $alert) {
            /** @var News $model */
            if (!$model = ArrayHelper::getValue($news, $alert['model_id'])) {
                continue;
            }
            $message = \Yii::t('news', $alert['message'], [
                'link' => Html::a($model->title, ['news/view', 'id' => $model->id], [
                    'class' => 'alert-link'
                ])
            ]);
            echo Alert::widget([
                'body' => $message,
                'closeButton' => [],
                'options' => [
                    'id' => 'notify-alert-' . $alert['id'],
                    'class' => 'alert-info notify-alert',
                    'data-id' => $alert['id'],
                ],
            ]);
        }
    }

    /**
     * @throws \yii\db\Exception
     */
    private function fillNew()
    {
        /** @var User $user */
        $user = \Yii::$app->user->identity;
        if (!$user->profile->is_notify_alert) {
            return;
        }
        $newNotifies = (new Query())
            ->select(['na.id', new Expression(\Yii::$app->user->id . ' AS user_id')])
            ->from('{{%notify_alert}} AS na')
            ->leftJoin('{{%notify_alert_process}} AS nap', 'notify_alert_id = na.id')
            ->where([
                'user_id' => null,
            ])
            ->all();
        if (!$newNotifies) {
            return;
        }
        \Yii::$app->db->createCommand()
            ->batchInsert('{{%notify_alert_process}}', ['notify_alert_id', 'user_id'], $newNotifies)
            ->execute();
    }
}