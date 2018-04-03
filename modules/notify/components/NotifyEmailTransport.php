<?php

namespace app\modules\notify\components;


use app\models\News;
use app\models\Profile;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

class NotifyEmailTransport implements NotifyTransportInterface
{
    /**
     * @param $model News
     */
    public function run($model)
    {
        if (!$model instanceof News) {
            return;
        }
        if (!$model->status) {
            return;
        }

        $url = Url::toRoute(['news/view', 'id' => $model->id], true);

        $profileQuery = Profile::find()
            ->where([
                'is_notify_email' => Profile::NOTIFY_ENABLE,
            ])
            ->joinWith('user');
        foreach ($profileQuery->batch() as $profiles) {
            $messages = [];

            /** @var Profile $profile */
            foreach ($profiles as $profile) {
                /** @var User $user */
                $user = $profile->user;
                $messages[] = \Yii::$app->mailer->compose()
                    ->setFrom(\Yii::$app->params['notifyEmail'])
                    ->setTo($user->email)
                    ->setSubject('New news')
                    ->setTextBody('New news ' . $model->title . ' (' . $url . ')')
                    ->setHtmlBody(\Yii::t('news', 'New news {link}', [
                        'link' => Html::a($model->title, $url, [])
                    ]));
            }

            \Yii::$app->mailer->sendMultiple($messages);
        }
    }
}
