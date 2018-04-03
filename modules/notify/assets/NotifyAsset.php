<?php

namespace app\modules\notify\assets;

use yii\web\AssetBundle;

class NotifyAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/notify/assets';
    public $js = [
        'js/alert-notify.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}