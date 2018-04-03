<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * @inheritdoc
 * @property integer $is_notify_alert
 * @property integer $is_notify_email
 */
class Profile extends \dektrium\user\models\Profile
{
    const NOTIFY_ENABLE = 1;
    const NOTIFY_DISABLED = 0;

    public function rules()
    {
        $rules = parent::rules();
        return ArrayHelper::merge([
            'is_notify_alert' => ['is_notify_alert', 'in', 'range' => array_keys(static::notifyList())],
            'is_notify_email' => ['is_notify_email', 'in', 'range' => array_keys(static::notifyList())],
        ], $rules);
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        return ArrayHelper::merge([
            'is_notify_alert' => \Yii::t('news', 'Notify by alert'),
            'is_notify_email' => \Yii::t('news', 'Notify by e-mail'),
        ], $labels);
    }

    public static function notifyList()
    {
        return [
            static::NOTIFY_DISABLED => 'Disable',
            static::NOTIFY_ENABLE => 'Enable',
        ];
    }
}
