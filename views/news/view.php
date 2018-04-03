<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('news', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <? if(Yii::$app->user->can('updateOwnNews', ['news' => $model])): ?>
            <?= Html::a(Yii::t('news', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <? endif; ?>
        <? if(Yii::$app->user->can('admin')): ?>
            <?= Html::a(Yii::t('news', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('news', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <? endif; ?>
    </p>

    <div class="row">
        <div class="col-md-4">
            <?= Html::img($model->getThumbFileUrl('image', 'thumb')) ?>
        </div>
        <div class="col-md-8">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'user.username',
                    [
                        'attribute' => 'description',
                        'format' => 'ntext',
                        'visible' => !Yii::$app->user->isGuest
                    ],
                    'created_at:date',
                ],
            ]) ?>
        </div>
    </div>

</div>
