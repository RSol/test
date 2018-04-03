<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 * @var dektrium\user\models\Profile $profile
 */

$this->title = Yii::t('user', 'Update profile', [
    'nameAttribute' => '' . $user->username,
]);
$this->params['breadcrumbs'][] = Yii::t('user', 'Update profile');
?>
<div class="news-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['profile' => $profile]) ?>

</div>
